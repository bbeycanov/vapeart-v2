<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    /**
     * @return string
     */
    public static function modelClass(): string;

    /**
     * @return Builder
     */
    public function query(): Builder;

    /**
     * @param array $relations
     * @return Builder
     */
    public function with(array $relations): Builder;

    /**
     * @param array $columns
     * @return Collection
     */
    public function all(array $columns = ['*']): Collection;

    /**
     * @param array $where
     * @param array $columns
     * @return Collection
     */
    public function get(array $where = [], array $columns = ['*']): Collection;

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
    ): LengthAwarePaginator;

    /**
     * @param int|string $id
     * @param array $columns
     * @param array $with
     * @return Model|null
     */
    public function find(int|string $id, array $columns = ['*'], array $with = []): ?Model;

    /**
     * @param array $where
     * @param array $columns
     * @param array $with
     * @return Model|null
     */
    public function firstWhere(array $where, array $columns = ['*'], array $with = []): ?Model;

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data): bool;

    /**
     * @param array $rows
     * @param array $uniqueBy
     * @param array $update
     * @return int
     */
    public function upsert(array $rows, array $uniqueBy, array $update = []): int;

    /**
     * @param Model $model
     * @return bool
     */
    public function delete(Model $model): bool;

    /**
     * @param Model $model
     * @return bool
     */
    public function forceDelete(Model $model): bool;

    /**
     * @param Model $model
     * @return bool
     */
    public function restore(Model $model): bool;
}
