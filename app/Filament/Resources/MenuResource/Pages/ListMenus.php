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

    protected function getHeaderWidgets(): array
    {
        return [
            MenuWidget::class
        ];
    }
}
