<?php

namespace App\Services\Contracts;

use App\Models\Page;
use Illuminate\Database\Eloquent\Model;

interface PageServiceInterface
{
    /**
     * @param string $slug
     * @param bool $onlyPublished
     * @return Page|null
     */
    public function getBySlug(string $slug, bool $onlyPublished = true): ?Page;

    /**
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data): bool;

    /**
     * @param Page $page
     * @return string
     */
    public function buildSchemaFor(Page $page): string;

    /**
     * @param array $data
     * @return Page
     */
    public function create(array $data): Page;
}
