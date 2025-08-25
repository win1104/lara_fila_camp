<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\UserResource\Widget\UserStatsOverview;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // 關鍵：在這裡加入 Header Widgets
    protected function getHeaderWidgets(): array
    {
        return [
            UserStatsOverview::class,
        ];
    }

    // 可選：設定 Widget 的欄位數（響應式）
    // protected function getHeaderWidgetsColumns(): int | array
    // {
    //     return [
    //         'sm' => 1,
    //         'md' => 2,
    //         'lg' => 4,
    //     ];
    // }
}
