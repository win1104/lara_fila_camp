<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    public function salesman(): BelongsTo
    {
        return $this->belongsTo(Salesman::class);
    }

    public function journeys(): HasMany
    {
        return $this->hasMany(Journey::class);
    }
    //
}
