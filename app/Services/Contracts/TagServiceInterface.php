<?php

namespace App\Services\Contracts;

use App\Models\Tag;

interface TagServiceInterface
{
    /**
     * @param string $slug
     * @return Tag|null
     */
    public function getBySlug(string $slug): ?Tag;
}
