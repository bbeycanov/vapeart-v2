<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * @property mixed $slug
 * @property mixed $id
 */
class Brand extends Model implements HasMedia, Sortable
{
    use HasFactory, SoftDeletes, HasTranslations, InteractsWithMedia, SortableTrait;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'slug',
        'name',
        'description',
        'meta_title',
        'meta_description',
        'is_active',
        'sort_order',
        'social_links',
        'website'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
        'is_active' => 'boolean',
        'social_links' => 'array'
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
        'sort_when_creating' => true
    ];

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'brand_id');
    }

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile();
        $this->addMediaCollection('banner')->singleFile();
    }

    /**
     * Register media conversions for responsive images and WebP
     *
     * @param \Spatie\MediaLibrary\MediaCollections\Models\Media|null $media
     * @return void
     */
    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        // Logo conversions
        $this->addMediaConversion('logo-thumb')
            ->width(200)
            ->height(200)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 200, 200)
            ->performOnCollections('logo')
            ->nonQueued();

        $this->addMediaConversion('logo-thumb-webp')
            ->width(200)
            ->height(200)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 200, 200)
            ->format('webp')
            ->performOnCollections('logo')
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
     * Get logo image URLs with WebP
     *
     * @return array
     */
    public function getLogoImageUrls(): array
    {
        $media = $this->getFirstMedia('logo');

        if (!$media) {
            return ['src' => '', 'webp' => null];
        }

        return [
            'src' => $media->getUrl('logo-thumb') ?: $media->getUrl(),
            'webp' => $media->getUrl('logo-thumb-webp') ?: null,
        ];
    }
}
