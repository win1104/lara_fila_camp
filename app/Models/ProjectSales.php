<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectSales extends Model
{
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
}
