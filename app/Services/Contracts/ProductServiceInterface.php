<?php

namespace App\Services\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    /**
     * @param array $filters
     * @param int $perPage
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function catalog(array $filters = [], int $perPage = 12, int $page = 1): LengthAwarePaginator;

    /**
     * @param string $slug
     * @return Product|null
     */
    public function getBySlug(string $slug): ?Product;

    /**
     * @param Product $product
     * @param array $categoryIds
     * @param bool $sync
     * @return void
     */
    public function attachCategories(Product $product, array $categoryIds, bool $sync = true): void;

    /**
     * @param Product $product
     * @param array $tagIds
     * @param bool $sync
     * @return void
     */
    public function attachTags(Product $product, array $tagIds, bool $sync = true): void;

    /**
     * @param Product $product
     * @return string
     */
    public function buildSchemaFor(Product $product): string;

    /**
     * @param Product $product
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getRelatedProducts(Product $product, int $limit = 8): \Illuminate\Support\Collection;
}
