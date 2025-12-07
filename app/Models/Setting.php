<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static firstOrNew(string[] $array)
 * @method static whereIn(string $string, array $miss)
 * @property mixed $key
 */
class Setting extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasTranslations;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'key',
        'value',
        'group',
        'is_public',
        'is_active',
        'sort_order',
    ];

    /**
     * @var string[] $casts
     */
    protected $casts = ['value' => 'array'];

    /**
     * @var array|string[] $translatable
     */
    public array $translatable = ['value'];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::saved(function (self $model) {
            Cache::forget(self::cacheKey($model->key));
        });

        static::deleted(function (self $model) {
            Cache::forget(self::cacheKey($model->key));
        });
    }

    /**
     * @param string $key
     * @return string
     */
    public static function cacheKey(string $key): string
    {
        return "setting:$key";
    }
}
