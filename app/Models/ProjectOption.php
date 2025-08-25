<?php

namespace App\Models;

use App\Traits\LoggableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectOption extends Model
{
    use HasFactory, LoggableTrait;

    protected $table = 'project_options';

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

    /**
     * 定義要記錄的欄位
     */
    public function getLoggableAttributes(): array
    {
        return [
            'id',
            'locale',
            'project_slug',
            'name',
            'slug',
            'type',
            'order'
        ];
    }
}