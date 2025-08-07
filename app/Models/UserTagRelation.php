<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTagRelation extends Model
{
    protected $fillable = [
        'user_id',
        'user_tag_id',
    ];

    /**
     * @return 屬於使用者的關係
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return 屬於標籤的關係
     */
    public function userTag(): BelongsTo
    {
        return $this->belongsTo(UserTag::class);
    }
}
