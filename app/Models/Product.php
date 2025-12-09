<?php

namespace App\Models;

use Closure;
use Exception;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Container\Attributes\Log;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\HigherOrderCollectionProxy;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property mixed $reviews_count
 * @property mixed $stock_quantity
 * @property mixed $rating_avg
 * @property mixed $price
 * @property mixed $currency
 * @property mixed $slug
 * @property mixed $brand
 * @property mixed $sku
 * @property mixed $is_active
 * @property HigherOrderCollectionProxy|mixed $categories
 * @property mixed $id
 * @property mixed $compare_at_price
 * @property mixed $stock_qty
 * @property mixed $is_track_stock
 * @property mixed $tags
 * @property mixed $name
 * @property mixed $description
 * @property mixed $brand_id
 */
class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, HasTranslations, InteractsWithMedia;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'brand_id',
        'sku',
        'slug',
        'name',
        'short_description',
        'description',
        'meta_title',
        'meta_description',
        'price',
        'compare_at_price',
        'currency',
        'stock_qty',
        'is_track_stock',
        'is_active',
        'is_featured',
        'is_new',
        'is_hot',
        'attributes',
        'specs',
        'reviews_count',
        'rating_avg',
    ];

    /**
     * @var string[] $casts
     */
    protected $casts = [
        'name' => 'array',
        'short_description' => 'array',
        'description' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'stock_qty' => 'integer',
        'track_stock' => 'boolean',
        'is_active' => 'boolean',
        'attributes' => 'array',
        'specs' => 'array',
        'reviews_count' => 'integer',
        'rating_avg' => 'decimal:2',
        'seo' => 'array',
    ];

    /**
     * @var array|string[] $translatable
     */
    public array $translatable = [
        'name',
        'short_description',
        'description',
        'meta_title',
        'meta_description',
        'attributes',
        'specs'
    ];

    /**
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_categories')
            ->withPivot('sort_order');
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            'product_tags',
            'product_id',
            'tag_id'
        );
    }

    /**
     * @return BelongsToMany
     */
    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class, 'menu_products');
    }

    /**
     * @return BelongsToMany
     */
    public function discounts(): BelongsToMany
    {
        return $this->belongsToMany(Discount::class, 'product_discounts');
    }


    /**
     * @return MorphMany
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable')->where('status', 1)->latest('published_at');
    }

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
        $this->addMediaCollection('thumbnail')->singleFile();
    }

    /**
     * Register media conversions for different sizes
     *
     * @param Media|null $media
     * @return void
     */
    public function registerMediaConversions(Media $media = null): void
    {
        // Thumbnail: 256x256 (for product cards, cart items) - maintains aspect ratio, no cropping
        $this->addMediaConversion('thumb')
            ->width(256)
            ->height(256)
            ->fit(Fit::Contain, 256, 256)
            ->performOnCollections('images', 'thumbnail')
            ->nonQueued();

        // Medium: 512x512 (for cart drawer, quick view) - maintains aspect ratio, no cropping
        $this->addMediaConversion('medium')
            ->width(512)
            ->height(512)
            ->fit(Fit::Contain, 512, 512)
            ->performOnCollections('images', 'thumbnail')
            ->nonQueued();

        // Large: 1024x1024 (for product detail page) - maintains aspect ratio, no cropping
        $this->addMediaConversion('large')
            ->width(1024)
            ->height(1024)
            ->fit(Fit::Contain, 1024, 1024)
            ->performOnCollections('images', 'thumbnail')
            ->nonQueued();
    }

    /**
     * Get product image URL with fallback
     *
     * @param string $conversion
     * @return string
     */
    public function getProductImageUrl(string $conversion = 'large'): string
    {
        $media = $this->getFirstMedia('thumbnail') ?: $this->getFirstMedia('images');

        if ($media) {
            // Always use conversion if available, otherwise use original
            try {
                $url = $media->getUrl($conversion);
                if ($url && $url !== $media->getUrl()) {
                    return $url;
                }
                // If conversion doesn't exist, try to generate it or use original
                return $media->getUrl();
            } catch (Exception $e) {
                Log::error('Error getting media URL: ' . $e->getMessage());
                return $media->getUrl();
            }
        }

        return asset('storefront/images/products/placeholder.jpg');
    }

    /**
     * Scope to get products that are on discount
     *
     * @param $query
     * @return mixed
     */
    public function scopeOnDiscount($query): mixed
    {
        return $query->whereHas('discounts', function ($q) {
            $q->active();
        });
    }

    /**
     * Get active discounts for this product
     *
     * @return Collection
     */
    public function getActiveDiscounts(): Collection
    {
        return $this->discounts()->active()->get();
    }

    /**
     * Get the best active discount (highest percentage or fixed amount)
     *
     * @return Closure|null
     */
    public function getBestDiscount(): ?Closure
    {
        $discounts = $this->getActiveDiscounts();

        if ($discounts->isEmpty()) {
            return null;
        }

        // Find the discount with the highest value
        return $discounts->sortByDesc(function ($discount) {
            if ($discount->type === 'percentage') {
                // For percentage, calculate the discount amount
                return ($this->price * $discount->amount) / 100;
            }
            // For fixed, return the amount directly
            return $discount->amount;
        })->first();
    }

    /**
     * Calculate discounted price
     *
     * @return float
     */
    public function getDiscountedPrice(): float
    {
        /**
         * @var Discount $discount
         */
        $discount = $this->getBestDiscount();

        if (!$discount) {
            return $this->price;
        }

        if ($discount->type === 'percentage') {
            return max(0, $this->price - (($this->price * $discount->amount) / 100));
        }

        // Fixed amount
        return max(0, $this->price - $discount->amount);
    }

    /**
     * Get discount percentage or amount text
     *
     * @return string|null
     */
    public function getDiscountText(): ?string
    {
        /**
         * @var Discount $discount
         */
        $discount = $this->getBestDiscount();

        if (!$discount) {
            return null;
        }

        if ($discount->type === 'percentage') {
            return '-' . $discount->amount . '%';
        }

        // Fixed amount
        return '-' . number_format($discount->amount, 2) . ' ' . ($this->currency ?? 'AZN');
    }
}
