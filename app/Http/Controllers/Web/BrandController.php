<?php

namespace App\Http\Controllers\Web;

use App\Models\Brand;
use Illuminate\Http\Request;
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

        $items = Brand::query()->where('is_active', true)->orderBy('sort_order')->paginate(24);
        return view('pages.brands.index', compact('items'));
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
            'sort'
        ]);
        $filters['brand_id'] = $brand->id;

        $list = $this->products->catalog($filters);

        return view(
            'pages.brands.show',
            compact(
                'brand',
                'list',
                'schemaJsonLd'
            )
        );
    }
}
