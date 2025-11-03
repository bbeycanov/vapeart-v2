<?php

namespace App\Repositories;

use App\Models\Brand;
use Illuminate\Support\Collection;
use App\Repositories\Contracts\BrandRepositoryInterface;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    /**
     * @return string
     */
    public static function modelClass(): string
    {
        return Brand::class;
    }

    /**
     * @param Brand $model
     */
    public function __construct(Brand $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $slug
     * @return Brand|null
     */
    public function findBySlug(string $slug): ?Brand
    {
        return $this->firstWhere(['slug' => $slug])->first();
    }

    /**
     * @return Collection
     */
    public function allActive(): Collection
    {
        $builder = $this->query()->active()->orderBy('name');
    }
}
