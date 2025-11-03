<?php

namespace App\Providers;

use App\Models\Tag;
use App\Models\Page;
use App\Models\Blog;
use App\Models\Menu;
use App\Models\Brand;
use App\Models\Banner;
use App\Models\Review;
use App\Models\Product;
use App\Models\Category;
use App\Repositories\TagRepository;
use App\Repositories\PageRepository;
use App\Repositories\BlogRepository;
use App\Repositories\MenuRepository;
use App\Repositories\BrandRepository;
use App\Repositories\BannerRepository;
use App\Repositories\ReviewRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\TagRepositoryInterface;
use App\Repositories\Contracts\PageRepositoryInterface;
use App\Repositories\Contracts\BlogRepositoryInterface;
use App\Repositories\Contracts\MenuRepositoryInterface;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\BannerRepositoryInterface;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PageRepositoryInterface::class, fn($app) => new PageRepository(new Page()));
        $this->app->bind(BlogRepositoryInterface::class, fn($app) => new BlogRepository(new Blog()));
        $this->app->bind(MenuRepositoryInterface::class, fn($app) => new MenuRepository(new Menu()));
        $this->app->bind(BannerRepositoryInterface::class, fn($app) => new BannerRepository(new Banner()));
        $this->app->bind(CategoryRepositoryInterface::class, fn() => new CategoryRepository(new Category()));
        $this->app->bind(BrandRepositoryInterface::class, fn() => new BrandRepository(new Brand()));
        $this->app->bind(TagRepositoryInterface::class, fn() => new TagRepository(new Tag()));
        $this->app->bind(ProductRepositoryInterface::class, fn() => new ProductRepository(new Product()));
        $this->app->bind(ReviewRepositoryInterface::class, fn() => new ReviewRepository(new Review()));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
