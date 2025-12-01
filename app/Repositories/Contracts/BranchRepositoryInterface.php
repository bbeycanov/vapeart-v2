<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;
use App\Models\Branch;

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

