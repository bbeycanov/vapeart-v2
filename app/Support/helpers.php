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


if (!function_exists('extractSpecsFromHtml')) {
    function extractSpecsFromHtml(?string $html = null): array
    {
        if (!$html) {
            return [];
        }

        // 1) <br> və </p> → newline
        $html = preg_replace('/<\s*br\s*\/?>/i', "\n", $html);
        $html = preg_replace('/<\/p>/i', "\n", $html);

        // 2) Text çıxar
        $text = strip_tags($html);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // 3) Normalize et
        $text  = preg_replace("/\r\n|\r/", "\n", $text);
        $lines = explode("\n", $text);

        $result = [];
        $count  = count($lines);

        for ($i = 0; $i < $count; $i++) {
            $line = _specs_norm($lines[$i]);
            if ($line === '') {
                continue;
            }

            /**
             * YENİ BLOK:
             * ":" YOXDURSA → bu sətiri key kimi əlavə et, value = ''.
             * (Məs: sadə feature listləri, <li> ... </li> və s.)
             */
            if (!str_contains($line, ':')) {
                $key = _specs_clean_key($line);

                if ($key !== '') {
                    $result[$key] = '';
                }

                continue;
            }

            // Normal key/value xətti (KEY: VALUE)
            [
                $rawKey,
                $rawVal
            ] = array_map('trim', explode(':', $line, 2));

            $key = _specs_clean_key($rawKey);
            if ($key === '') {
                continue;
            }

            // Value boşdursa → bəlkə siyahı (dadlar və s.)
            if ($rawVal === '') {

                $items = [];
                for ($j = $i + 1; $j < $count; $j++) {
                    $next = _specs_norm($lines[$j]);

                    if ($next === '') {
                        break;
                    }
                    if (str_contains($next, ':')) {
                        break;
                    }

                    // "1. " kimi nömrələməni at
                    $next = preg_replace('/^\d+[\.\)]\s*/u', '', $next);

                    $items[] = $next;
                }

                if (!empty($items)) {
                    // Siyahını vergüllə birləşdiririk
                    $value = implode(', ', $items);

                    if ($value !== '') { // boş deyilsə əlavə et
                        $result[$key] = $value;
                    }

                    $i = $j - 1;
                    continue;
                }

                // Value yoxdursa və siyahı da yoxdursa → skip
                continue;
            }

            // Normal value
            $value = _specs_norm($rawVal);

            // Burda hələ də qayda qalır: value boşdursa array-a girməsin
            if ($value !== '') {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}


if (!function_exists('_specs_norm')) {
    function _specs_norm(?string $str): string
    {
        if ($str === null) return '';

        $str = html_entity_decode($str, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $str = preg_replace('/[\x00-\x1F\x7F]+/u', '', $str);
        $str = trim($str);
        return preg_replace('/\s+/u', ' ', $str);
    }
}

if (!function_exists('_specs_clean_key')) {
    function _specs_clean_key(string $key): string
    {
        $key = _specs_norm($key);
        return preg_replace('/^[\p{P}\p{S}\s]+/u', '', $key);
    }
}
