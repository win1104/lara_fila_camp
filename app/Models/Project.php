<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'locale',
        'slug',
        'parent_slug',
        'type',
        'title',
        'order',
        'display',
        'note',
        'fixuser',
        'sales_id',
    ];

    protected $table = 'projects';

    public function projectsales(): BelongsTo
    {
        return $this->belongsTo(ProjectSales::class);
    }

    public function projectjourney(): HasMany
    {
        return $this->hasMany(ProjectJourney::class, 'project_slug', 'slug')
            ->where('locale', $this->locale);
    }
}
