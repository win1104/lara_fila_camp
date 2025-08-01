<?php

namespace App\Filament\Resources\ProjectSalesResource\Pages;

use App\Filament\Resources\ProjectSalesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectSales extends EditRecord
{
    protected static string $resource = ProjectSalesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
