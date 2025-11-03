<?php

use App\Services\Settings;
use Illuminate\Support\Arr;

if (!function_exists('settings')) {
    function settings(string $key, mixed $default = null, ?string $locale = null): mixed
    {
        /** @var Settings $svc */
        $svc = app(Settings::class);
        return $svc->get($key, $default, $locale);
    }
}

if (!function_exists('localized_url')) {
    function localized_url(string $toLocale, ?string $fallbackRouteName = null, array $fallbackParams = []): string
    {
        $route = request()->route();

        if ($route && $name = $route->getName()) {
            $params = array_merge($route->parameters(), request()->query());
            $params['locale'] = $toLocale;
            return route($name, $params);
        }

        if ($fallbackRouteName) {
            $params = array_merge($fallbackParams, request()->query());
            $params['locale'] = $toLocale;
            return route($fallbackRouteName, $params);
        }

        $path = request()->path();
        $supported = (array)config('app.supported_locales', []);
        $segments = explode('/', $path);

        if (!empty($segments) && in_array($segments[0], $supported, true)) {
            $segments[0] = $toLocale;
        } else {
            array_unshift($segments, $toLocale);
        }

        $newPath = implode('/', $segments);
        $qs = request()->getQueryString();
        return url($newPath . ($qs ? '?' . $qs : ''));
    }
}
