<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use SolutionForest\FilamentTree\Concern\ModelTree;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use ModelTree;

    protected $fillable = [
        'locale',
        'slug',
        'type',
        'title',
        'parent_id',
        'order',
        'display',
        'note',
        'fixuser',
    ];

    // protected $casts = [
    //     'parent_id' => 'int'
    // ];

    protected $table = 'menus';

    // public function Menus():HasMany
    // {
    //     return $this->hasMany(Menu::class);
    // }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
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
        Log::info("Menu : A record has been {$action}: ", $model->toArray());
    }
}
