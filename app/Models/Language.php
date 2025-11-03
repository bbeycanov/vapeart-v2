<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static updateOrCreate(array $array, mixed $lang)
 */
class Language extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SortableTrait;

    protected $table = 'languages';

    protected $fillable = [
        'code',
        'name',
        'native_name',
        'is_default',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_default' => 'bool',
        'is_active' => 'bool'
    ];
}
