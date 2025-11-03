<?php

namespace App\Models;

use App\Enums\MenuType;
use App\Enums\MenuPosition;
use Spatie\MediaLibrary\HasMedia;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Menu extends Model implements HasMedia, Sortable
{
    use HasFactory, SoftDeletes, HasTranslations, InteractsWithMedia, SortableTrait;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'parent_id',
        'type',
        'position',
        'title',
        'url',
        'target',
        'icon_class',
        'is_active',
        'sort_order',
    ];

    /**
     * @var string[] $casts
     */
    protected $casts = [
        'title' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * @var array|string[] $translatable
     */
    public array $translatable = [
        'title',
        'url'
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
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('sort_order');
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

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            MenuProduct::class,
            'menu_id',
            'product_id'
        );
    }

    /**
     * @param $q
     * @param MenuPosition|string $pos
     * @return mixed
     */
    public function scopePosition($q, MenuPosition|string $pos): mixed
    {
        $value = $pos instanceof MenuPosition ? $pos->value : $pos;
        return $q->where('position', $value);
    }

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
     * @param MenuType|string $type
     * @return mixed
     */
    public function scopeType($q, MenuType|string $type): mixed
    {
        $value = $type instanceof MenuType ? $type->value : $type;
        return $q->where('type', $value);
    }

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('icon')->singleFile();
    }
}
