<?php

namespace App\Models;

use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model implements Sortable
{
    use HasFactory, SoftDeletes, HasTranslations, SortableTrait;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'slug',
        'name',
        'is_active',
        'sort_order'
    ];

    /**
     * @var string[] $casts
     */
    protected $casts = [
        'name' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * @var array|string[] $translatable
     */
    public array $translatable = ['name'];

    /**
     * @var array $sortable
     */
    public array $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true
    ];

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_tags');
    }
}
