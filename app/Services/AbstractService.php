<?php

namespace App\Services;

use Closure;
use App\Support\Traits\Cacheable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Psr\SimpleCache\InvalidArgumentException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class AbstractService
{
    use Cacheable;

    /**
     * @var Model $model
     */
    protected Model $model;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;

        $this->cacheEnabled = (bool)config('repo.cache.enabled', true);
        $this->cacheTtl = (int)config('repo.cache.ttl', 3600);
        $this->cacheStore = config('repo.cache.store');
        $this->cachePrefix = config('repo.cache.prefix', 'svc:');
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * @param array $columns
     * @return Collection
     */
    public function all(array $columns = ['*']): Collection
    {
        if (!$this->isCacheEnabled()) {
            return $this->query()->get($columns);
        }

        $key = $this->cacheKey('all', [$columns]);
        return $this->remember($key, fn() => $this->query()->get($columns));
    }

    /**
     * @param array $where
     * @param array $columns
     * @return Collection
     */
    public function get(array $where = [], array $columns = ['*']): Collection
    {
        $builder = $this->applyWhere($this->query(), $where);

        if (!$this->isCacheEnabled()) {
            return $builder->get($columns);
        }

        $key = $this->cacheKey('get', [
            $where,
            $columns
        ]);
        return $this->remember($key, fn() => $builder->get($columns));
    }

    /**
     * @param int $perPage
     * @param array $where
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $where = [], array $columns = ['*']): LengthAwarePaginator
    {
        $builder = $this->applyWhere($this->query(), $where);

        if (!$this->isCacheEnabled()) {
            return $builder->paginate($perPage, $columns);
        }

        $page = request('page', 1);
        $key = $this->cacheKey('paginate', [
            $perPage,
            $where,
            $columns,
            'page' => $page
        ]);
        return $this->remember($key, fn() => $builder->paginate($perPage, $columns));
    }

    /**
     * @param int|string $id
     * @param array $columns
     * @return Model|null
     */
    public function find(int|string $id, array $columns = ['*']): ?Model
    {
        if (!$this->isCacheEnabled()) {
            return $this->query()->find($id, $columns);
        }

        $key = $this->cacheKey('find', [
            $id,
            $columns
        ]);
        return $this->remember($key, fn() => $this->query()->find($id, $columns));
    }

    /**
     * @param array $where
     * @param array $columns
     * @return Model|null
     */
    public function firstWhere(array $where, array $columns = ['*']): ?Model
    {
        $builder = $this->applyWhere($this->query(), $where);

        if (!$this->isCacheEnabled()) {
            return $builder->first($columns);
        }

        $key = $this->cacheKey('firstWhere', [
            $where,
            $columns
        ]);
        return $this->remember($key, fn() => $builder->first($columns));
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->tx(function () use ($data) {
            $model = $this->model->create($data);
            $this->flushServiceCache();
            return $model;
        });
    }

    /**
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data): bool
    {
        return $this->tx(function () use ($model, $data) {
            $ok = $model->update($data);
            $this->flushServiceCache();
            return $ok;
        });
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function delete(Model $model): bool
    {
        return $this->tx(function () use ($model) {
            $ok = method_exists($model, 'delete') ? $model->delete() : false;
            $this->flushServiceCache();
            return (bool)$ok;
        });
    }

    /**
     * @param Closure $callback
     * @return mixed
     */
    protected function tx(Closure $callback): mixed
    {
        return DB::transaction($callback);
    }

    /**
     * @param string $keySuffix
     * @param array $args
     * @param Closure $resolver
     * @return mixed
     */
    protected function cached(string $keySuffix, array $args, Closure $resolver): mixed
    {
        if (!$this->isCacheEnabled()) {
            return $resolver();
        }

        $key = $this->cacheKey($keySuffix, $args);
        return $this->remember($key, $resolver);
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    protected function flushServiceCache(): void
    {
        if (!$this->isCacheEnabled()) return;

        $pattern = ($this->cachePrefix ?? config('repo.cache.prefix', 'svc:'))
            . static::class . ':*';

        $this->forgetPattern($pattern);
    }

    /**
     * @param Builder $builder
     * @param array $where
     * @return Builder
     */
    protected function applyWhere(Builder $builder, array $where): Builder
    {
        foreach ($where as $key => $value) {
            if (is_int($key) && is_array($value)) {
                $builder->where(...$value);
            } else {
                $builder->where($key, $value);
            }
        }
        return $builder;
    }
}
