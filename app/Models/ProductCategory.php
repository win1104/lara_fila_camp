<?php

namespace App\Models;

use App\Models\Product;
use App\Traits\LoggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use SolutionForest\FilamentTree\Concern\ModelTree;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    use ModelTree, LoggableTrait;

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

    protected $table = 'product_categories';

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
    //     // return $this->hasMany(Product::class, 'product_category_id', 'id')
    //     return $this->hasMany(Product::class, 'product_category_slug', 'slug')
    //         ->where('locale', $this->locale);
    // }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_relation', 'product_category_slug', 'product_slug', 'slug', 'slug')
            ->where('locale', app()->getLocale());
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
        if (request()->route()->getName() && str_contains(request()->route()->getName(), 'filament.admin.resources.product-categories')) {
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
        Log::info("ProductCategory : A record has been {$action}: ", $model->toArray());
    }

    // /**
    //  * Generate a tree structure of categories and their products for SelectTree.
    //  *
    //  * @param string $locale
    //  * @param string|null $parentSlug
    //  * @return array
    //  */
    // public static function getCategoryProductTree(string $locale, ?string $parentSlug = 'home'): array
    // {
    //     $tree = [];

    //     // 獲取當前層級的分類
    //     $categories = self::where('locale', $locale)
    //         ->where('parent_slug', $parentSlug)
    //         ->orderBy('order')
    //         ->get();

    //     foreach ($categories as $category) {
    //         $children = self::getCategoryProductTree($locale, $category->slug);

    //         // 獲取此分類下的產品
    //         $products = $category->products()->where('locale', $locale)->get();
    //         foreach ($products as $product) {
    //             // 將產品作為子節點加入，ID 前綴 "product-" 以便區分
    //             $children[] = [
    //                 'id' => 'product-' . $product->slug,
    //                 'label' => $product->title,
    //             ];
    //         }

    //         // 將分類作為節點加入
    //         $tree[$category->slug] = [
    //             'id' => $category->slug,
    //             'label' => $category->title,
    //             'children' => $children,
    //         ];
    //     }

    //     return $tree;
    // }
    public static function getProductTree($locale = 'tw')
    {
        $allCategories = ProductCategory::where('locale', $locale)->get()->keyBy('slug');
        $products = Product::where('locale', $locale)->get()->groupBy('product_category_slug');

        // 遞迴組分類樹
        $buildTree = function ($parentSlug) use (&$buildTree, $allCategories, $products) {
            return $allCategories->filter(fn($cat) => $cat->parent_slug === $parentSlug)->map(function ($cat) use (&$buildTree, $products) {
                return [
                    'id' => $cat->title,
                    // 'label' => $cat->title,
                    // 'children' => collect($products[$cat->slug] ?? [])->map(function ($product) {
                    //     return [
                    //         'id' => $product->slug,
                    //         'label' => $product->title,
                    //     ];
                    // })->concat($buildTree($cat->slug))->values(),
                    'children' => $cat->title,
                ];
            })->values();
        };

        return $buildTree('home'); // 由最上層 home 開始
    }

}
