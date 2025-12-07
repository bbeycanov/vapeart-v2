<?php

namespace App\Repositories\Contracts;

use App\Models\Branch;
use Illuminate\Support\Collection;

interface BranchRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $slug
     * @return Branch|null
     */
    public function findBySlug(string $slug): ?Branch;

    /**
     * @return Collection
     */
    public function allActive(): Collection;

    /**
     * @return Branch|null
     */
    public function getDefault(): ?Branch;
}

