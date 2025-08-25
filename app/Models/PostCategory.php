<?php

namespace App\Models;

use App\Models\Post;
use App\Traits\LoggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PostCategory extends Model
{
    use LoggableTrait;
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

    }

    /**
     * 定義要記錄的欄位
     */
    public function getLoggableAttributes(): array
    {
        return [
            'id',
            'locale',
            'slug',
            'title'
        ];
    }
}
