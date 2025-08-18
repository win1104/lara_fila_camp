<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Product extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('product.label');
    }

    // 可選：設定群組描述
    protected static ?string $navigationGroup = 'Product';

    // 設定是否應該在導航中顯示
    // protected static bool $shouldRegisterNavigation = true;

}
