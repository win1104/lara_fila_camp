<?php

namespace App\Models;

use App\Traits\LoggableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectJourney extends Model
{
    use HasFactory, LoggableTrait;

    protected $fillable = [
        'locale',
        'project_slug',
        'slug',
        'title',
        'tag',
        'order',
        'display',
        'date',
        'url',
        'url_target',
        'image',
        'media_id',
        'info',
        'intro',
        'content',
        'check',
        'fixuser',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_slug', 'slug');
    }

    /**
     * 定義要記錄的欄位
     */
    public function getLoggableAttributes(): array
    {
        return [
            'id',
            'locale',
            'project_slug',
            'slug',
            'title',
            'order',
            'display'
        ];
    }
}
