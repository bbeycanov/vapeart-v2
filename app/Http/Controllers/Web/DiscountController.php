<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Contracts\ProductServiceInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function __construct(
        private readonly ProductServiceInterface $products
    )
    {
    }

    /**
     * Display a listing of discounted products
     * 
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

        // Add on_discount filter
        $filters['on_discount'] = true;

        $list = $this->products->catalog($filters);

        // If AJAX request, return only products grid
        if ($request->ajax()) {
            return view('pages.discounts._products_grid', compact('list'));
        }

        return view('pages.discounts.index', compact('list'));
    }
}

