<?php

namespace App\Models;

use Exception;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
        $this->addMediaCollection('desktop')->singleFile();
        $this->addMediaCollection('tablet')->singleFile();
        $this->addMediaCollection('mobile')->singleFile();
        $this->addMediaCollection('video')->singleFile();
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
        $this->addMediaConversion('desktop')
            ->quality(90)
            ->performOnCollections('desktop')
            ->nonQueued();

        // Tablet banner: 1200px wide for retina displays
        $this->addMediaConversion('tablet')
            ->quality(90)
            ->performOnCollections('tablet')
            ->nonQueued();

        // Mobile banner: 800px wide for retina displays
        $this->addMediaConversion('mobile')
            ->quality(90)
            ->performOnCollections('mobile')
            ->nonQueued();
    }

    /**
     * Get banner image URLs for responsive display
     *
     * @return array{desktop: string, desktop_webp: string|null, tablet: string, tablet_webp: string|null, mobile: string, mobile_webp: string|null}
     */
    public function getBannerImageUrls(): array
    {
        $media = $this->getFirstMedia('desktop');
        $tabletMedia = $this->getFirstMedia('tablet');
        $mobileMedia = $this->getFirstMedia('mobile');

        return [
            'desktop' => $media?->getUrl('desktop') ?: $media?->getUrl() ?: '',
            'tablet' => $tabletMedia?->getUrl('tablet') ?: $media?->getUrl() ?: '',
            'mobile' => $mobileMedia?->getUrl('mobile') ?: $media?->getUrl('mobile') ?: $media?->getUrl() ?: '',
        ];
    }
}
