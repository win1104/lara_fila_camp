<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    ];

    protected $table = 'projects';

    public function journeys(): HasMany
    {
        return $this->hasMany(ProjectJourney::class, 'project_menu_slug', 'slug')
            ->where('locale', $this->locale);
    }
}
