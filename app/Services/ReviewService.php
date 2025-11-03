<?php

namespace App\Services;

use App\Models\Review;
use Spatie\SchemaOrg\Schema;
use App\Services\Contracts\ReviewServiceInterface;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReviewService extends AbstractService implements ReviewServiceInterface
{
    /**
     * @param ReviewRepositoryInterface $repo
     * @param Review $model
     */
    public function __construct(
        private readonly ReviewRepositoryInterface $repo,
        Review                                     $model
    )
    {
        parent::__construct($model);
        $this->cachePrefix('svc:review:');
    }

    /**
     * @param string $reviewableType
     * @param int $reviewableId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function listFor(string $reviewableType, int $reviewableId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->repo->forReviewable($reviewableType, $reviewableId, $perPage);
    }

    /**
     * @param string $reviewableType
     * @param int $reviewableId
     * @param array $data
     * @return Review
     */
    public function createFor(string $reviewableType, int $reviewableId, array $data): Review
    {
        /** @var Review $review */
        $review = $this->model->create(array_merge($data, [
            'reviewable_type' => $reviewableType,
            'reviewable_id' => $reviewableId,
        ]));

        return $review;
    }

    /**
     * @param Review $review
     * @return string
     */
    public function buildSchemaFor(Review $review): string
    {
        $schema = Schema::review()
            ->reviewRating(Schema::rating()->ratingValue((int)$review->rating))
            ->author($review->author_name ?: 'Anonymous')
            ->datePublished(optional($review->created_at)->toIso8601String())
            ->reviewBody($review->body ?: '');

        if ($review->title) $schema->name($review->title);

        return $schema->toScript();
    }
}
