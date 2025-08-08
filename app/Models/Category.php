<?php

namespace App\Models;

use App\Models\Admin;
use App\Enums\TagType;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Category extends Model
{
    protected $fillable = [
        'locale',
        'type',
        'slug',
        'title',
        'order',
        'display',
        'note',
        'taggable_type',
        'taggable_id',
        'creator_id',
    ];

    protected $table = 'categories';

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // public function creator(): BelongsTo
    // {
    //     return $this->belongsTo(Admin::class, 'creator_id');
    // }

    // 自動轉換為 Enum
    protected $casts = [
        'type' => TagType::class,
    ];

    public function taggable(): MorphTo
    {
        return $this->morphTo();
    }

    protected static function boot()
    {
        parent::boot();

        // static::addGlobalScope('order', function (Builder $builder) {
        //     $builder->orderBy('order', 'asc');
        // });

        static::created(function ($model) {
            self::logChange('created', $model);
        });

        static::updated(function ($model) {
            self::logChange('updated', $model);
        });
    }

    protected static function logChange($action, $model)
    {
        Log::info("Category : A record has been {$action}: ", $model->toArray());
    }
}
