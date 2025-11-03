<?php

namespace App\Services\Contracts;

use App\Models\Review;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ReviewServiceInterface
{
    /**
     * @param string $reviewableType
     * @param int $reviewableId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function listFor(string $reviewableType, int $reviewableId, int $perPage = 10): LengthAwarePaginator;

    /**
     * @param string $reviewableType
     * @param int $reviewableId
     * @param array $data
     * @return Review
     */
    public function createFor(string $reviewableType, int $reviewableId, array $data): Review;

    /**
     * @param Review $review
     * @return string
     */
    public function buildSchemaFor(Review $review): string;
}
