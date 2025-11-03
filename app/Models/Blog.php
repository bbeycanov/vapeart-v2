<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property mixed $author_name
 * @property mixed $slug
 * @property mixed $published_at
 * @property mixed $updated_at
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
}
