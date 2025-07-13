<?php

namespace App\Filament\Resources\ProjectJourneyResource\Pages;

use App\Filament\Resources\ProjectJourneyResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProjectJourneys extends ManageRecords
{
    protected static string $resource = ProjectJourneyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
