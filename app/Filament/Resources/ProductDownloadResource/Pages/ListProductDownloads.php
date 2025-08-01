<?php

namespace App\Filament\Resources\ProductDownloadResource\Pages;

use Filament\Actions;
use App\Filament\Resources\ProductDownloadResource;
use Filament\Resources\Pages\ListRecords;

class ListProductDownloads extends ListRecords
{
    protected static string $resource = ProductDownloadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}