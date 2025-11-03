<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\EloquentSortable\Sortable;
use App\Support\Traits\BuildsTreePath;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property mixed $parent_id
 * @property mixed $path
 * @property mixed $slug
 * @property mixed $id
 * @property mixed|null $depth
 */
class Category extends Model implements HasMedia, Sortable
{
    use HasFactory;
    use SoftDeletes;
    use SortableTrait;
    use BuildsTreePath;
    use HasTranslations;
    use InteractsWithMedia;

    /**
     * @var string $table
     */
    protected $table = 'categories';

    /**
     * @var string $treeParentColumn
     */
    protected string $treeParentColumn = 'parent_id';

    /**
     * @var string $treeDepthColumn
     */
    protected string $treeDepthColumn = 'depth';

    /**
     * @var string $treePathColumn
     */
    protected string $treePathColumn = 'path';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'parent_id',
        'depth',
        'path',
        'slug',
        'name',
        'description',
        'meta_title',
        'meta_description',
        'is_active',
        'sort_order',
    ];

    /**
     * @var string[] $casts
     */
    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * @var array|string[] $translatable
     */
    public array $translatable = [
        'name',
        'description',
        'meta_title',
        'meta_description'
    ];

    /**
     * @var array $sortable
     */
    public array $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function (Category $model) {
            $model->depth = null;
            $model->path = null;

            $computed = $model->computePathAndDepth($model->parent_id);
            $model->depth = $computed['depth'];
            $model->path = $computed['path'];
        });

        static::updating(function (Category $model) {
            if ($model->isDirty('parent_id')) {
                $computed = $model->computePathAndDepth($model->parent_id);
                $model->depth = $computed['depth'];
                $model->path = $computed['path'];
            }
        });

        static::updated(function (Category $model) {
            if ($model->wasChanged('parent_id') || $model->wasChanged('path')) {
                $model->cascadeRecomputeChildren($model);
            }
        });
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_categories')
            ->withPivot('sort_order');
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
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('icon')->singleFile();   // small icon
        $this->addMediaCollection('banner')->singleFile(); // category banner
        $this->addMediaCollection('gallery');              // additional images
    }
}
