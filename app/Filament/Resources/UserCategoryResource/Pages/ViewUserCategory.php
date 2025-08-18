<?php

namespace App\Filament\Resources\UserCategoryResource\Pages;

use App\Filament\Resources\UserCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUserCategory extends ViewRecord
{
    protected static string $resource = UserCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}