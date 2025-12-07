<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Enums\Fit;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property mixed $author_name
 * @property mixed $slug
 * @property mixed $published_at
 * @property mixed $updated_at
 * @property mixed $id
 * @property mixed $created_at
 */
class Blog extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, HasTranslations, InteractsWithMedia;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'slug',
        'title',
        'excerpt',
        'body',
        'meta_title',
        'meta_description',
        'author_name',
        'reading_time',
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
     * @var array|string[] $translatable
     */
    public array $translatable = [
        'title',
        'excerpt',
        'body',
        'meta_title',
        'meta_description',
    ];

    /**
     * @param $q
     * @return mixed
     */
    public function scopePublished($q): mixed
    {
        return $q->where('status', 1)
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured')->singleFile();
        $this->addMediaCollection('gallery');
    }

    /**
     * Register media conversions for different sizes
     *
     * @param Media|null $media
     * @return void
     */
    public function registerMediaConversions(Media $media = null): void
    {
        // Blog index thumbnail: 450x400 (for blog grid items) - maintains aspect ratio
        $this->addMediaConversion('thumb')
            ->width(450)
            ->height(400)
            ->fit(Fit::Contain, 450, 400)
            ->performOnCollections('featured')
            ->nonQueued();

        // Blog detail: 1410x550 (for blog detail page) - maintains aspect ratio
        $this->addMediaConversion('large')
            ->width(1410)
            ->height(550)
            ->fit(Fit::Contain, 1410, 550)
            ->performOnCollections('featured')
            ->nonQueued();
    }

    /**
     * @return MorphMany
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable')->where('status', 1)->latest('published_at');
    }
}
