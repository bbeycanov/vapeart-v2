<?php

use App\Services\Settings;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

if (!function_exists('settings')) {

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    function settings(string $key, mixed $default = null, ?string $locale = null): mixed
    {
        /**
         * @var Settings $svc
         */
        $settingService = app(Settings::class);

        return $settingService->get($key, $default, $locale);
    }
}

if (!function_exists('localized_url')) {
    /**
     * @param string $toLocale
     * @param string|null $fallbackRouteName
     * @param array $fallbackParams
     * @return string
     */
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

        $queryString = request()->getQueryString();

        return url($newPath . ($queryString ? '?' . $queryString : ''));
    }
}
