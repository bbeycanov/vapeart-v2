<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\Language;
use App\Models\Permission;
use App\Models\Branch;
use App\Enums\MenuPosition;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\MenuServiceInterface;
use Spatie\Permission\PermissionRegistrar;
use BezhanSalleh\LanguageSwitch\LanguageSwitch;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        app(PermissionRegistrar::class)
            ->setPermissionClass(Permission::class)
            ->setRoleClass(Role::class);

        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        // Tabloların varlığını kontrol et (migration sırasında hata önlemek için)
        if (!Schema::hasTable('languages')) {
            return;
        }

        $languages = Cache::remember('languages:active', 3600, function () {
            return Language::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get([
                    'code',
                    'name',
                    'native_name'
                ])
                ->toArray();
        });

        $codes = array_column($languages, 'code');

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) use ($codes) {
            $switch
                ->locales($codes)
                ->nativeLabel()
                ->circular();
        });

        View::share('languages', $languages);
        config(['app.supported_locales' => array_column($languages, 'code')]);
        config(['app.default_locale' => env('APP_LOCALE_DEFAULT', config('app.fallback_locale'))]);

        // Share HEADER menus to all views (cached) - using View::composer
        View::composer('*', function ($view) {
            $locale = app()->getLocale();
            $headerMenus = Cache::remember("header_menus:{$locale}", 3600, function () {
                $menuService = app(MenuServiceInterface::class);
                return $menuService->getTree(MenuPosition::HEADER);
            });
            $view->with('headerMenus', $headerMenus);
        });

        // Share FOOTER menus to all views (cached) - using View::composer
        View::composer('*', function ($view) {
            $locale = app()->getLocale();
            $footerMenus = Cache::remember("footer_menus:{$locale}", 3600, function () {
                $menuService = app(MenuServiceInterface::class);
                return $menuService->getTree(MenuPosition::FOOTER);
            });
            $view->with('footerMenus', $footerMenus);
        });

        // Share MOBILE menus to all views (cached) - using View::composer
        View::composer('*', function ($view) {
            $locale = app()->getLocale();
            $mobileMenus = Cache::remember("mobile_menus:{$locale}", 3600, function () {
                $menuService = app(MenuServiceInterface::class);
                return $menuService->getTree(MenuPosition::MOBILE_MENU);
            });
            $view->with('mobileMenus', $mobileMenus);
        });

        // Share BRANCHES to all views (cached) - using View::composer
        View::composer('*', function ($view) {
            $locale = app()->getLocale();
            $branches = Cache::remember("branches:active:{$locale}", 3600, function () use ($locale) {
                return Branch::where('is_active', true)
                    ->orderBy('sort_order')
                    ->get()
                    ->map(function ($branch) use ($locale) {
                        return [
                            'id' => $branch->id,
                            'name' => $branch->getTranslation('name', $locale),
                            'phone' => $branch->phone,
                            'whatsapp' => $branch->whatsapp,
                        ];
                    });
            });
            $view->with('headerBranches', $branches);
        });
    }
}
