<?php

namespace App\Http\Controllers\Web;

use App\Models\Discount;
use App\Enums\MenuPosition;
use App\Enums\BannerPosition;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\View\Factory;
use App\Services\Contracts\MenuServiceInterface;
use App\Services\Contracts\BlogServiceInterface;
use App\Services\Contracts\BannerServiceInterface;

class HomeController extends Controller
{
    /**
     * @param MenuServiceInterface $menus
     * @param BlogServiceInterface $blogService
     * @param BannerServiceInterface $bannerService
     */
    public function __construct(
        private readonly MenuServiceInterface   $menus,
        private readonly BlogServiceInterface   $blogService,
        private readonly BannerServiceInterface $bannerService
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

        // Sidebar menus - MenuService içinde cache'leniyor
        $sidebarMenus = $this->menus->getTree(MenuPosition::SIDEBAR);

        // Featured menus - MenuService içinde cache'leniyor
        $featuredMenus = $this->menus->getTree(MenuPosition::FEATURED);

        // Her featured menü için ürünleri cache'den yükle
        $featuredMenus->each(function ($menu) use ($locale) {
            $cacheKey = "featured_products_menu_{$menu->id}_$locale";
            $products = Cache::remember($cacheKey, 3600, function () use ($menu) {
                return $menu->products()
                    ->where('is_active', true)
                    ->where('is_featured', true)
                    ->with([
                        'brand',
                        'media'
                    ])
                    ->orderBy('sort_order')
                    ->limit(10)
                    ->get();
            });
            $menu->setRelation('products', $products);
        });

        // Latest blogs - BlogService içinde cache'leniyor, ama burada da cache ekliyoruz
        $latestBlogs = Cache::remember("latest_blogs:$locale", 3600, function () {
            return $this->blogService->index(['status' => 'published'], perPage: 4)
                ->items();
        });

        // Home page banners - BannerService içinde cache'leniyor
        $heroBanners = $this->bannerService->byPosition(BannerPosition::HOME_HERO_SLIDESHOW);

        // Discount products - Get first active discount and its products
        $discountProducts = Cache::remember("discount_products:$locale", 3600, function () {
            $activeDiscount = Discount::active()
                ->orderBy('sort_order')
                ->first();

            if ($activeDiscount) {
                return $activeDiscount->products()
                    ->where('is_active', true)
                    ->with([
                        'brand',
                        'media',
                        'discounts' => function ($q) {
                            $q->active();
                        }
                    ])
                    ->orderBy('sort_order')
                    ->limit(12)
                    ->get();
            }

            return collect();
        });

        // Get discount info for banner
        $activeDiscount = Cache::remember("active_discount:$locale", 3600, function () {
            return Discount::active()
                ->orderBy('sort_order')
                ->first();
        });

        return view(
            view: 'pages.home',
            data: compact(
                'sidebarMenus',
                'featuredMenus',
                'latestBlogs',
                'heroBanners',
                'discountProducts',
                'activeDiscount'
            )
        );
    }
}
