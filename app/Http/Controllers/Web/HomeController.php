<?php

namespace App\Http\Controllers\Web;

use App\Models\Discount;
use App\Enums\MenuPosition;
use App\Enums\BannerPosition;
use Spatie\SchemaOrg\Schema;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\View\Factory;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
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
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
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
            $products = Cache::remember($cacheKey, 3600, static function () use ($menu) {
                return $menu->products()
                    ->where('is_active', true)
                    ->where('is_featured', true)
                    ->with([
                        'brand',
                        'media'
                    ])
                    ->orderBy('sort_order')
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
        $discountBanner = $this->bannerService->byPosition(BannerPosition::DISCOUNTS_INDEX_HEADER)->first();

        // Discount products - Get first active discount and its products
        $discountProducts = Cache::remember("discount_products:$locale", 3600, static function () {
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
        $activeDiscount = Cache::remember("active_discount:$locale", 3600, static function () {
            return Discount::active()
                ->orderBy('sort_order')
                ->first();
        });

        // Build organization schema for homepage
        $organizationSchema = $this->buildOrganizationSchema();

        return view(
            view: 'pages.home',
            data: compact(
                'sidebarMenus',
                'featuredMenus',
                'latestBlogs',
                'heroBanners',
                'discountBanner',
                'discountProducts',
                'activeDiscount',
                'organizationSchema'
            )
        );
    }

    /**
     * Build Organization and LocalBusiness schema for homepage SEO
     *
     * @return string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function buildOrganizationSchema(): string
    {
        $organization = Schema::organization()
            ->name(settings('site.title', 'VapeArt Baku'))
            ->description(settings('site.description', 'VapeArt Baku - Electronic cigarettes, vape devices, snus and premium tobacco products store in Baku.'))
            ->url(config('app.url'))
            ->logo(asset(settings('site.og_image', 'storefront/images/og-image.jpg')))
            ->email(settings('site.email', 'info@vapeartbaku.com'))
            ->telephone(settings('site.phone', '+994 50 123 45 67'))
            ->address(Schema::postalAddress()
                ->streetAddress(settings('site.address', 'Baku, Azerbaijan'))
                ->addressLocality('Baku')
                ->addressCountry('AZ')
            )
            ->sameAs(array_filter([
                settings('facebook'),
                settings('instagram'),
                settings('youtube'),
                settings('tiktok'),
            ]));

        $webSite = Schema::webSite()
            ->name(settings('site.title', 'VapeArt Baku'))
            ->url(config('app.url'))
            ->potentialAction(Schema::searchAction()
                ->target(config('app.url') . '/' . app()->getLocale() . '/search?q={search_term_string}')
                ->setProperty('query-input', 'required name=search_term_string')
            );

        // LocalBusiness schema for local SEO
        $localBusiness = Schema::store()
            ->setProperty('@type', 'Store')
            ->name(settings('site.title', 'VapeArt Baku'))
            ->description(settings('site.description', 'VapeArt Baku - Electronic cigarettes, vape devices, snus and premium tobacco products store in Baku.'))
            ->url(config('app.url'))
            ->image(asset(settings('site.og_image', 'storefront/images/og-image.jpg')))
            ->telephone(settings('site.phone', '+994 50 123 45 67'))
            ->email(settings('site.email', 'info@vapeartbaku.com'))
            ->address(Schema::postalAddress()
                ->streetAddress(settings('site.address', 'Baku, Azerbaijan'))
                ->addressLocality('Baku')
                ->addressRegion('Baku')
                ->postalCode('AZ1000')
                ->addressCountry('AZ')
            )
            ->geo(Schema::geoCoordinates()
                ->latitude(40.4093)
                ->longitude(49.8671)
            )
            ->priceRange('$$')
            ->openingHoursSpecification([
                Schema::openingHoursSpecification()
                    ->dayOfWeek(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])
                    ->opens('10:00')
                    ->closes('22:00')
            ])
            ->sameAs(array_filter([
                settings('facebook'),
                settings('instagram'),
                settings('youtube'),
                settings('tiktok'),
            ]));

        return $organization->toScript() . $webSite->toScript() . $localBusiness->toScript();
    }
}
