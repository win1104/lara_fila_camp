<?php

namespace App\Models;

use App\Models\ProductOption;
use App\Models\ProductCategory;
use App\Models\ProductDownload;
use Awcodes\Curator\Models\Media;
use Illuminate\Support\Facades\Log;
// use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'media_id',
        'image',
        'info',
        'intro',
        'content',
        'check',
        'status',
        'fixuser',
    ];

    protected $casts = [
        'display' => 'boolean',
        'url_target' => 'boolean',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        // 從 URL 路徑中提取語系
        $path = request()->getPathInfo();
        if (preg_match('#^/([a-z]{2})/#', $path, $matches)) {
            $locale = $matches[1];
        } else {
            $locale = app()->getLocale();
        }

        // 根據 locale 和 slug 查找
        return $this->where('slug', $value)
            ->where('locale', $locale)
            ->first() ?? $this->where('slug', $value)->first();
    }

    public function product_category():BelongsToMany
    {
        return $this->BelongsToMany(ProductCategory::class, 'product_relation', 'product_slug', 'product_category_slug', 'slug', 'slug')
            // ->where('product_categories.locale', $this->locale ?? app()->getLocale())
            // ->where('product_relation.locale', $this->locale ?? app()->getLocale())
            ->where('product_relation.locale', app()->getLocale())
            ->where('product_categories.locale', app()->getLocale())
            // ->where('product_relation.locale', $this->locale)
            ->withTimestamps();
    }

    public function product_download():BelongsToMany
    {
        return $this->BelongsToMany(ProductDownload::class, 'product_download_relation', 'product_slug', 'product_download_slug', 'slug', 'slug')
            ->withTimestamps();
    }

    public function productOptions(): HasMany
    {
        return $this->hasMany(ProductOption::class, 'product_slug', 'slug');
    }

    // 定義與 Curator Media 模型的多對多關聯
    // 預設會使用 product_media 這樣的中間表
    // 如果你的中間表名稱不同，需要指定第三和第四個參數
    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Media::class, 'product_media', 'product_id', 'media_id')
                    ->withPivot('order') // 如果你需要排序，可以在中間表添加 'order' 欄位
                    ->orderBy('order'); // 依據排序欄位排序
                    // ->orderBy('pivot_order'); // 依據排序欄位排序
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

    protected static function booted()
    {
        static::saved(function (Product $product) {
            $slug = $product->slug;
            $targetDirectory = "media/products/pics/{$slug}";
            $disk = Storage::disk('public');

            // 建立資料夾
            if (!$disk->exists($targetDirectory)) {
                $disk->makeDirectory($targetDirectory);
            }
// dd($product->images);
            static::creating(function ($post) {
                if ($post->images) {
                    $media = Media::find($post->images);
                    if ($media) {
                        $newPath = 'posts/' . $post->slug . '/' . basename($media->path);

                        // 搬移實體檔案
                        Storage::move($media->path, $newPath);

                        // 更新媒體資料表中的 path
                        $media->update([
                            'path' => $newPath,
                        ]);
                    }
                }
            });
            // 處理 images 關聯的 Media 圖片
            // foreach ($product->images as $media) {
            //     $originalPath = $media->path;
            //     $filename = basename($originalPath);
            //     $newPath = "{$targetDirectory}/{$filename}";

            //     // 檢查舊檔是否存在，並搬移
            //     if ($disk->exists($originalPath) && !$disk->exists($newPath)) {
            //         $disk->move($originalPath, $newPath);

            //         // 更新 media 表
            //         $media->update([
            //             'directory' => $targetDirectory,
            //             'path' => $newPath,
            //         ]);
            //     }
            // }
        });
    }


    protected static function logChange($action, $model)
    {
        // 寫入日誌，可以根據需要調整日誌格式
        Log::info("Product : A record has been {$action}: ", $model->toArray());
    }

}
