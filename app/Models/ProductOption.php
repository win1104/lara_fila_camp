<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LoggableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOption extends Model
{
    use HasFactory, LoggableTrait;

    protected $table = 'products_options';

    protected $fillable = [
        'locale',
        'product_slug',
        'name',
        'slug',
        'type',
        'order',
        'display',
        'date',
        'description',
        'admin_id',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_slug', 'slug');
    }

    // public function admin(): BelongsTo
    // {
    //     return $this->belongsTo(Admin::class);
    // }
}
