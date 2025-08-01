<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PostCategory extends Model
{
    protected $fillable = [
        'locale',
        'slug',
        'title',
        'order',
        'display',
        'note',
        'fixuser',
        'created_at',
        'updated_at',

    ];

    protected $table = 'post_categories';

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function posts():HasMany
    {
        // return $this->hasMany(Product::class, 'product_category_id', 'id')
        return $this->hasMany(Post::class, 'post_category_slug', 'slug')
            ->where('locale', $this->locale);


        // return $this->belongsToMany(Post::class, 'post_relation', 'post_category_slug', 'post_slug', 'slug', 'slug')
        //     ->withTimestamps();
    }

    protected static function boot()
    {
        parent::boot();

        // 指定排序
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order', 'asc');
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
        Log::info("ProductCategory : A record has been {$action}: ", $model->toArray());
    }


}
