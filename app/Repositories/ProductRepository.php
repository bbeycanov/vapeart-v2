<?php


namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    /**
     * @return string
     */
    public static function modelClass(): string
    {
        return Product::class;
    }

    /**
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $slug
     * @return Product|null
     */
    public function findBySlug(string $slug): ?Product
    {
        return $this->query()->where('slug', $slug)
            ->with([
                'brand',
                'categories',
                'tags',
                'media'
            ])
            ->first();
    }

    /**
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function catalog(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $q = $this->query()->where('is_active', true)->where('status', 1);

        if (!empty($filters['brand_id'])) {
            $q->where('brand_id', $filters['brand_id']);
        }

        if (!empty($filters['category_id'])) {
            $q->whereHas('categories', fn($qq) => $qq->where('categories.id', $filters['category_id']));
        }

        if (!empty($filters['tag_id'])) {
            $q->whereHas('tags', fn($qq) => $qq->where('tags.id', $filters['tag_id']));
        }

        if (!empty($filters['price_min'])) {
            $q->where('price', '>=', (float)$filters['price_min']);
        }
        if (!empty($filters['price_max'])) {
            $q->where('price', '<=', (float)$filters['price_max']);
        }

        if (!empty($filters['sort']) && $filters['sort'] === 'price_asc') {
            $q->orderBy('price');
        } elseif (!empty($filters['sort']) && $filters['sort'] === 'price_desc') {
            $q->orderByDesc('price');
        } else {
            $q->orderByDesc('published_at');
        }

        return $q->with([
            'brand',
            'media'
        ])->paginate($perPage);
    }

    /**
     * @param int $perPage
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function paginatePublished(int $perPage = 12, array $filters = []): LengthAwarePaginator
    {
        $q = $this->query()->where('is_active', true)->where('status', 1);

        if (!empty($filters['exclude_id'])) {
            $q->whereNotIn('id', (array)$filters['exclude_id']);
        }

        $q->orderByDesc('published_at');

        return $q->with([
            'brand',
            'media'
        ])->paginate($perPage);
    }
}
