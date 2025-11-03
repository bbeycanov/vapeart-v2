<?php

namespace App\Repositories;

use App\Models\Blog;
use App\Repositories\Contracts\BlogRepositoryInterface;

class BlogRepository extends BaseRepository implements BlogRepositoryInterface
{
    /**
     * @return string
     */
    public static function modelClass(): string
    {
        return Blog::class;
    }

    /**
     * @param Blog $model
     */
    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $slug
     * @return Blog|null
     */
    public function findBySlug(string $slug): ?Blog
    {
        return $this->firstWhere(['slug' => $slug])->first();
    }

    /**
     * @param string $slug
     * @return Blog|null
     */
    public function findPublishedBySlug(string $slug): ?Blog
    {
        return $this->query()->published()->where('slug', $slug)->first();
    }
}
