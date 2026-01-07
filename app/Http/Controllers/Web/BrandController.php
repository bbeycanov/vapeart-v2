<?php

namespace App\Http\Controllers\Web;

use App\Models\Menu;
use App\Models\Brand;
use App\Enums\BannerPosition;
use Illuminate\Http\Request;
use Spatie\SchemaOrg\Schema;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\Contracts\BrandServiceInterface;
use App\Services\Contracts\BannerServiceInterface;
use App\Services\Contracts\ProductServiceInterface;

class BrandController extends Controller
{
    /**
     * @param BrandServiceInterface $brands
     * @param ProductServiceInterface $products
     * @param BannerServiceInterface $bannerService
     */
    public function __construct(
        private readonly BrandServiceInterface   $brands,
        private readonly ProductServiceInterface $products,
        private readonly BannerServiceInterface  $bannerService
    )
    {
    }

    /**
     * @param string $locale
     * @return Factory|View
     */
    public function index(string $locale): Factory|View
    {
        app()->setLocale($locale);

        $items = Brand::query()
            ->where('is_active', true)
            ->withCount([
                'products' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->orderBy('sort_order')
            ->paginate(24);

        $pageBanner = $this->bannerService->byPosition(BannerPosition::BRANDS_INDEX_HEADER)->first();

        $schemaJsonLd = $this->buildIndexSchemaFor($items);

        return view('pages.brands.index', compact('items', 'pageBanner', 'schemaJsonLd'));
    }

    /**
     * Build structured data schema for brands index page
     *
     * @param LengthAwarePaginator $brands
     * @return string
     */
    private function buildIndexSchemaFor(LengthAwarePaginator $brands): string
    {
        $locale = app()->getLocale();
        $url = route('brands.index', ['locale' => $locale]);
        $pageTitle = __('navigation.Brands');

        // WebPage Schema
        $webPage = Schema::collectionPage()
            ->name($pageTitle)
            ->url($url)
            ->inLanguage($locale)
            ->description(__('page.Browse all brands available in our store.'));

        // Breadcrumb Schema
        $breadcrumb = Schema::breadcrumbList()->itemListElement([
            Schema::listItem()->position(1)->name(__('navigation.Home'))->item(route('home', $locale)),
            Schema::listItem()->position(2)->name($pageTitle)->item($url),
        ]);

        // ItemList Schema with brands
        $itemListElements = [];
        $position = 1;

        foreach ($brands as $brand) {
            $brandName = $brand->getTranslation('name', $locale);
            $brandUrl = route('brands.show', ['locale' => $locale, 'brand' => $brand->slug]);
            $brandLogo = $brand->getFirstMediaUrl('logo') ?: asset('storefront/images/brand-placeholder.jpg');

            $brandSchema = Schema::brand()
                ->name($brandName)
                ->url($brandUrl)
                ->logo($brandLogo);

            $itemListElements[] = Schema::listItem()
                ->position($position)
                ->item($brandSchema);

            $position++;
        }

        $itemList = Schema::itemList()
            ->itemListElement($itemListElements)
            ->numberOfItems($brands->total());

        return $webPage->toScript() . PHP_EOL . $breadcrumb->toScript() . PHP_EOL . $itemList->toScript();
    }

    /**
     * @param string $locale
     * @return JsonResponse
     */
    public function loadMore(string $locale): JsonResponse
    {
        app()->setLocale($locale);
        $page = (int)request('page', 2);

        $items = Brand::query()
            ->where('is_active', true)
            ->withCount([
                'products' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->orderBy('sort_order')
            ->paginate(24, ['*'], 'page', $page);

        $html = view('pages.brands.partials.brand-items', ['items' => $items->items()])->render();

        return response()->json([
            'html' => $html,
            'hasMore' => $items->hasMorePages(),
            'nextPage' => $items->hasMorePages() ? $page + 1 : null
        ]);
    }

    /**
     * @param string $locale
     * @param Brand $brand
     * @param Request $request
     * @return Factory|View
     */
    public function show(string $locale, Brand $brand, Request $request): Factory|View
    {
        app()->setLocale($locale);

        $schemaJsonLd = $this->brands->buildSchemaFor($brand);

        $filters = $request->only([
            'category_id',
            'tag_id',
            'price_min',
            'price_max',
            'sort',
            'menu_id'
        ]);
        $filters['brand_id'] = $brand->id;

        $menu = null;
        if ($request->has('menu_id')) {
            $menu = Menu::find($request->get('menu_id'));
            if ($menu) {
                $menuProductIds = $menu->products()->where('is_active', true)->pluck('products.id')->toArray();
                $filters['menu_product_ids'] = $menuProductIds;
            }
        }

        $list = $this->products->catalog($filters);

        return view(
            'pages.brands.show',
            compact(
                'brand',
                'list',
                'menu',
                'schemaJsonLd'
            )
        );
    }
}
