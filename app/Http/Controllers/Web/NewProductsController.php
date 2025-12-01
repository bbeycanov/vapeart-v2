<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Contracts\ProductServiceInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NewProductsController extends Controller
{
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

        // Sort by newest first
        $filters['sort'] = $filters['sort'] ?? 'created_desc';

        $page = $request->get('page', 1);
        $list = $this->products->catalog($filters, perPage: 24, page: $page);

        // Always return full page - JavaScript will parse it if needed
        return view('pages.new-products.index', compact('list'));
    }
}

