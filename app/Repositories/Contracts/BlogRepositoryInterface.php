<?php

namespace App\Repositories\Contracts;

use App\Models\Blog;

interface BlogRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $slug
     * @return Blog|null
     */
    public function findBySlug(string $slug): ?Blog;

    /**
     * @param string $slug
     * @return Blog|null
     */
    public function findPublishedBySlug(string $slug): ?Blog;

    /**
     * @param Blog $blog
     * @return Blog|null
     */
    public function findPrevious(Blog $blog): ?Blog;

    /**
     * @param Blog $blog
     * @return Blog|null
     */
    public function findNext(Blog $blog): ?Blog;
}
