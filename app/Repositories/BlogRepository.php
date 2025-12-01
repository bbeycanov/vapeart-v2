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

    /**
     * @param Blog $blog
     * @return Blog|null
     */
    public function findPrevious(Blog $blog): ?Blog
    {
        return $this->query()
            ->published()
            ->where(function($q) use ($blog) {
                $q->where('published_at', '<', $blog->published_at ?? $blog->created_at)
                  ->orWhere(function($q2) use ($blog) {
                      $q2->whereNull('published_at')
                         ->where('created_at', '<', $blog->created_at);
                  });
            })
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * @param Blog $blog
     * @return Blog|null
     */
    public function findNext(Blog $blog): ?Blog
    {
        return $this->query()
            ->published()
            ->where(function($q) use ($blog) {
                $q->where('published_at', '>', $blog->published_at ?? $blog->created_at)
                  ->orWhere(function($q2) use ($blog) {
                      $q2->whereNull('published_at')
                         ->where('created_at', '>', $blog->created_at);
                  });
            })
            ->orderBy('published_at', 'asc')
            ->orderBy('created_at', 'asc')
            ->first();
    }
}
