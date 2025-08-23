<?php

namespace App\Models;

use App\Models\User;
use App\Traits\LoggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserCategory extends Model
{
    use LoggableTrait;
    protected $fillable = [
        'locale',
        'slug',
        'title',
        'order',
        'display',
        'note',
        'creator_id',
        'created_at',
        'updated_at',
    ];

    protected $table = 'user_categories';

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_relation', 'user_category_slug', 'user_slug', 'slug', 'slug')
            ->withTimestamps();
    }

    protected static function boot()
    {
        parent::boot();

        // 指定排序
        // static::addGlobalScope('order', function (Builder $builder) {
        //     $builder->orderBy('order', 'asc');
        // });

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
        Log::info("UserCategory : A record has been {$action}: ", $model->toArray());
    }
}
