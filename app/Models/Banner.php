<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property mixed $type
 * @property mixed $key
 */
class Banner extends Model implements HasMedia, Sortable
{
    use HasFactory, SoftDeletes, HasTranslations, InteractsWithMedia, SortableTrait;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'key',
        'position',
        'type',
        'title',
        'subtitle',
        'content',
        'link_text',
        'link_url',
        'target',
        'is_active',
        'sort_order',
        'starts_at',
        'ends_at',
        'html'
    ];

    /**
     * @var string[] $casts
     */
    protected $casts = [
        'title' => 'array',
        'subtitle' => 'array',
        'content' => 'array',
        'link_text' => 'array',
        'link_url' => 'array',
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'html'=>'array'
    ];

    /**
     * @var array|string[] $translatable
     */
    public array $translatable = [
        'title',
        'subtitle',
        'content',
        'link_text',
        'link_url',
        'html'
    ];

    /**
     * @var array $sortable
     */
    public array $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    /**
     * @param $q
     * @return mixed
     */
    public function scopeActive($q): mixed
    {
        return $q->where('is_active', true);
    }

    /**
     * @param $q
     * @return mixed
     */
    public function scopeInSchedule($q): mixed
    {
        $now = now();
        return $q->where(function ($qq) use ($now) {
            $qq->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
        })->where(function ($qq) use ($now) {
            $qq->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
        });
    }

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
        $this->addMediaCollection('image_mobile')->singleFile();
        $this->addMediaCollection('video')->singleFile();
        $this->addMediaCollection('icon')->singleFile();
    }

    /**
     * Register media conversions for responsive images and WebP
     *
     * @param \Spatie\MediaLibrary\MediaCollections\Models\Media|null $media
     * @return void
     */
    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        // Desktop banner: 1920x560
        $this->addMediaConversion('desktop')
            ->width(1920)
            ->height(560)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 1920, 560)
            ->performOnCollections('image')
            ->nonQueued();

        // Desktop WebP
        $this->addMediaConversion('desktop-webp')
            ->width(1920)
            ->height(560)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 1920, 560)
            ->format('webp')
            ->performOnCollections('image')
            ->nonQueued();

        // Tablet banner: 1024x400
        $this->addMediaConversion('tablet')
            ->width(1024)
            ->height(400)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 1024, 400)
            ->performOnCollections('image')
            ->nonQueued();

        // Tablet WebP
        $this->addMediaConversion('tablet-webp')
            ->width(1024)
            ->height(400)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 1024, 400)
            ->format('webp')
            ->performOnCollections('image')
            ->nonQueued();

        // Mobile banner: 768x400
        $this->addMediaConversion('mobile')
            ->width(768)
            ->height(400)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 768, 400)
            ->performOnCollections('image', 'image_mobile')
            ->nonQueued();

        // Mobile WebP
        $this->addMediaConversion('mobile-webp')
            ->width(768)
            ->height(400)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 768, 400)
            ->format('webp')
            ->performOnCollections('image', 'image_mobile')
            ->nonQueued();

        // Icon conversions
        $this->addMediaConversion('icon-thumb')
            ->width(64)
            ->height(64)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 64, 64)
            ->performOnCollections('icon')
            ->nonQueued();

        $this->addMediaConversion('icon-thumb-webp')
            ->width(64)
            ->height(64)
            ->fit(\Spatie\Image\Enums\Fit::Contain, 64, 64)
            ->format('webp')
            ->performOnCollections('icon')
            ->nonQueued();
    }

    /**
     * Get banner image URLs for responsive display
     *
     * @return array{desktop: string, desktop_webp: string|null, tablet: string, tablet_webp: string|null, mobile: string, mobile_webp: string|null}
     */
    public function getBannerImageUrls(): array
    {
        $media = $this->getFirstMedia('image');
        $mobileMedia = $this->getFirstMedia('image_mobile');

        $result = [
            'desktop' => $media?->getUrl('desktop') ?: $media?->getUrl() ?: '',
            'desktop_webp' => null,
            'tablet' => $media?->getUrl('tablet') ?: $media?->getUrl() ?: '',
            'tablet_webp' => null,
            'mobile' => $mobileMedia?->getUrl('mobile') ?: $media?->getUrl('mobile') ?: $media?->getUrl() ?: '',
            'mobile_webp' => null,
        ];

        // Try to get WebP versions
        try {
            if ($media) {
                $result['desktop_webp'] = $media->getUrl('desktop-webp') ?: null;
                $result['tablet_webp'] = $media->getUrl('tablet-webp') ?: null;
            }
            if ($mobileMedia) {
                $result['mobile_webp'] = $mobileMedia->getUrl('mobile-webp') ?: null;
            } elseif ($media) {
                $result['mobile_webp'] = $media->getUrl('mobile-webp') ?: null;
            }
        } catch (\Exception $e) {
            // WebP not available
        }

        return $result;
    }
}
