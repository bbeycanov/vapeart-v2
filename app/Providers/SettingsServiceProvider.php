<?php

namespace App\Providers;

use App\Services\Settings;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Settings::class, function () {
            return new Settings();
        });
    }
}
