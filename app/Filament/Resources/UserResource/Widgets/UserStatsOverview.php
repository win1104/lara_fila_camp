<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;

class UserStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('總用戶數', User::count())
                ->description('註冊用戶總數')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]), // 小型趨勢圖

            Stat::make('今日註冊', User::whereDate('created_at', today())->count())
                ->description('今天新註冊的用戶')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('info')
                ->chart([0, 0]), // 小型趨勢圖

            Stat::make('本月新增', User::whereMonth('created_at', now()->month)->count())
                ->description('本月註冊用戶數')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('warning'),

            Stat::make('活躍用戶', User::where('last_login_at', '>=', now()->subDays(30))->count())
                ->description('30天內活躍用戶')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
        ];
    }
}
