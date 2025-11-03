<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\BlogController;
use App\Http\Controllers\Web\MenuController;
use App\Http\Controllers\Web\BrandController;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Web\BannerController;
use App\Http\Controllers\Web\ReviewController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\CategoryController;

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
    Route::get('pages/{slug}', [PageController::class, 'show'])->name('pages.show');

    // Blog
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

    // Menus
    Route::get('/menus/{position}', [MenuController::class, 'byPosition'])->name('menus.byPosition');

    // Banners
    Route::get('/banners/{position}', [BannerController::class, 'byPosition'])->name('banners.byPosition');
    Route::get('/banner/key/{key}',   [BannerController::class, 'showByKey'])->name('banners.byKey');

    // Products
    Route::get('/products',            [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}',  [ProductController::class, 'show'])->name('products.show');

    // Categories
    Route::get('/categories',          [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category}',[CategoryController::class, 'show'])->name('categories.show');

    // Brands
    Route::get('/brands',              [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/{brand}',      [BrandController::class, 'show'])->name('brands.show');

    // Reviews
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('products.reviews.store');
});
