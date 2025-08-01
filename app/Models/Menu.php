<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $fillable = [
        'locale',
        'slug',
        'parent_slug',
        'type',
        'title',
        'order',
        'display',
        'url',
        'url_target',
        'note',
        'fixuser',
    ];

    protected $table = 'menus';

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Retrieve the model for a bound value.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        // 先嘗試從路由參數取得
        $locale = request()->route('locale');

        // 如果沒有，從 URL 路徑中提取
        if (!$locale) {
            $path = request()->path();
            if (preg_match('/^([a-z]{2})\//', $path, $matches)) {
                $locale = $matches[1];
            }
        }

        // 如果還是沒有，從 referer 中提取
        if (!$locale && request()->header('Referer')) {
            $refererPath = parse_url(request()->header('Referer'), PHP_URL_PATH);
            if (preg_match('/^\/([a-z]{2})\//', $refererPath, $matches)) {
                $locale = $matches[1];
            }
        }

        // 最後回退到應用預設語系
        $locale = $locale ?? app()->getLocale();

        // 強制寫入日誌
        // \Illuminate\Support\Facades\Log::info('Menu resolveRouteBinding CALLED:', [
        //     'slug' => $value,
        //     'locale' => $locale,
        //     'route_locale' => request()->route('locale'),
        //     'path' => request()->path(),
        //     'referer' => request()->header('Referer'),
        //     'timestamp' => now(),
        // ]);

        // 也寫入到檔案
        file_put_contents(
            storage_path('logs/debug-menu-binding.log'),
            date('Y-m-d H:i:s') . " - resolveRouteBinding called with slug: {$value}, locale: {$locale}\n",
            FILE_APPEND
        );

        return $this->where('slug', $value)
            ->where('locale', $locale)
            ->first();
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'menu_slug', 'slug')
            ->where('locale', $this->locale);
    }

    public static function defaultParentKey()
    {
        return 'home';
    }

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_slug', 'slug');
    }

    public function children()
    {
        return $this->hasMany(static::class, 'parent_slug', 'slug')
            ->orderBy('order');
    }

    public function allChildren()
    {
        return $this->children()->with('children');
    }

    public function isRoot(): bool
    {
        return $this->parent_slug === static::defaultParentKey();
    }

    protected static function boot()
    {
        parent::boot();

        // 指定排序
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order', 'asc');
        });

        // 在儲存前處理
        static::saving(function ($model) {
            // 如果是新記錄且沒有指定順序，則設為最後
            if (!$model->exists && !$model->order) {
                $lastOrder = static::query()
                    ->where('locale', $model->locale)
                    ->where('parent_slug', $model->parent_slug ?: static::defaultParentKey())
                    ->max('order');
                $model->order = ($lastOrder ?? 0) + 1;
            }

            // 確保有 parent_slug
            if (empty($model->parent_slug)) {
                $model->parent_slug = static::defaultParentKey();
            }

            // 除錯資訊
            // \Illuminate\Support\Facades\Log::info('Menu Saving:', [
            //     'slug' => $model->slug,
            //     'parent_slug' => $model->parent_slug,
            //     'order' => $model->order,
            //     'changes' => $model->getDirty()
            // ]);
        });

        // 攔截所有更新操作
        static::updating(function ($model) {
            $dirty = $model->getDirty();

            // 如果嘗試更新 parent_id，則改為更新 parent_slug
            if (isset($dirty['parent_id'])) {
                $model->parent_slug = $dirty['parent_id'];
                unset($model->attributes['parent_id']);

                // 除錯資訊
                // \Illuminate\Support\Facades\Log::info('Intercepted parent_id update:', [
                //     'original_parent_id' => $dirty['parent_id'],
                //     'new_parent_slug' => $model->parent_slug
                // ]);
            }

            return true;
        });

        static::creating(function ($model) {
            if (empty($model->locale)) {
                $model->locale = config('app.locale');
            }
        });

        static::updated(function ($model) {
            // 如果 parent_slug 改變了，更新排序
            if ($model->wasChanged('parent_slug')) {
                static::reorderSiblings($model);
            }
        });
    }

    protected static function reorderSiblings($model)
    {
        // 取得同層級的所有記錄
        $siblings = static::query()
            ->where('locale', $model->locale)
            ->where('parent_slug', $model->parent_slug)
            ->where('id', '!=', $model->id)
            ->orderBy('order')
            ->get();

        // 重新排序
        $order = 1;
        foreach ($siblings as $sibling) {
            if ($order == $model->order) {
                $order++;
            }
            if ($sibling->order != $order) {
                $sibling->update(['order' => $order]);
            }
            $order++;
        }
    }

    // 覆寫 setAttribute 方法來攔截所有屬性設定
    public function setAttribute($key, $value)
    {
        // 如果嘗試設定 parent_id，則改為設定 parent_slug
        if ($key === 'parent_id') {
            $this->attributes['parent_slug'] = $value;
            return $this;
        }

        return parent::setAttribute($key, $value);
    }

    // 覆寫 getAttribute 方法來處理屬性讀取
    public function getAttribute($key)
    {
        // 如果嘗試讀取 parent_id，則返回 parent_slug
        if ($key === 'parent_id') {
            return $this->attributes['parent_slug'] ?? null;
        }

        return parent::getAttribute($key);
    }
}
