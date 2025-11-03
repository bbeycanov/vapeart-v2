<?php

namespace App\Repositories\Contracts;

use App\Models\Blog;

interface BlogRepositoryInterface extends RepositoryInterface
{
    public function findBySlug(string $slug): ?Blog;
    public function findPublishedBySlug(string $slug): ?Blog;
}
