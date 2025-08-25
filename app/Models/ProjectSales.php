<?php

namespace App\Models;

use App\Traits\LoggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectSales extends Model
{
    use LoggableTrait;
    protected $table = 'project_sales';
    
    protected $fillable = [
        'email',
        'name',
        'phone',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'sales_id');
    }

    /**
     * 定義要記錄的欄位
     */
    public function getLoggableAttributes(): array
    {
        return [
            'id',
            'name',
            'email',
            'phone'
        ];
    }
}
