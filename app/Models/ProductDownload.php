<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LoggableTrait;
use Illuminate\Database\Eloquent\Builder;
use SolutionForest\FilamentTree\Concern\ModelTree;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductDownload extends Model
{
    use ModelTree;

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

    protected $table = 'product_downloads';

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * For filament-tree to recognize the parent key type as a string.
     */
    public function determineParentKeyType(): string
    {
        return 'string';
    }

    /**
     * For filament-tree to get the default parent key.
     */
    public static function defaultParentKey()
    {
        return 'home';
    }

    /**
     * For filament-tree to resolve the tree key.
     */
    public function resolveTreeKey()
    {
        return $this->slug;
    }

    // public function products(): HasMany
    // {
    //     return $this->hasMany(Product::class, 'product_download_slug', 'slug')
    //         ->where('locale', $this->locale);
    // }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_download_relation',
            'product_download_slug',
            'product_slug',
            'slug',
            'slug'
        );
    }

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_slug', 'slug');
    }

    public function children()
    {
        return $this->hasMany(static::class, 'parent_slug', 'slug')
            ->where('locale', $this->locale)
            ->orderBy('order');
    }

    public function allChildren()
    {
        return $this->children()->with(['children' => function($query) {
            $query->where('locale', $this->locale);
        }]);
    }

    public function isRoot(): bool
    {
        return $this->parent_slug === static::defaultParentKey();
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $locale = request()->route('locale') ?? app()->getLocale();

        // 對於 Filament admin 路由，根據 locale 和 slug 查找
        if (request()->route()->getName() && str_contains(request()->route()->getName(), 'filament.admin.resources.product-downloads')) {
            return $this->where('slug', $value)
                ->where('locale', $locale)
                ->first();
        }

        // 對於前端路由，根據 locale 和 slug 查找
        return $this->where('slug', $value)
            ->where('locale', $locale)
            ->first();
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
        Log::info("ProductDownload : A record has been {$action}: ", $model->toArray());
    }
}