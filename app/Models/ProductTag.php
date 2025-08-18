<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductTag extends Model
{
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
}