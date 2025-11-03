<?php

namespace App\Repositories\Contracts;

use App\Models\Tag;

interface TagRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $slug
     * @return Tag|null
     */
    public function findBySlug(string $slug): ?Tag;
}
