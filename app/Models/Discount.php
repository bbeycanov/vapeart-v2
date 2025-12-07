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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property mixed $type
 * @property mixed $amount
 */
class Discount extends Model implements HasMedia, Sortable
{
    use HasFactory, SoftDeletes, HasTranslations, InteractsWithMedia, SortableTrait;

    /**
     * @var string $table
     */
    protected $table = 'discounts';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'name',
        'code',
        'type',
        'amount',
        'start_date',
        'end_date',
        'usage_limit',
        'used_count',
        'is_active',
        'sort_order',
    ];

    public array $translatable = [
        'name'
    ];

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            ProductDiscount::class,
            'discount_id',
            'product_id'
        );
    }

    /**
     * Scope to get active discounts
     * @param $query
     * @return mixed
     */
    public function scopeActive($query): mixed
    {
        $now = now();
        return $query->where('is_active', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', $now);
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')
                    ->orWhereColumn('used_count', '<', 'usage_limit');
            });
    }

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('banner')->singleFile();
    }
}
