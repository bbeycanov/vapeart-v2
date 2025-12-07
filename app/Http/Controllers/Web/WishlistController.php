<?php

namespace App\Http\Controllers\Web;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Services\Contracts\ProductServiceInterface;

class WishlistController extends Controller
{
    /**
     * @param ProductServiceInterface $svc
     */
    public function __construct(
        public readonly ProductServiceInterface $svc
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

        $products = collect();

        return view('pages.wishlist.index', compact('products'));
    }
}

