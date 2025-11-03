<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class ProductReview extends Review
{
    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope('product_only', function (Builder $q) {
            $q->where('reviewable_type', Product::class);
        });
    }
}
