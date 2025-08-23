<?php

namespace App\Models;

use App\Traits\LoggableTrait;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory, LoggableTrait;

    protected $fillable = [
        'locale',
        'title',
        'slug',
        'sort',
        'tag',
        'data',
        'content',
        'media_id',
        // 'image',
        'is_published',
        'published_at',
    ];

    public function image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->locale)) {
                $model->locale = app()->getLocale();
            }
        });

    }

    /**
     * 定義要記錄的欄位
     */
    public function getLoggableAttributes(): array
    {
        return [
            'id',
            'locale',
            'slug',
            'title'
        ];
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return static::where('slug', $value)
            ->where('locale', app()->getLocale())
            ->firstOrFail();
    }
}
