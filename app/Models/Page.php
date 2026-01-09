<?php

namespace App\Models;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @method static updateOrCreate(array $array, mixed $lang)
 * @property mixed $slug
 */
class Page extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use HasTranslations;
    use InteractsWithMedia;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'slug',
        'template',
        'title',
        'excerpt',
        'body',
        'meta_title',
        'meta_description',
        'status',
        'published_at',
        'is_active',
        'sort_order',
    ];

    /**
     * @var string[] $casts
     */
    protected $casts = [
        'title' => 'array',
        'excerpt' => 'array',
        'body' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
        'published_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * @var array|string[]
     */
    public array $translatable = [
        'title',
        'excerpt',
        'body',
        'meta_title',
        'meta_description'
    ];

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery');
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

        // Gallery thumb
        $this->addMediaConversion('gallery-thumb')
            ->width(400)
            ->height(400)
            ->fit(Fit::Contain, 400, 400)
            ->performOnCollections('gallery')
            ->nonQueued();

        // Gallery thumb WebP
        $this->addMediaConversion('gallery-thumb-webp')
            ->width(400)
            ->height(400)
            ->fit(Fit::Contain, 400, 400)
            ->format('webp')
            ->performOnCollections('gallery')
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
     * @param $q
     * @return mixed
     */
    public function scopePublished($q): mixed
    {
        return $q->where('is_active', true);
    }

    /**
     * @return MorphToMany
     */
    public function widgets(): MorphToMany
    {
        return $this->morphToMany(
            Widget::class,
            'model',
            'model_widgets',
            'model_id',
            'widget_id'
        )
            ->withPivot('sort_order')
            ->withTimestamps();
    }
}
