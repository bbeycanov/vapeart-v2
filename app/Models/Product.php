<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
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
        return $this->belongsToMany(Tag::class, 'product_tags');
    }

    /**
     * @return BelongsToMany
     */
    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class, 'menu_products');
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
}
