<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Services\Contracts\ProductServiceInterface;

class NewProductsController extends Controller
{
    /**
     * @param ProductServiceInterface $products
     */
    public function __construct(
        private readonly ProductServiceInterface $products
    )
    {
    }

    /**
     * Display a listing of new products
     *
     * @param string $locale
     * @param Request $request
     * @return Factory|View
     */
    public function index(string $locale, Request $request): Factory|View
    {
        app()->setLocale($locale);

        $filters = $request->only(['sort']);

        $filters['sort'] = $filters['sort'] ?? 'created_desc';

        $page = $request->get('page', 1);

        $list = $this->products->catalog(
            filters: $filters,
            perPage: 24,
            page: $page
        );

        return view('pages.new-products.index', compact('list'));
    }
}

