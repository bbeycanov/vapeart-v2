<?php

namespace App\Repositories;

use App\Models\Branch;
use Illuminate\Support\Collection;
use App\Repositories\Contracts\BranchRepositoryInterface;

class BranchRepository extends BaseRepository implements BranchRepositoryInterface
{
    /**
     * @return string
     */
    public static function modelClass(): string
    {
        return Branch::class;
    }

    /**
     * @param Branch $model
     */
    public function __construct(Branch $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $slug
     * @return Branch|null
     */
    public function findBySlug(string $slug): ?Branch
    {
        return $this->firstWhere(['slug' => $slug])->first();
    }

    /**
     * @return Collection
     */
    public function allActive(): Collection
    {
        return $this->query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * @return Branch|null
     */
    public function getDefault(): ?Branch
    {
        return $this->query()
            ->where('is_active', true)
            ->where('is_default', true)
            ->orderBy('sort_order')
            ->first();
    }
}

