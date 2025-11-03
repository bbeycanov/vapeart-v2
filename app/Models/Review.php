<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property mixed $author_name
 * @property mixed $rating
 * @property mixed $created_at
 * @property mixed $body
 * @property mixed $title
 */
class Review extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'reviewable_id',
        'reviewable_type',
        'user_id',
        'author_name',
        'author_email',
        'rating',
        'title',
        'body',
        'status',
        'published_at',
    ];

    /**
     * @var string[] $casts
     */
    protected $casts = [
        'rating' => 'integer',
        'status' => 'integer',
        'published_at' => 'datetime'
    ];

    /**
     * @return MorphTo
     */
    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @param $q
     * @return mixed
     */
    public function scopeApproved($q): mixed
    {
        return $q->where('status', 1);
    }
}
