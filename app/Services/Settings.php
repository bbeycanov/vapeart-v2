<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class Settings
{
    /**
     * @param string $key
     * @param mixed|null $default
     * @param string|null $locale
     * @return mixed
     */
    public function get(string $key, mixed $default = null, ?string $locale = null): mixed
    {
        $cacheKey = Setting::cacheKey($key);

        $value = Cache::store(config('cache.default'))
            ->rememberForever($cacheKey, function () use ($key) {
                return Setting::query()->where('key', $key)->first();
            });

        if (!$value instanceof Setting) {
            return $default;
        }

        $raw = $value->getAttribute('value');

        // If value is boolean or not an array, return it directly (non-translatable)
        if (!is_array($raw)) {
            return $raw ?? $default;
        }

        $loc = $locale ?? App::getLocale();

        $translated = $value->getTranslation('value', $loc);

        if ($translated === null || $translated === '') {
            return $raw ?? $default;
        }

        return $translated;
    }

    /**
     * @param string $key
     * @param mixed $val
     * @param string|null $locale
     * @return Setting
     */
    public function set(string $key, mixed $val, ?string $locale = null): Setting
    {
        $setting = Setting::firstOrNew(['key' => $key]);

        if ($locale) {
            $existing = $setting->getAttribute('value') ?? [];
            $existing[$locale] = $val;
            $setting->value = $existing;
        } else {
            $setting->value = $val;
        }

        $setting->save();
        return $setting;
    }

    /**
     * @param string $key
     * @return void
     */
    public function forget(string $key): void
    {
        Cache::forget(Setting::cacheKey($key));
    }

    /**
     * @param array $keys
     * @param string|null $locale
     * @return array
     */
    public function getMany(array $keys, ?string $locale = null): array
    {
        $results = [];
        $miss = [];

        foreach ($keys as $key) {
            $cacheKey = Setting::cacheKey($key);
            $model = Cache::get($cacheKey);
            if ($model) {
                $results[$key] = $model;
            } else {
                $miss[] = $key;
            }
        }

        if ($miss) {
            $fresh = Setting::whereIn('key', $miss)->get();
            foreach ($fresh as $item) {
                Cache::rememberForever(Setting::cacheKey($item->key), fn() => $item);
                $results[$item->key] = $item;
            }
        }

        $out = [];
        foreach ($keys as $key) {
            $out[$key] = isset($results[$key])
                ? $this->get(key: $key, locale: $locale)
                : null;
        }
        return $out;
    }
}
