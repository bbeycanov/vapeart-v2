<?php

namespace App\Models;

use Spatie\Image\Enums\Fit;
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
use Spatie\MediaLibrary\MediaCollections\Models\Media;
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
        $this->addMediaCollection('gallery');              // additional images
        $this->addMediaCollection('banner_desktop')->singleFile(); // desktop banner
        $this->addMediaCollection('banner_tablet')->singleFile();  // tablet banner
        $this->addMediaCollection('banner_mobile')->singleFile();  // mobile banner
    }

    /**
     * Register media conversions for different sizes
     *
     * @param Media|null $media
     * @return void
     */
    public function registerMediaConversions(Media $media = null): void
    {
        // Thumb for admin panel
        $this->addMediaConversion('thumb')
            ->width(256)
            ->height(256)
            ->nonQueued();

        // Icon: 128x128 (for category navigation)
        $this->addMediaConversion('icon')
            ->width(128)
            ->height(128)
            ->fit(Fit::Contain, 128, 128)
            ->performOnCollections('icon')
            ->nonQueued();

        // Gallery thumb: 400x400
        $this->addMediaConversion('gallery-thumb')
            ->width(400)
            ->height(400)
            ->fit(Fit::Contain, 400, 400)
            ->performOnCollections('gallery')
            ->nonQueued();

        // Desktop banner: Original size with high quality
        $this->addMediaConversion('banner_desktop')
            ->quality(90)
            ->performOnCollections('banner_desktop')
            ->nonQueued();

        // Tablet banner: 1200px wide for retina displays
        $this->addMediaConversion('banner_tablet')
            ->quality(90)
            ->performOnCollections('banner_tablet')
            ->nonQueued();

        // Mobile banner: 800px wide for retina displays
        $this->addMediaConversion('banner_mobile')
            ->quality(90)
            ->performOnCollections('banner_mobile')
            ->nonQueued();
    }

    /**
     * Get banner image URLs for responsive display
     *
     * @return array{desktop: string, tablet: string, mobile: string}
     */
    public function getBannerImageUrls(): array
    {
        $desktopMedia = $this->getFirstMedia('banner_desktop');
        $tabletMedia = $this->getFirstMedia('banner_tablet');
        $mobileMedia = $this->getFirstMedia('banner_mobile');

        return [
            'banner_desktop' => $desktopMedia?->getUrl('banner_desktop') ?: $desktopMedia?->getUrl() ?: '',
            'banner_tablet' => $tabletMedia?->getUrl('banner_tablet') ?: $desktopMedia?->getUrl() ?: '',
            'banner_mobile' => $mobileMedia?->getUrl('banner_mobile') ?: $desktopMedia?->getUrl() ?: '',
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
