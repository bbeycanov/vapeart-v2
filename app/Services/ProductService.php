<?php


namespace App\Services;

use App\Models\Product;
use Spatie\SchemaOrg\Schema;
use Illuminate\Support\Facades\App;
use Psr\SimpleCache\InvalidArgumentException;
use App\Services\Contracts\ProductServiceInterface;
use Spatie\SchemaOrg\Contracts\ItemAvailabilityContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductService extends AbstractService implements ProductServiceInterface
{
    /**
     * @param ProductRepositoryInterface $repo
     * @param Product $model
     */
    public function __construct(
        private readonly ProductRepositoryInterface $repo,
        Product                                     $model
    )
    {
        parent::__construct($model);
        $this->cachePrefix('svc:product:');
    }

    /**
     * @param array $filters
     * @param int $perPage
     * @param int|null $page
     * @return LengthAwarePaginator
     */
    public function catalog(array $filters = [], int $perPage = 12, ?int $page = null): LengthAwarePaginator
    {
        return $this->repo->catalog($filters, $perPage, $page);
    }

    /**
     * @param string $slug
     * @return Product|null
     */
    public function getBySlug(string $slug): ?Product
    {
        return $this->remember($this->cacheKey('bySlug', [
            $slug,
            App::getLocale()
        ]),
            fn() => $this->repo->findBySlug($slug));
    }

    /**
     * @param Product $product
     * @param array $categoryIds
     * @param bool $sync
     * @return void
     * @throws InvalidArgumentException
     */
    public function attachCategories(Product $product, array $categoryIds, bool $sync = true): void
    {
        $sync ? $product->categories()->sync($categoryIds) : $product->categories()->attach($categoryIds);
        $this->flushServiceCache();
    }

    /**
     * @param Product $product
     * @param array $tagIds
     * @param bool $sync
     * @return void
     * @throws InvalidArgumentException
     */
    public function attachTags(Product $product, array $tagIds, bool $sync = true): void
    {
        $sync ? $product->tags()->sync($tagIds) : $product->tags()->attach($tagIds);
        $this->flushServiceCache();
    }

    /**
     * @param Product $product
     * @return string
     */
    public function buildSchemaFor(Product $product): string
    {
        $loc = App::getLocale();
        $name = $product->getTranslation('name', $loc);
        $desc = $product->getTranslation('meta_description', $loc)
            ?: $product->getTranslation('short_description', $loc);

        $url = route('products.show', [
            'locale' => $loc,
            'product' => $product->slug
        ]);

        $schema = Schema::product()
            ->name($name)
            ->description($desc)
            ->url($url)
            ->sku($product->sku);

        if ($img = $product->getFirstMediaUrl('gallery')) {
            $schema->image($img);
        }

        $price = (float)($product->sale_price ?? $product->price);

        /**
         * @var ItemAvailabilityContract $availability
         */
        $availability = $product->stock_quantity && $product->stock_quantity > 0
            ? 'https://schema.org/InStock'
            : 'https://schema.org/OutOfStock';

        $offer = Schema::offer()
            ->price($price)
            ->priceCurrency($product->currency)
            ->availability($availability)
            ->url($url);

        $schema->offers($offer);

        if ($product->reviews_count > 0 && $product->rating_avg > 0) {
            $schema->aggregateRating(
                Schema::aggregateRating()
                    ->ratingValue((float)$product->rating_avg)
                    ->reviewCount((int)$product->reviews_count)
            );
        }

        if ($brand = $product->brand) {
            $schema->brand(Schema::brand()->name($brand->getTranslation('name', $loc)));
        }

        return $schema->toScript();
    }

    /**
     * @param Product $product
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getRelatedProducts(Product $product, int $limit = 8): \Illuminate\Support\Collection
    {
        return $this->remember($this->cacheKey('relatedProducts', [
            $product->id,
            $limit,
            App::getLocale()
        ]), fn() => $this->repo->getRelatedProducts($product, $limit));
    }
}
