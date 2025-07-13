<?php

namespace App\Filament\Resources\ProjectJourneyResource\Pages;

use App\Filament\Resources\ProjectJourneyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectJourneys extends ListRecords
{
    protected static string $resource = ProjectJourneyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
