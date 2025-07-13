<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectJourney extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_menu_slug',
        'slug',
        'title',
        'tag',
        'order',
        'display',
        'date',
        'url',
        'url_target',
        'image',
        'info',
        'intro',
        'content',
        'check',
        'fixuser',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_menu_slug', 'slug');
    }
}
