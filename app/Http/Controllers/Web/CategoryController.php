<?php

namespace App\Http\Controllers\Web;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Services\Contracts\ProductServiceInterface;
use App\Services\Contracts\CategoryServiceInterface;

class CategoryController extends Controller
{
    /**
     * @param CategoryServiceInterface $cats
     * @param ProductServiceInterface $products
     */
    public function __construct(
        private readonly CategoryServiceInterface $cats,
        private readonly ProductServiceInterface  $products
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

        return view('pages.categories.index', compact('categoriesWithCounts'))->with('parentCategory', null);
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

        $brands = $category->products()
            ->where('is_active', true)
            ->whereNotNull('brand_id')
            ->with('brand')
            ->get()
            ->pluck('brand')
            ->filter()
            ->unique('id')
            ->sortBy(function ($brand) {
                return $brand->getTranslation('name', app()->getLocale());
            })
            ->values();

        return view(
            view: 'pages.categories.show',
            data: compact('category', 'list', 'brands', 'schemaJsonLd', 'childCategoriesWithCounts')
        );
    }
}
