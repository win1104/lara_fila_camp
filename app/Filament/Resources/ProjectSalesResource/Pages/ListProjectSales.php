<?php

namespace App\Filament\Resources\ProjectSalesResource\Pages;

use App\Filament\Resources\ProjectSalesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectSales extends ListRecords
{
    protected static string $resource = ProjectSalesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
