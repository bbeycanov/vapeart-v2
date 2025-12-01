<?php

namespace App\Services;

use App\Models\Branch;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use App\Services\Contracts\BranchServiceInterface;
use App\Repositories\Contracts\BranchRepositoryInterface;

class BranchService extends AbstractService implements BranchServiceInterface
{
    /**
     * @param BranchRepositoryInterface $repo
     * @param Branch $model
     */
    public function __construct(
        private readonly BranchRepositoryInterface $repo,
        Branch $model
    )
    {
        parent::__construct($model);
        $this->cachePrefix('svc:branch:');
    }

    /**
     * @return Collection
     */
    public function getAllActive(): Collection
    {
        return $this->remember($this->cacheKey('allActive', [
            App::getLocale()
        ]), fn() => $this->repo->allActive());
    }

    /**
     * @return Branch|null
     */
    public function getDefault(): ?Branch
    {
        return $this->remember($this->cacheKey('default', [
            App::getLocale()
        ]), fn() => $this->repo->getDefault());
    }

    /**
     * @param string $slug
     * @return Branch|null
     */
    public function getBySlug(string $slug): ?Branch
    {
        return $this->remember($this->cacheKey('bySlug', [
            $slug,
            App::getLocale()
        ]), fn() => $this->repo->findBySlug($slug));
    }
}

