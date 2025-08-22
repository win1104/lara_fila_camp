<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Member extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __('user.member_mana');
    }

    // 可選：設定群組描述
    protected static ?string $navigationGroup = 'Member';

    // 設定是否應該在導航中顯示
    // protected static bool $shouldRegisterNavigation = true;

}
