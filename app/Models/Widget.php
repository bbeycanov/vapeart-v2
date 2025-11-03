<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property mixed $title
 * @property mixed $id
 */
class Widget extends Model implements HasMedia, Sortable
{
    use HasFactory, SoftDeletes, HasTranslations, InteractsWithMedia, SortableTrait;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'menu_id',
        'title',
        'content',
        'button_text',
        'button_url',
        'is_active',
        'sort_order',
    ];

    /**
     * @var string[] $casts
     */
    protected $casts = [
        'title' => 'array',
        'content' => 'array',
        'button_text' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * @var array|string[] $translatable
     */
    public array $translatable = [
        'title',
        'content',
        'button_text',
        'button_url',
    ];

    /**
     * @var array $sortable
     */
    public array $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    /**
     * @return BelongsTo
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }
}
