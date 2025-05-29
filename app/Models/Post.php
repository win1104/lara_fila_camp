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

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'menu_slug';
    }


    public function menu():BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_slug', 'slug')
            ->where('locale', $this->locale);
    }

    // public function resolveRouteBinding($value, $field = null)
    // {
    //     $locale = request()->route('locale') ?? app()->getLocale();

    // //     \Illuminate\Support\Facades\Log::info('Resolving Post:', [
    // //         'value' => $value,
    // //         'field' => $field,
    // //         'route' => request()->route()->getName(),
    // //         'parameters' => request()->route()->parameters()
    // //     ]);

    //     $post = $this->whereHas('menu', function ($query) use ($value, $locale) {
    //         $query->where('slug', $value)
    //             ->where('locale', $locale);
    //     })
    //     ->where('display', 1)
    //     ->first();

    // //     if (!$post) {
    // //         abort(404);
    // //     }

    // //     return $post;
    // }


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
