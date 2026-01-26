<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * @property mixed $slug
 */
class Branch extends Model implements Sortable
{
    use HasFactory, SoftDeletes, HasTranslations, SortableTrait;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'slug',
        'name',
        'address',
        'phone',
        'email',
        'whatsapp',
        'working_hours',
        'description',
        'latitude',
        'longitude',
        'map_iframe_url',
        'meta_title',
        'meta_description',
        'is_active',
        'is_default',
        'sort_order',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'name' => 'array',
        'address' => 'array',
        'working_hours' => 'array',
        'description' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * @var array|string[] $translatable
     */
    public array $translatable = [
        'name',
        'address',
        'working_hours',
        'description',
        'meta_title',
        'meta_description'
    ];

    /**
     * @var array $sortable
     */
    public array $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true
    ];
}
