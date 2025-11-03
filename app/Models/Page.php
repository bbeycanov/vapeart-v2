<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @method static updateOrCreate(array $array, mixed $lang)
 * @property mixed $slug
 */
class Page extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use HasTranslations;
    use InteractsWithMedia;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'slug',
        'template',
        'title',
        'excerpt',
        'body',
        'meta_title',
        'meta_description',
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
     * @var array|string[]
     */
    public array $translatable = [
        'title',
        'excerpt',
        'body',
        'meta_title',
        'meta_description'
    ];

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured')->singleFile();
        $this->addMediaCollection('gallery');
    }

    /**
     * @param $q
     * @return mixed
     */
    public function scopePublished($q): mixed
    {
        return $q->where('status', 1)->where('is_active', true)
            ->whereNotNull('published_at')->where('published_at', '<=', now());
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
}
