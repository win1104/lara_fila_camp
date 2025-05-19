<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use SolutionForest\FilamentTree\Concern\ModelTree;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    use ModelTree;

    protected $fillable = [
        'title',
        'parent_id',
        'order',
    ];

    protected $casts = [
        'parent_id' => 'int'
    ];

    protected $table = 'product_categories';

    public function products():HasMany
    {
        return $this->hasMany(Product::class);
    }



    protected static function boot()
    {
        parent::boot();

        // 指定排序
        static::addGlobalScope('sort', function (Builder $builder) {
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
