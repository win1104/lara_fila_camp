<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Journey extends Model
{
    protected $casts = [
        'price' => MoneyCast::class,
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    //
}
