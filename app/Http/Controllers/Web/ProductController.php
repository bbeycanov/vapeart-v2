<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Services\Contracts\ProductServiceInterface;

class ProductController extends Controller
{
    /**
     * @param ProductServiceInterface $svc
     */
    public function __construct(
        private readonly ProductServiceInterface $svc
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

        $filters = $request->only([
            'brand_id',
            'category_id',
            'tag_id',
            'price_min',
            'price_max',
            'sort'
        ]);
        $products = $this->svc->catalog($filters, perPage: 12);

        return view('pages.products.index', compact('products'));
    }

    /**
     * @param string $locale
     * @param Product $product
     * @return Factory|View
     */
    public function show(string $locale, Product $product): Factory|View
    {
        app()->setLocale($locale);

        $schemaJsonLd = $this->svc->buildSchemaFor($product);

        $related = $product->categories()
            ->with(['products' => fn($q) => $q->where('products.id', '<>', $product->id)->where('is_active', true)->limit(8)])
            ->get()
            ->pluck('products')
            ->flatten()
            ->unique('id')
            ->take(8);

        return view('pages.products.show', compact('product', 'schemaJsonLd', 'related'));
    }
}
