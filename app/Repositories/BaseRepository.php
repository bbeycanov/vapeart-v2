<?php

namespace App\Repositories;

use LogicException;
use App\Support\Traits\Cacheable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Psr\SimpleCache\InvalidArgumentException;
use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements RepositoryInterface
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
        $this->cachePrefix = config('repo.cache.prefix', 'repo:');
    }

    /**
     * @return string
     */
    public static function modelClass(): string
    {
        throw new LogicException(static::class . ' must implement modelClass()');
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * @param array $relations
     * @return Builder
     */
    public function with(array $relations): Builder
    {
        return $this->query()->with($relations);
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
     * @param array $with
     * @return LengthAwarePaginator
     */
    public function paginate(
        int   $perPage = 15,
        array $where = [],
        array $columns = ['*'],
        array $with = []
    ): LengthAwarePaginator
    {
        $builder = $this->applyWhere($this->query()->with($with), $where);

        if (!$this->isCacheEnabled()) {
            return $builder->paginate($perPage, $columns);
        }

        $page = request('page', 1);
        $key = $this->cacheKey('paginate', [
            $perPage,
            $where,
            $columns,
            $with,
            'page' => $page
        ]);

        return $this->remember($key, fn() => $builder->paginate($perPage, $columns));
    }

    /**
     * @param int|string $id
     * @param array $columns
     * @param array $with
     * @return Model|null
     */
    public function find(int|string $id, array $columns = ['*'], array $with = []): ?Model
    {
        $builder = $this->query()->with($with);

        if (!$this->isCacheEnabled()) {
            return $builder->find($id, $columns);
        }

        $key = $this->cacheKey('find', [
            $id,
            $columns,
            $with
        ]);
        return $this->remember($key, fn() => $builder->find($id, $columns));
    }

    /**
     * @param array $where
     * @param array $columns
     * @param array $with
     * @return Model|null
     */
    public function firstWhere(array $where, array $columns = ['*'], array $with = []): ?Model
    {
        $builder = $this->applyWhere($this->query()->with($with), $where);

        if (!$this->isCacheEnabled()) {
            return $builder->first($columns);
        }

        $key = $this->cacheKey('firstWhere', [
            $where,
            $columns,
            $with
        ]);
        return $this->remember($key, fn() => $builder->first($columns));
    }

    /**
     * @param array $data
     * @return Model
     * @throws InvalidArgumentException
     */
    public function create(array $data): Model
    {
        $model = $this->model->create($data);
        $this->flushModelCache();
        return $model;
    }

    /**
     * @param Model $model
     * @param array $data
     * @return bool
     * @throws InvalidArgumentException
     */
    public function update(Model $model, array $data): bool
    {
        $updated = $model->update($data);
        $this->flushModelCache();
        return $updated;
    }

    /**
     * @param array $rows
     * @param array $uniqueBy
     * @param array $update
     * @return int
     * @throws InvalidArgumentException
     */
    public function upsert(array $rows, array $uniqueBy, array $update = []): int
    {
        $count = $this->model->newQuery()->upsert($rows, $uniqueBy, $update);
        $this->flushModelCache();
        return $count;
    }

    /**
     * @param Model $model
     * @return bool
     * @throws InvalidArgumentException
     */
    public function delete(Model $model): bool
    {
        $result = (bool)$model->delete();
        $this->flushModelCache();
        return $result;
    }

    /**
     * @param Model $model
     * @return bool
     * @throws InvalidArgumentException
     */
    public function forceDelete(Model $model): bool
    {
        $result = (bool)$model->forceDelete();
        $this->flushModelCache();
        return $result;
    }

    /**
     * @param Model $model
     * @return bool
     * @throws InvalidArgumentException
     */
    public function restore(Model $model): bool
    {
        $result = method_exists($model, 'restore') && $model->restore();
        $this->flushModelCache();
        return $result;
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

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    protected function flushModelCache(): void
    {
        if (!$this->isCacheEnabled()) return;

        $pattern = ($this->cachePrefix ?? config('repo.cache.prefix', 'repo:'))
            . static::class . ':*';

        $this->forgetPattern($pattern);
    }
}
