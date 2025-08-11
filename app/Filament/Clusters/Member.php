<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;
use Filament\Navigation\NavigationItem;
use App\Filament\Resources\PostResource;
use App\Filament\Resources\PostCategoryResource;

class Member extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'My Member';

    protected static ?int $navigationSort = 1;

    // 可選：設定群組描述
    protected static ?string $navigationGroup = 'Member Management';

    // 設定是否應該在導航中顯示
    protected static bool $shouldRegisterNavigation = true;


    //  // 設定為顯示在頂部
    // protected static ?string $navigationGroup = null;

    // // 或者完全隱藏在側邊欄，改用頂部導航
    // protected static bool $shouldRegisterNavigation = false;

    // // 自訂導航項目
    // public static function getNavigationItems(): array
    // {
    //     return [
    //         // 自訂導航邏輯
    //         NavigationItem::make('文章管理')
    //             ->url(PostResource::getUrl('index'))
    //             ->icon('heroicon-o-document')
    //             ->badge(fn () => \App\Models\Post::count())
    //             ->sort(1),

    //         NavigationItem::make('分類管理')
    //             ->url(PostCategoryResource::getUrl('index'))
    //             ->icon('heroicon-o-folder')
    //             ->badge(fn () => \App\Models\Post::count())
    //             ->sort(2),

    //         NavigationItem::make('標籤管理')
    //             ->url(PostResource::getUrl('index'))
    //             ->icon('heroicon-o-tag')
    //             ->badge(fn () => \App\Models\Post::count())
    //             ->sort(3),

    //         NavigationItem::make('新增文章')
    //             ->url(PostResource::getUrl('create'))
    //             ->icon('heroicon-o-plus')
    //             ->sort(4),
    //     ];
    // }
}
