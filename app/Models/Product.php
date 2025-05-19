<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Log;
// use App\Models\Category;
use App\Models\ProductCategory;

class Product extends Model
{
    use HasFactory;

    //
    protected $fillable = [
        'locale',
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

    public function product_category():BelongsToMany
    {
        return $this->BelongsToMany(ProductCategory::class, 'product_relation', 'product_id', 'product_category_id')
            ->withTimestamps();
            // ->withPivot(['created_at', 'update_at']);
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
        Log::info("Product : A record has been {$action}: ", $model->toArray());
    }

}
