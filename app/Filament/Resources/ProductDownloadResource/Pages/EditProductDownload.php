<?php

namespace App\Filament\Resources\ProductDownloadResource\Pages;

use App\Filament\Resources\ProductDownloadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductDownload extends EditRecord
{
    protected static string $resource = ProductDownloadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}