<?php

namespace App\Filament\Resources\MenuResource\Pages;

use Filament\Actions;
use App\Filament\Resources\MenuResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\MenuResource\Widgets\MenuWidget;

class ListMenus extends ListRecords
{
    protected static string $resource = MenuResource::class;

    // public $this->makeTable::recordTitle = '網站選單';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function mount(): void
    {
        // 保存當前頁次到 session
        if (request()->has('page')) {
            session(['menus_list_page' => request('page')]);
        }
    }

    protected function getHeaderWidgets(): array
    {
        return [
            MenuWidget::class
        ];
    }
}
