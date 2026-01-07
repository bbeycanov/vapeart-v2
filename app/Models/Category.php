<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\EloquentSortable\Sortable;
use App\Support\Traits\BuildsTreePath;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property mixed $parent_id
 * @property mixed $path
 * @property mixed $slug
 * @property mixed $id
 * @property mixed|null $depth
 */
class Category extends Model implements HasMedia, Sortable
{
    use HasFactory;
    use SoftDeletes;
    use SortableTrait;
    use BuildsTreePath;
    use HasTranslations;
    use InteractsWithMedia;

    /**
     * @var string $table
     */
    protected $table = 'categories';

    /**
     * @var string $treeParentColumn
     */
    protected string $treeParentColumn = 'parent_id';

    /**
     * @var string $treeDepthColumn
     */
    protected string $treeDepthColumn = 'depth';

    /**
     * @var string $treePathColumn
     */
    protected string $treePathColumn = 'path';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'parent_id',
        'depth',
        'path',
        'slug',
        'name',
        'description',
        'meta_title',
        'meta_description',
        'is_active',
        'sort_order',
    ];

    /**
     * @var string[] $casts
     */
    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * @var array|string[] $translatable
     */
    public array $translatable = [
        'name',
        'description',
        'meta_title',
        'meta_description'
    ];

    /**
     * @var array $sortable
     */
    public array $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function (Category $model) {
            $model->depth = null;
            $model->path = null;

            $computed = $model->computePathAndDepth($model->parent_id);
            $model->depth = $computed['depth'];
            $model->path = $computed['path'];
        });

        static::updating(function (Category $model) {
            if ($model->isDirty('parent_id')) {
                $computed = $model->computePathAndDepth($model->parent_id);
                $model->depth = $computed['depth'];
                $model->path = $computed['path'];
            }
        });

        static::updated(function (Category $model) {
            if ($model->wasChanged('parent_id') || $model->wasChanged('path')) {
                $model->cascadeRecomputeChildren($model);
            }
        });
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_categories')
            ->withPivot('sort_order');
    }

    /**
     * @param $q
     * @return mixed
     */
    public function scopeActive($q): mixed
    {
        return $q->where('is_active', true);
    }

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('icon')->singleFile();   // small icon
        $this->addMediaCollection('banner')->singleFile(); // category banner
        $this->addMediaCollection('gallery');              // additional images
    }

    /**
     * Register media conversions for different sizes
     *
     * @param \Spatie\MediaLibrary\MediaCollections\Models\Media|null $media
     * @return void
     */
    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        // Icon: 128x128 (for category navigation)
        $this->addMediaConversion('icon')
            ->width(128)
            ->height(128)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 128, 128)
            ->performOnCollections('icon')
            ->nonQueued();

        // Icon WebP: 128x128
        $this->addMediaConversion('icon-webp')
            ->width(128)
            ->height(128)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 128, 128)
            ->format('webp')
            ->performOnCollections('icon')
            ->nonQueued();

        // Banner desktop: 1920x400
        $this->addMediaConversion('banner-desktop')
            ->width(1920)
            ->height(400)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 1920, 400)
            ->performOnCollections('banner')
            ->nonQueued();

        $this->addMediaConversion('banner-desktop-webp')
            ->width(1920)
            ->height(400)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 1920, 400)
            ->format('webp')
            ->performOnCollections('banner')
            ->nonQueued();

        // Banner tablet: 1024x300
        $this->addMediaConversion('banner-tablet')
            ->width(1024)
            ->height(300)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 1024, 300)
            ->performOnCollections('banner')
            ->nonQueued();

        $this->addMediaConversion('banner-tablet-webp')
            ->width(1024)
            ->height(300)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 1024, 300)
            ->format('webp')
            ->performOnCollections('banner')
            ->nonQueued();

        // Banner mobile: 768x250
        $this->addMediaConversion('banner-mobile')
            ->width(768)
            ->height(250)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 768, 250)
            ->performOnCollections('banner')
            ->nonQueued();

        $this->addMediaConversion('banner-mobile-webp')
            ->width(768)
            ->height(250)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 768, 250)
            ->format('webp')
            ->performOnCollections('banner')
            ->nonQueued();

        // Gallery thumb: 400x400
        $this->addMediaConversion('gallery-thumb')
            ->width(400)
            ->height(400)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 400, 400)
            ->performOnCollections('gallery')
            ->nonQueued();

        $this->addMediaConversion('gallery-thumb-webp')
            ->width(400)
            ->height(400)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 400, 400)
            ->format('webp')
            ->performOnCollections('gallery')
            ->nonQueued();
    }

    /**
     * Get banner image URLs for responsive display
     *
     * @return array
     */
    public function getBannerImageUrls(): array
    {
        $media = $this->getFirstMedia('banner');

        if (!$media) {
            return [
                'desktop' => '', 'desktop_webp' => null,
                'tablet' => '', 'tablet_webp' => null,
                'mobile' => '', 'mobile_webp' => null,
            ];
        }

        return [
            'desktop' => $media->getUrl('banner-desktop') ?: $media->getUrl(),
            'desktop_webp' => $media->getUrl('banner-desktop-webp') ?: null,
            'tablet' => $media->getUrl('banner-tablet') ?: $media->getUrl(),
            'tablet_webp' => $media->getUrl('banner-tablet-webp') ?: null,
            'mobile' => $media->getUrl('banner-mobile') ?: $media->getUrl(),
            'mobile_webp' => $media->getUrl('banner-mobile-webp') ?: null,
        ];
    }

    /**
     * Get icon image URLs with WebP
     *
     * @return array
     */
    public function getIconImageUrls(): array
    {
        $media = $this->getFirstMedia('icon');

        if (!$media) {
            return ['src' => '', 'webp' => null];
        }

        return [
            'src' => $media->getUrl('icon') ?: $media->getUrl(),
            'webp' => $media->getUrl('icon-webp') ?: null,
        ];
    }
}
