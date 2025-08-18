<?php

namespace App\Filament\Resources\UserCategoryResource\Pages;

use App\Filament\Resources\UserCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserCategories extends ListRecords
{
    protected static string $resource = UserCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}