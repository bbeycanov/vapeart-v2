<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\Language;
use App\Models\Permission;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
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
        app(PermissionRegistrar::class)
            ->setPermissionClass(Permission::class)
            ->setRoleClass(Role::class);

        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

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
    }
}
