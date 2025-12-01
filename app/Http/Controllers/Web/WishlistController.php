<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use App\Services\Contracts\ProductServiceInterface;

class WishlistController extends Controller
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
     * @return Factory|View
     */
    public function index(string $locale): Factory|View
    {
        app()->setLocale($locale);

        // Get wishlist from localStorage (will be handled by JavaScript)
        // For server-side, we'll return empty collection
        // The actual products will be loaded via JavaScript from localStorage
        $products = collect();

        return view('pages.wishlist.index', compact('products'));
    }
}

