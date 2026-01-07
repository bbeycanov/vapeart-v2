<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        $this->addMediaCollection('featured')->singleFile();
        $this->addMediaCollection('gallery');
    }

    /**
     * Register media conversions for responsive images and WebP
     *
     * @param \Spatie\MediaLibrary\MediaCollections\Models\Media|null $media
     * @return void
     */
    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        // Featured desktop: 1920x500
        $this->addMediaConversion('featured-desktop')
            ->width(1920)
            ->height(500)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 1920, 500)
            ->performOnCollections('featured')
            ->nonQueued();

        $this->addMediaConversion('featured-desktop-webp')
            ->width(1920)
            ->height(500)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 1920, 500)
            ->format('webp')
            ->performOnCollections('featured')
            ->nonQueued();

        // Featured tablet: 1024x350
        $this->addMediaConversion('featured-tablet')
            ->width(1024)
            ->height(350)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 1024, 350)
            ->performOnCollections('featured')
            ->nonQueued();

        $this->addMediaConversion('featured-tablet-webp')
            ->width(1024)
            ->height(350)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 1024, 350)
            ->format('webp')
            ->performOnCollections('featured')
            ->nonQueued();

        // Featured mobile: 768x300
        $this->addMediaConversion('featured-mobile')
            ->width(768)
            ->height(300)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 768, 300)
            ->performOnCollections('featured')
            ->nonQueued();

        $this->addMediaConversion('featured-mobile-webp')
            ->width(768)
            ->height(300)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 768, 300)
            ->format('webp')
            ->performOnCollections('featured')
            ->nonQueued();

        // Gallery thumb
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
     * Get featured image URLs for responsive display
     *
     * @return array
     */
    public function getFeaturedImageUrls(): array
    {
        $media = $this->getFirstMedia('featured');

        if (!$media) {
            return [
                'desktop' => '', 'desktop_webp' => null,
                'tablet' => '', 'tablet_webp' => null,
                'mobile' => '', 'mobile_webp' => null,
            ];
        }

        return [
            'desktop' => $media->getUrl('featured-desktop') ?: $media->getUrl(),
            'desktop_webp' => $media->getUrl('featured-desktop-webp') ?: null,
            'tablet' => $media->getUrl('featured-tablet') ?: $media->getUrl(),
            'tablet_webp' => $media->getUrl('featured-tablet-webp') ?: null,
            'mobile' => $media->getUrl('featured-mobile') ?: $media->getUrl(),
            'mobile_webp' => $media->getUrl('featured-mobile-webp') ?: null,
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
