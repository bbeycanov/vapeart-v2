<?php


namespace App\Services;

use App\Models\Product;
use Spatie\SchemaOrg\Schema;
use Illuminate\Support\Collection;
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

        // Get product image - check thumbnail first, then images collection
        $img = $product->getFirstMediaUrl('thumbnail', 'large')
            ?: $product->getFirstMediaUrl('images', 'large')
            ?: $product->getFirstMediaUrl('thumbnail')
            ?: $product->getFirstMediaUrl('images');

        if ($img) {
            $schema->image($img);
        }

        // Get discount information
        $bestDiscount = $product->getBestDiscount();
        $hasDiscount = $bestDiscount !== null;
        $originalPrice = (float)$product->price;
        $discountedPrice = $hasDiscount ? (float)$product->getDiscountedPrice() : $originalPrice;

        /**
         * @var ItemAvailabilityContract $availability
         */
        $availability = $product->stock_qty && $product->stock_qty > 0
            ? 'https://schema.org/InStock'
            : 'https://schema.org/OutOfStock';

        $offer = Schema::offer()
            ->price($discountedPrice)
            ->priceCurrency($product->currency ?? 'AZN')
            ->availability($availability)
            ->url($url);

        // Add discount-specific properties
        if ($hasDiscount) {
            // Add original price as highPrice for comparison
            $offer->setProperty('priceSpecification', Schema::priceSpecification()
                ->price($discountedPrice)
                ->priceCurrency($product->currency ?? 'AZN')
                ->valueAddedTaxIncluded(true)
            );

            // If discount has end date, add priceValidUntil
            if ($bestDiscount->ends_at) {
                $offer->priceValidUntil($bestDiscount->ends_at->format('Y-m-d'));
            }
        }

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

        // Add breadcrumb schema
        $breadcrumbSchema = $this->buildBreadcrumbSchema($product);

        return $schema->toScript() . $breadcrumbSchema;
    }

    /**
     * Build BreadcrumbList schema for product
     *
     * @param Product $product
     * @return string
     */
    private function buildBreadcrumbSchema(Product $product): string
    {
        $loc = App::getLocale();
        $listItems = [];

        // Home
        $listItems[] = Schema::listItem()
            ->position(1)
            ->name(__('navigation.Home'))
            ->item(route('home', $loc));

        // Shop
        $listItems[] = Schema::listItem()
            ->position(2)
            ->name(__('navigation.Shop'))
            ->item(route('products.index', $loc));

        $position = 3;

        // Category (first category if exists)
        $category = $product->categories->first();
        if ($category) {
            $listItems[] = Schema::listItem()
                ->position($position)
                ->name($category->getTranslation('name', $loc))
                ->item(route('categories.show', ['locale' => $loc, 'category' => $category->slug]));
            $position++;
        }

        // Brand (if exists)
        if ($product->brand) {
            $listItems[] = Schema::listItem()
                ->position($position)
                ->name($product->brand->getTranslation('name', $loc))
                ->item(route('brands.show', ['locale' => $loc, 'brand' => $product->brand->slug]));
            $position++;
        }

        // Product
        $listItems[] = Schema::listItem()
            ->position($position)
            ->name($product->getTranslation('name', $loc))
            ->item(route('products.show', ['locale' => $loc, 'product' => $product->slug]));

        $breadcrumb = Schema::breadcrumbList()->itemListElement($listItems);

        return $breadcrumb->toScript();
    }

    /**
     * @param Product $product
     * @param int $limit
     * @return Collection
     */
    public function getRelatedProducts(Product $product, int $limit = 8): Collection
    {
        return $this->remember($this->cacheKey('relatedProducts', [
            $product->id,
            $limit,
            App::getLocale()
        ]), fn() => $this->repo->getRelatedProducts($product, $limit));
    }
}
