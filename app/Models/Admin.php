<?php

namespace App\Models;

use App\Traits\LoggableTrait;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable implements FilamentUser
{
    use Notifiable, LoggableTrait;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true; // 或者加入其他條件
    }

    /**
     * 定義要記錄的欄位 - Admin 避免記錄敏感信息
     */
    public function getLoggableAttributes(): array
    {
        return [
            'id',
            'name',
            'email'
        ];
    }
}
