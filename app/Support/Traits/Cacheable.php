<?php

namespace App\Support\Traits;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Cache\Repository;
use Psr\SimpleCache\InvalidArgumentException;

trait Cacheable
{
    /**
     * @var bool $cacheEnabled
     */
    protected bool $cacheEnabled = true;

    /**
     * @var int|null $cacheTtl
     */
    protected ?int $cacheTtl = null;

    /**
     * @var string|null $cacheStore
     */
    protected ?string $cacheStore = null;

    /**
     * @var string|null $cachePrefix
     */
    protected ?string $cachePrefix = null;

    /**
     * @param bool $enabled
     * @return $this
     */
    public function cacheEnable(bool $enabled = true): static
    {
        $this->cacheEnabled = $enabled;
        return $this;
    }

    /**
     * @return $this
     */
    public function cacheDisable(): static
    {
        return $this->cacheEnable(false);
    }

    /**
     * @param int|null $seconds
     * @return $this
     */
    public function cacheTtl(?int $seconds): static
    {
        $this->cacheTtl = $seconds;
        return $this;
    }

    /**
     * @param string|null $store
     * @return $this
     */
    public function cacheStore(?string $store): static
    {
        $this->cacheStore = $store;
        return $this;
    }

    /**
     * @param string|null $prefix
     * @return $this
     */
    public function cachePrefix(?string $prefix): static
    {
        $this->cachePrefix = $prefix;
        return $this;
    }

    /**
     * @return bool
     */
    protected function isCacheEnabled(): bool
    {
        return $this->cacheEnabled && config('repo.cache.enabled', true);
    }

    protected function cache(): Repository
    {
        $store = $this->cacheStore ?? config('repo.cache.store');
        return Cache::store($store);
    }

    /**
     * @param string $suffix
     * @param array $args
     * @return string
     */
    protected function cacheKey(string $suffix, array $args = []): string
    {
        $prefix = $this->cachePrefix ?? config('repo.cache.prefix', 'repo:');
        $class = static::class;
        $hash = empty($args) ? '' : ':' . md5(serialize($args));
        return $prefix . $class . ':' . $suffix . $hash;
    }

    /**
     * @param string $key
     * @param Closure $callback
     * @return mixed
     */
    protected function remember(string $key, Closure $callback): mixed
    {
        $ttl = $this->cacheTtl ?? (int)config('repo.cache.ttl', 3600);
        return $ttl > 0
            ? $this->cache()->remember($key, $ttl, $callback)
            : $this->cache()->rememberForever($key, $callback);
    }


    /**
     * @param string $pattern
     * @return void
     * @throws InvalidArgumentException
     */
    protected function forgetPattern(string $pattern): void
    {
        $store = $this->cache();

        $redis = method_exists($store->getStore(), 'connection')
            ? $store->getStore()->connection()
            : null;

        if ($redis && method_exists($redis, 'scan')) {
            $cursor = null;
            do {
                [
                    $cursor,
                    $keys
                ] = $redis->scan($cursor ?? 0, [
                    'match' => $pattern,
                    'count' => 1000
                ]);
                if (!empty($keys)) {
                    $store->deleteMultiple($keys);
                }
            } while ($cursor != 0);
        }
    }
}
