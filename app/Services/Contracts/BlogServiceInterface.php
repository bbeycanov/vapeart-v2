<?php

namespace App\Services\Contracts;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Model;

interface BlogServiceInterface
{
    /**
     * @param array $filters
     * @param int $perPage
     * @return mixed
     */
    public function index(array $filters = [], int $perPage = 12): mixed;

    /**
     * @param string $slug
     * @param bool $onlyPublished
     * @return Blog|null
     */
    public function getBySlug(string $slug, bool $onlyPublished = true): ?Blog;

    /**
     * @param array $data
     * @return Blog
     */
    public function create(array $data): Blog;

    /**
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data): bool;

    /**
     * @param Blog $blog
     * @param mixed $file
     * @return Blog
     */
    public function attachFeatured(Blog $blog, mixed $file): Blog;

    /**
     * @param Blog $blog
     * @param mixed $file
     * @return Blog
     */
    public function addToGallery(Blog $blog, mixed $file): Blog;

    /**
     * @param Blog $blog
     * @return string
     */
    public function buildSchemaFor(Blog $blog): string;
}
