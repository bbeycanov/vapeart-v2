<?php

namespace App\Providers;

use App\Services\TagService;
use App\Services\PageService;
use App\Services\BlogService;
use App\Services\MenuService;
use App\Services\BrandService;
use App\Services\BranchService;
use App\Services\BannerService;
use App\Services\ReviewService;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Services\BlogImportService;
use App\Services\ProductImportService;
use App\Services\ContactMessageService;
use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\TagServiceInterface;
use App\Services\Contracts\PageServiceInterface;
use App\Services\Contracts\BlogServiceInterface;
use App\Services\Contracts\MenuServiceInterface;
use App\Services\Contracts\BrandServiceInterface;
use App\Services\Contracts\BranchServiceInterface;
use App\Services\Contracts\BannerServiceInterface;
use App\Services\Contracts\ReviewServiceInterface;
use App\Services\Contracts\ProductServiceInterface;
use App\Services\Contracts\CategoryServiceInterface;
use App\Services\Contracts\BlogImportServiceInterface;
use App\Services\Contracts\ProductImportServiceInterface;
use App\Services\Contracts\ContactMessageServiceInterface;

class ServiceLayerServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(TagServiceInterface::class, TagService::class);
        $this->app->bind(PageServiceInterface::class, PageService::class);
        $this->app->bind(BlogServiceInterface::class, BlogService::class);
        $this->app->bind(MenuServiceInterface::class, MenuService::class);
        $this->app->bind(BrandServiceInterface::class, BrandService::class);
        $this->app->bind(ReviewServiceInterface::class, ReviewService::class);
        $this->app->bind(BannerServiceInterface::class, BannerService::class);
        $this->app->bind(BranchServiceInterface::class, BranchService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(BlogImportServiceInterface::class, BlogImportService::class);
        $this->app->bind(ProductImportServiceInterface::class, ProductImportService::class);
        $this->app->bind(ContactMessageServiceInterface::class, ContactMessageService::class);
    }

    /**
     * @return void
     */
    public function boot(): void
    {
    }
}
