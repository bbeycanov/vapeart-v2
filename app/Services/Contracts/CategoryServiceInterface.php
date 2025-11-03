<?php

namespace App\Services\Contracts;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface CategoryServiceInterface
{
    /**
     * @param int|null $rootId
     * @return Collection
     */
    public function getTree(?int $rootId = null): Collection;

    /**
     * @param string $slug
     * @return Category|null
     */
    public function getBySlug(string $slug): ?Category;

    /**
     * @param array $data
     * @return Category
     */
    public function create(array $data): Category;

    /**
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data): bool;

    /**
     * @param Category $cat
     * @param mixed $file
     * @return Category
     */
    public function attachIcon(Category $cat, mixed $file): Category;

    /**
     * @param Category $cat
     * @param mixed $file
     * @return Category
     */
    public function attachBanner(Category $cat, mixed $file): Category;

    /**
     * @param Category $category
     * @return string
     */
    public function buildSchemaFor(Category $category): string;
}
