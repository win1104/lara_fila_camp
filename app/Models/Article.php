<?php

namespace App\Models;

use Awcodes\Curator\Models\Media;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

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

        static::created(function ($model) {
            // 呼叫自訂日誌方法
            self::logChange('created', $model);
        });

        static::updated(function ($model) {
            // 呼叫自訂日誌方法
            self::logChange('updated', $model);
        });
    }

    protected static function logChange($action, $model)
    {
        // 寫入日誌，可以根據需要調整日誌格式
        Log::info("Article : A record has been {$action}: ", $model->toArray());
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return static::where('slug', $value)
            ->where('locale', app()->getLocale())
            ->firstOrFail();
    }
}
