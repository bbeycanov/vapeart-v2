<?php

namespace App\Services\Contracts;

use App\Models\Branch;
use Illuminate\Support\Collection;

interface BranchServiceInterface
{
    /**
     * @return Collection
     */
    public function getAllActive(): Collection;

    /**
     * @return Branch|null
     */
    public function getDefault(): ?Branch;

    /**
     * @param string $slug
     * @return Branch|null
     */
    public function getBySlug(string $slug): ?Branch;
}

