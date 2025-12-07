<?php


namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Collection;
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
     * @param int|null $page
     * @return LengthAwarePaginator
     */
    public function catalog(array $filters = [], int $perPage = 12, ?int $page = null): LengthAwarePaginator
    {
        $q = $this->query()->where('is_active', true);

        if (!empty($filters['brand_ids']) && is_array($filters['brand_ids'])) {
            $brandIds = array_map('intval', $filters['brand_ids']);
            $q->whereIn('brand_id', $brandIds);
        } elseif (!empty($filters['brand_id'])) {
            $q->where('brand_id', (int)$filters['brand_id']);
        }

        if (!empty($filters['category_ids']) && is_array($filters['category_ids'])) {
            $categoryIds = array_map('intval', $filters['category_ids']);
            $q->whereHas('categories', fn($qq) => $qq->whereIn('categories.id', $categoryIds));
        } elseif (!empty($filters['category_id'])) {
            $q->whereHas('categories', fn($qq) => $qq->where('categories.id', (int)$filters['category_id']));
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

        if (!empty($filters['menu_product_ids']) && is_array($filters['menu_product_ids'])) {
            $q->whereIn('id', $filters['menu_product_ids']);
        }

        if (!empty($filters['menu_id'])) {
            $q->whereHas('menus', fn($qq) => $qq->where('menus.id', $filters['menu_id']));
        }

        if (!empty($filters['on_discount']) && $filters['on_discount'] === true) {
            $q->whereHas('discounts', function ($qq) {
                $qq->active();
            });
        }

        // Sorting
        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'price_asc':
                    $q->orderBy('price');
                    break;
                case 'price_desc':
                    $q->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    $locale = app()->getLocale();
                    $q->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.$locale')) ASC");
                    break;
                case 'name_desc':
                    $locale = app()->getLocale();
                    $q->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.$locale')) DESC");
                    break;
                case 'created_asc':
                    $q->orderBy('created_at');
                    break;
                case 'featured':
                    $q->orderByDesc('is_featured')->orderByDesc('created_at');
                    break;
                default:
                    $q->orderByDesc('created_at');
                    break;
            }
        } else {
            $q->orderByDesc('is_featured')->orderByDesc('created_at');
        }

        return $q->with([
            'brand',
            'media',
            'discounts' => function ($query) {
                $query->active();
            }
        ])->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * @param int $perPage
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function paginatePublished(int $perPage = 12, array $filters = []): LengthAwarePaginator
    {
        $q = $this->query()->where('is_active', true);

        if (!empty($filters['exclude_id'])) {
            $q->whereNotIn('id', (array)$filters['exclude_id']);
        }

        $q->orderByDesc('created_at');

        return $q->with([
            'brand',
            'media'
        ])->paginate($perPage);
    }

    /**
     * @param Product $product
     * @param int $limit
     * @return Collection
     */
    public function getRelatedProducts(Product $product, int $limit = 8): Collection
    {
        return $product->categories()
            ->with([
                'products' => function ($q) use ($product, $limit) {
                    $q->where('products.id', '<>', $product->id)
                        ->where('is_active', true)
                        ->with([
                            'brand',
                            'media'
                        ])
                        ->limit($limit * 2);
                }
            ])
            ->get()
            ->pluck('products')
            ->flatten()
            ->unique('id')
            ->take($limit);
    }
}
