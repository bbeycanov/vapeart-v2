<?php

namespace App\Http\Controllers\Web;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Services\Contracts\BrandServiceInterface;
use App\Services\Contracts\ProductServiceInterface;

class BrandController extends Controller
{
    /**
     * @param BrandServiceInterface $brands
     * @param ProductServiceInterface $products
     */
    public function __construct(
        private readonly BrandServiceInterface   $brands,
        private readonly ProductServiceInterface $products
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
            ->withCount(['products' => function($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('sort_order')
            ->paginate(24);
            
        return view('pages.brands.index', compact('items'));
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
            ->withCount(['products' => function($query) {
                $query->where('is_active', true);
            }])
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

        // If menu_id is provided, filter products by menu
        $menu = null;
        if ($request->has('menu_id')) {
            $menu = \App\Models\Menu::find($request->get('menu_id'));
            if ($menu) {
                // Get product IDs from menu
                $menuProductIds = $menu->products()->where('is_active', true)->pluck('products.id')->toArray();
                // Add to filters - we'll handle this in ProductService
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
