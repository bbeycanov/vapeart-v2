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
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
        $this->addMediaCollection('banner_desktop')->singleFile();
        $this->addMediaCollection('banner_tablet')->singleFile();
        $this->addMediaCollection('banner_mobile')->singleFile();
    }

    /**
     * Register media conversions for responsive images and WebP
     *
     * @param Media|null $media
     * @return void
     */
    public function registerMediaConversions(Media $media = null): void
    {
        // Desktop banner: Original size with high quality
        $this->addMediaConversion('logo')
            ->width(300)
            ->height(150)
            ->sharpen(10)
            ->performOnCollections('logo')
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
        $logo = $this->getFirstMedia('logo');
        $desktopMedia = $this->getFirstMedia('banner_desktop');
        $tabletMedia = $this->getFirstMedia('banner_tablet');
        $mobileMedia = $this->getFirstMedia('banner_mobile');

        return [
            'logo' => $logo?->getUrl('logo') ?: $logo?->getUrl() ?: '',
            'banner_desktop' => $desktopMedia?->getUrl('banner_desktop') ?: $desktopMedia?->getUrl() ?: '',
            'banner_tablet' => $tabletMedia?->getUrl('banner_tablet') ?: $desktopMedia?->getUrl() ?: '',
            'banner_mobile' => $mobileMedia?->getUrl('banner_mobile') ?: $desktopMedia?->getUrl() ?: '',
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
            'src' => $media->getUrl('logo') ?: $media->getUrl(),
            'webp' => $media->getUrl('logo') ?: null,
        ];
    }
}
