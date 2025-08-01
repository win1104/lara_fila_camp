<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\PostCategory;
use Awcodes\Curator\Models\Media;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    //
    protected $fillable = [
        'locale',
        'menu_slug',
        'slug',
        'title',
        'tag',
        'order',
        'display',
        'date',
        'url',
        'url_target',
        'media_id',
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
        return 'slug';
    }


    public function menu():BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_slug', 'slug');
            // ->where('locale', $this->locale);
    }

    // 定義與 Curator Media 模型的多對多關聯
    // 預設會使用 post_media 這樣的中間表
    // 如果你的中間表名稱不同，需要指定第三和第四個參數
    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Media::class, 'post_media', 'post_id', 'media_id')
                    ->withPivot('order') // 如果你需要排序，可以在中間表添加 'order' 欄位
                    // ->orderBy('pivot_order'); // 依據排序欄位排序
                    ->orderBy('order'); // 依據排序欄位排序
    }

    public function post_category():BelongsToMany
    {
        // 暫時使用最基本的關聯，不加任何條件
        return $this->belongsToMany(PostCategory::class, 'post_relation', 'post_slug', 'post_category_slug', 'slug', 'slug')
            ->withTimestamps();
    }

    // 建立一個專門用於 Filament 的關聯方法
    public function post_category_for_filament():BelongsToMany
    {
        return $this->belongsToMany(PostCategory::class, 'post_relation', 'post_slug', 'post_category_slug', 'slug', 'slug')
            ->withTimestamps();
    }


    // public function resolveRouteBinding($value, $field = null)
    // {
    //     $locale = request()->route('locale') ?? app()->getLocale();

    //     // 對於 Filament admin 路由，根據 locale 和 slug 查找
    //     if (request()->route()->getName() && str_contains(request()->route()->getName(), 'filament.admin.resources.posts')) {
    //         return $this->where('slug', $value)
    //             ->where('locale', $locale)
    //             ->first();
    //     }

    //     // 對於前端路由，保持原有邏輯
    //     $post = $this->whereHas('menu', function ($query) use ($value, $locale) {
    //         $query->where('slug', $value)
    //             ->where('locale', $locale);
    //     })
    //     ->where('display', 1)
    //     ->first();

    //     return $post;
    // }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->locale)) {
                // $model->locale = 'tw';
                $model->locale = app()->getLocale();
                // $model->locale = config('app.locale');
                // $data['locale'] = App::getLocale();
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
