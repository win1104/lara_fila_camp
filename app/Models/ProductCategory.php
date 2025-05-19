<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
// use SolutionForest\FilamentTree\Concern\ModelTree;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    // use ModelTree;

    protected $fillable = [
        'locale',
        'slug',
        'parent_slug',
        'type',
        'title',
        'order',
        'display',
        'note',
        'fixuser',
    ];

    // protected $casts = [
    //     'parent_id' => 'int'
    // ];

    protected $table = 'product_categories';

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function products():HasMany
    {
        return $this->hasMany(Product::class, 'product_category_id', 'id')
            ->where('locale', $this->locale);
        // return $this->hasMany(Product::class);
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
