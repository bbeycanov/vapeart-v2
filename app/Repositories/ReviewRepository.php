<?php


namespace App\Repositories;

use App\Models\Review;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{
    /**
     * @param Review $model
     */
    public function __construct(Review $model)
    {
        parent::__construct($model);
    }

    /**
     * @return string
     */
    public static function modelClass(): string
    {
        return Review::class;
    }

    /**
     * @param string $type
     * @param int $id
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function forReviewable(string $type, int $id, int $perPage = 10): LengthAwarePaginator
    {
        return $this->query()
            ->where('reviewable_type', $type)
            ->where('reviewable_id', $id)
            ->where('status', 1)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * @param int $productId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginateForProduct(int $productId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->forReviewable('product', $productId, $perPage);
    }
}
