<?php

namespace App\Models;

use App\Traits\LoggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserTag extends Model
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

    protected $table = 'user_tags';

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return 多對多的關係
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_tag_relations', 'user_tag_slug', 'user_slug', 'slug', 'slug')
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
