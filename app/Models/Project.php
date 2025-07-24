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
        'status',
        'sales_id',
        'fixuser',
    ];

    protected $table = 'projects';

    public function projectsales(): BelongsTo
    {
        return $this->belongsTo(ProjectSales::class, 'sales_id');
    }

    public function projectjourney(): HasMany
    {
        return $this->hasMany(ProjectJourney::class, 'project_slug', 'slug')
            ->where('locale', $this->locale);
    }

    public function projectoptions(): HasMany
    {
        return $this->hasMany(ProjectOption::class, 'project_slug', 'slug')
            ->where('locale', $this->locale);
    }

    public function projectflights(): HasMany
    {
        return $this->hasMany(ProjectFlight::class, 'project_slug', 'slug')
            ->where('locale', $this->locale);
    }
}
