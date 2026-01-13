<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\BlogController;
use App\Http\Controllers\Web\MenuController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\BrandController;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Web\BannerController;
use App\Http\Controllers\Web\ReviewController;
use App\Http\Controllers\Web\SearchController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\DiscountController;
use App\Http\Controllers\Web\WishlistController;
use App\Http\Controllers\Web\QuickViewController;
use App\Http\Controllers\Web\NewProductsController;

Route::get('/', function () {
    $default = (string)config('app.default_locale', config('app.fallback_locale'));
    return redirect()->to(url($default), Response::HTTP_FOUND);
})->name('root.redirect');


Route::group([
    'prefix' => '{locale}',
    'middleware' => ['setLocale'],
], function () {

    // Home
    Route::get('', [HomeController::class, 'index'])->name('home');

    // Static Pages
    Route::get('page/{slug}', [PageController::class, 'show'])->name('pages.show');

    // Blog
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/load-more', [BlogController::class, 'loadMore'])->name('blog.load-more');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

    // Menus
    Route::get('/menus/{position}', [MenuController::class, 'byPosition'])->name('menus.byPosition');
    Route::get('/catalog/{menu}', [MenuController::class, 'brands'])->name('catalog.brands');

    // Banners
    Route::get('/banners/{position}', [BannerController::class, 'byPosition'])->name('banners.byPosition');
    Route::get('/banner/key/{key}',   [BannerController::class, 'showByKey'])->name('banners.byKey');

    // Products
    Route::get('/products',            [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/load-more',   [ProductController::class, 'loadMore'])->name('products.load-more');
    Route::get('/products/{product}',  [ProductController::class, 'show'])->name('products.show');

    // Categories
    Route::get('/category',          [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/category/{category}',[CategoryController::class, 'show'])->name('categories.show');

    // Brands
    Route::get('/brands',              [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/load-more',    [BrandController::class, 'loadMore'])->name('brands.load-more');
    Route::get('/brand/{brand}',      [BrandController::class, 'show'])->name('brands.show');

    // Contacts
    Route::get('/contact',            [ContactController::class, 'index'])->name('contacts.index');
    Route::post('/contact',           [ContactController::class, 'store'])->name('contacts.store');

    // Reviews
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('products.reviews.store');
    Route::post('/blog/{slug}/reviews', [ReviewController::class, 'storeBlog'])->name('blog.reviews.store');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart/branches', [CartController::class, 'getBranches'])->name('cart.branches');

    // Quick View
    Route::get('/quick-view', [QuickViewController::class, 'show'])->name('quick-view.show');

    // Search
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::get('/search/load-more', [SearchController::class, 'loadMore'])->name('search.load-more');
    Route::get('/search/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

    // Discounted Products
    Route::get('/discount', [DiscountController::class, 'index'])->name('discount.index');

    // New Products
    Route::get('/new', [NewProductsController::class, 'index'])->name('new.index');
});
