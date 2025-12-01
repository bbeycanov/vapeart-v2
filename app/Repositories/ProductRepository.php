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
     * @param int|null $page
     * @return LengthAwarePaginator
     */
    public function catalog(array $filters = [], int $perPage = 12, ?int $page = null): LengthAwarePaginator
    {
        $q = $this->query()->where('is_active', true);

        // Multiple brand filter (takes precedence)
        if (!empty($filters['brand_ids']) && is_array($filters['brand_ids'])) {
            // Convert string IDs to integers
            $brandIds = array_map('intval', $filters['brand_ids']);
            $q->whereIn('brand_id', $brandIds);
        }
        // Single brand filter (backward compatibility)
        elseif (!empty($filters['brand_id'])) {
            $q->where('brand_id', (int)$filters['brand_id']);
        }

        // Multiple category filter (takes precedence)
        if (!empty($filters['category_ids']) && is_array($filters['category_ids'])) {
            // Convert string IDs to integers
            $categoryIds = array_map('intval', $filters['category_ids']);
            $q->whereHas('categories', fn($qq) => $qq->whereIn('categories.id', $categoryIds));
        }
        // Single category filter (backward compatibility)
        elseif (!empty($filters['category_id'])) {
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

        // Menu filter - if menu_product_ids provided, only show products in that menu
        if (!empty($filters['menu_product_ids']) && is_array($filters['menu_product_ids'])) {
            $q->whereIn('id', $filters['menu_product_ids']);
        }

        // Menu filter - if menu_id provided, filter by menu
        if (!empty($filters['menu_id'])) {
            $q->whereHas('menus', fn($qq) => $qq->where('menus.id', $filters['menu_id']));
        }

        // Discount filter - if on_discount is true, only show products with active discounts
        if (!empty($filters['on_discount']) && $filters['on_discount'] === true) {
            $q->whereHas('discounts', function ($qq) {
                $qq->active();
            });
        }

        // Sorting
        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'price_asc':
                    $q->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $q->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    // For translatable fields, we need to use JSON path
                    $locale = app()->getLocale();
                    $q->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.{$locale}')) ASC");
                    break;
                case 'name_desc':
                    $locale = app()->getLocale();
                    $q->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.{$locale}')) DESC");
                    break;
                case 'created_desc':
                    $q->orderByDesc('created_at');
                    break;
                case 'created_asc':
                    $q->orderBy('created_at', 'asc');
                    break;
                case 'featured':
                    $q->orderByDesc('is_featured')->orderByDesc('created_at');
                    break;
                default:
                    $q->orderByDesc('created_at');
                    break;
            }
        } else {
            // Default: featured first, then by creation date
            $q->orderByDesc('is_featured')->orderByDesc('created_at');
        }

        $paginator = $q->with([
            'brand',
            'media',
            'discounts' => function ($query) {
                $query->active();
            }
        ])->paginate($perPage, ['*'], 'page', $page);
        
        return $paginator;
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
     * @return \Illuminate\Support\Collection
     */
    public function getRelatedProducts(Product $product, int $limit = 8): \Illuminate\Support\Collection
    {
        return $product->categories()
            ->with(['products' => function ($q) use ($product, $limit) {
                $q->where('products.id', '<>', $product->id)
                    ->where('is_active', true)
                    ->with(['brand', 'media'])
                    ->limit($limit * 2); // Get more to ensure we have enough after unique
            }])
            ->get()
            ->pluck('products')
            ->flatten()
            ->unique('id')
            ->take($limit);
    }
}
