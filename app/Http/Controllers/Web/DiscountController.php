<?php

namespace App\Http\Controllers\Web;

use App\Enums\BannerPosition;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Services\Contracts\BannerServiceInterface;
use App\Services\Contracts\ProductServiceInterface;

class DiscountController extends Controller
{
    /**
     * @param ProductServiceInterface $products
     * @param BannerServiceInterface $bannerService
     */
    public function __construct(
        private readonly ProductServiceInterface $products,
        private readonly BannerServiceInterface  $bannerService
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

        $filters['on_discount'] = true;

        $list = $this->products->catalog($filters);

        if ($request->ajax()) {
            return view('pages.discounts._products_grid', compact('list'));
        }

        $pageBanner = $this->bannerService->byPosition(BannerPosition::DISCOUNTS_INDEX_HEADER)->first();

        return view('pages.discounts.index', compact('list', 'pageBanner'));
    }
}

