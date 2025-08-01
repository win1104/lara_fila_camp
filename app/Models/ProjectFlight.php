<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectFlight extends Model
{
    use HasFactory;

    protected $table = 'project_flights';

    protected $fillable = [
        'locale',
        'project_slug',
        'name',
        'slug',
        'type',
        'order',
        'display',
        'date',
        'description',
        'admin_id',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_slug', 'slug');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}