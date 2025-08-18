<?php

namespace App\Models;

use App\Enums\TagType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Tag extends Model
{
    protected $fillable = [
        'locale',
        'type',
        'name',
        'color',
        'taggable_type',
        'taggable_id',
        'creator_id',
    ];

    protected $attributes = [
        'locale' => 'tw',
    ];

    // 自動轉換為 Enum
    protected $casts = [
        'type' => TagType::class,
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function taggable(): MorphTo
    {
        return $this->morphTo();
    }
}
