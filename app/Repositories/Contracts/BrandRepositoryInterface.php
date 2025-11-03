<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;
use App\Models\Brand;

interface BrandRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $slug
     * @return Brand|null
     */
    public function findBySlug(string $slug): ?Brand;

    /**
     * @return Collection
     */
    public function allActive(): Collection;
}
