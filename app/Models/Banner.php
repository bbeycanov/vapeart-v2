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
}
