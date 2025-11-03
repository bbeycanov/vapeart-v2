<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModelWidget extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'model_widgets';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'model_type',
        'model_id',
        'widget_id',
    ];

    /**
     * @var string[] $casts
     */
    protected $casts = [
        'settings' => 'array',
    ];

    /**
     * @return MorphTo
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function widget(): BelongsTo
    {
        return $this->belongsTo(Widget::class);
    }
}
