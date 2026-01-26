<?php

namespace App\Http\Controllers\Web;

use App\Models\Category;
use App\Enums\BannerPosition;
use Illuminate\Http\Request;
use Spatie\SchemaOrg\Schema;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Services\Contracts\BannerServiceInterface;
use App\Services\Contracts\ProductServiceInterface;
use App\Services\Contracts\CategoryServiceInterface;

class CategoryController extends Controller
{
    /**
     * @param CategoryServiceInterface $cats
     * @param ProductServiceInterface $products
     * @param BannerServiceInterface $bannerService
     */
    public function __construct(
        private readonly CategoryServiceInterface $cats,
        private readonly ProductServiceInterface  $products,
        private readonly BannerServiceInterface   $bannerService
    )
    {
    }

    /**
     * @param string $locale
     * @param Request $request
     * @return Factory|View
     */
    public function index(string $locale, Request $request): Factory|View
    {
        app()->setLocale($locale);

        $categories = $this->cats->getTree(null);

        $categoriesWithCounts = $categories->map(function ($category) {
            $productCount = $category->products()
                ->where('is_active', true)
                ->count();

            return [
                'category' => $category,
                'product_count' => $productCount
            ];
        });

        $pageBanner = $this->bannerService->byPosition(BannerPosition::CATEGORIES_INDEX_HEADER)->first();

        $schemaJsonLd = $this->buildIndexSchemaFor($categoriesWithCounts);

        return view('pages.categories.index', compact('categoriesWithCounts', 'pageBanner', 'schemaJsonLd'))->with('parentCategory', null);
    }

    /**
     * Build structured data schema for categories index page
     *
     * @param Collection $categoriesWithCounts
     * @return string
     */
    private function buildIndexSchemaFor(Collection $categoriesWithCounts): string
    {
        $locale = app()->getLocale();
        $url = route('categories.index', ['locale' => $locale]);
        $pageTitle = __('navigation.Categories');

        // WebPage Schema
        $webPage = Schema::collectionPage()
            ->name($pageTitle)
            ->url($url)
            ->inLanguage($locale)
            ->description(__('page.Browse all product categories available in our store.'));

        // Breadcrumb Schema
        $breadcrumb = Schema::breadcrumbList()->itemListElement([
            Schema::listItem()->position(1)->name(__('navigation.Home'))->item(route('home', $locale)),
            Schema::listItem()->position(2)->name($pageTitle)->item($url),
        ]);

        // ItemList Schema with categories
        $itemListElements = [];
        $position = 1;

        foreach ($categoriesWithCounts as $item) {
            $category = $item['category'];
            $categoryName = $category->getTranslation('name', $locale);
            $categoryUrl = route('categories.show', ['locale' => $locale, 'category' => $category->slug]);
            $categoryImage = $category->getFirstMediaUrl('icon') ?: asset('storefront/images/category-placeholder.jpg');

            $categorySchema = Schema::thing()
                ->setProperty('@type', 'Thing')
                ->name($categoryName)
                ->url($categoryUrl)
                ->image($categoryImage);

            $itemListElements[] = Schema::listItem()
                ->position($position)
                ->item($categorySchema);

            $position++;
        }

        $itemList = Schema::itemList()
            ->itemListElement($itemListElements)
            ->numberOfItems($categoriesWithCounts->count());

        return $webPage->toScript() . PHP_EOL . $breadcrumb->toScript() . PHP_EOL . $itemList->toScript();
    }

    /**
     * @param string $locale
     * @param Category $category
     * @param Request $request
     * @return Factory|View
     */
    public function show(string $locale, Category $category, Request $request): Factory|View
    {
        app()->setLocale($locale);

        // Load parent relationship for breadcrumb
        $category->load('parent');
        $category->load('media');

        $schemaJsonLd = $this->cats->buildSchemaFor($category);

        // Get child categories if exists
        $childCategories = $category->children()->where('is_active', true)->get();
        $childCategoriesWithCounts = $childCategories->map(function ($cat) {
            $productCount = $cat->products()
                ->where('is_active', true)
                ->count();

            return [
                'category' => $cat,
                'product_count' => $productCount
            ];
        });

        // Get products
        $filters = $request->only([
            'brand_id',
            'tag_id',
            'price_min',
            'price_max',
            'sort'
        ]);
        $filters['category_id'] = $category->id;

        $list = $this->products->catalog($filters);

        $selectedBrandId = $request->get('brand_id');

        $brands = $category->products()
            ->where('is_active', true)
            ->whereNotNull('brand_id')
            ->with('brand')
            ->get()
            ->pluck('brand')
            ->filter()
            ->unique('id')
            ->sortBy(function ($brand) use ($selectedBrandId) {
                // Selected brand comes first, then sort by priority (higher first), then by name
                $priorityPrefix = $selectedBrandId && $brand->id == $selectedBrandId ? '0' : '1';
                // Invert priority so higher values come first (10 becomes 0, 1 becomes 9)
                $priorityValue = 10 - ($brand->priority ?? 10);
                return sprintf('%s_%02d_%s', $priorityPrefix, $priorityValue, $brand->getTranslation('name', app()->getLocale()));
            })
            ->values();

        return view(
            view: 'pages.categories.show',
            data: compact('category', 'list', 'brands', 'schemaJsonLd', 'childCategoriesWithCounts')
        );
    }
}
