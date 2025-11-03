<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ReviewRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int $productId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginateForProduct(int $productId, int $perPage = 10): LengthAwarePaginator;
}
