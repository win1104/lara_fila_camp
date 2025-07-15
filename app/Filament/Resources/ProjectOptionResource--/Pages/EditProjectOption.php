<?php

namespace App\Filament\Resources\ProjectOptionResource\Pages;

use App\Filament\Resources\ProjectOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectOption extends EditRecord
{
    protected static string $resource = ProjectOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
