<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Category;
use App\Enums\MenuPosition;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends \Illuminate\Foundation\Support\Providers\RouteServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        parent::boot();

        Route::bind('product', fn($value) => Product::query()->where('slug',$value)->firstOrFail());
        Route::bind('category', fn($value) => Category::query()->where('slug',$value)->firstOrFail());
        Route::bind('brand', fn($value) => Brand::query()->where('slug',$value)->firstOrFail());
        Route::bind('menu', fn($value) => Menu::query()
            ->where('position', MenuPosition::SIDEBAR->value)
            ->where('is_active', true)
            ->where('id', $value)
            ->firstOrFail());
    }
}
