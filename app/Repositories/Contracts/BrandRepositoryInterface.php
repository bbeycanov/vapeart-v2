<?php

namespace App\Repositories\Contracts;

use App\Models\Brand;
use Illuminate\Support\Collection;

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
