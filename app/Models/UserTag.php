<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserTag extends Model
{
    protected $fillable = [
        'name',
        'color',
        'creator_id',
    ];

    /**
     * @return 多對多的關係
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_tag_relations');
    }
}
