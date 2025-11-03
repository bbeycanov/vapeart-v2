<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $slug
     * @return Product|null
     */
    public function findBySlug(string $slug): ?Product;

    /**
     * @param int $perPage
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function paginatePublished(int $perPage = 12, array $filters = []): LengthAwarePaginator;
}
