<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Member extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'My Member';

    protected static ?int $navigationSort = 1;

    // 可選：設定群組描述
    protected static ?string $navigationGroup = 'Member Management';

    // 設定是否應該在導航中顯示
    protected static bool $shouldRegisterNavigation = true;

}
