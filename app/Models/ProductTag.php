<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LoggableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductTag extends Model
{
    use LoggableTrait;
    protected $fillable = [
        'locale',
        'slug',
        'title',
        'order',
        'display',
        'color',
        'note',
        'creator_id',
        'created_at',
        'updated_at',
    ];

    protected $table = 'product_tags';

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return 多對多的關係
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_tag_relations', 'product_tag_slug', 'product_slug', 'slug', 'slug')
            ->withTimestamps();
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
            'title',
            'order'
        ];
    }
}