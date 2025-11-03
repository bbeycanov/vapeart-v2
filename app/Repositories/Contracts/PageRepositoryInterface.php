<?php

namespace App\Repositories\Contracts;

use App\Models\Page;

interface PageRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $slug
     * @return Page|null
     */
    public function findBySlug(string $slug): ?Page;

    /**
     * @param string $slug
     * @return Page|null
     */
    public function findPublishedBySlug(string $slug): ?Page;
}
