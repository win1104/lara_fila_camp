<?php

namespace App\Models;

use App\Models\Menu;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    //
    protected $fillable = [
        'menu_slug',
        'slug',
        'title',
        'tag',
        'order',
        'display',
        'date',
        'url',
        'url_target',
        'image',
        'info',
        'intro',
        'content',
        'check',
        'fixuser',
    ];

    // public function category():BelongsTo
    // {
    //     return $this->belongsTo(Category::class);
    // }

    public function menu():BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_slug', 'slug')
            ->where('locale', $this->locale);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->locale)) {
                $model->locale = config('app.locale');
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
        Log::info("Post : A record has been {$action}: ", $model->toArray());
    }

}
