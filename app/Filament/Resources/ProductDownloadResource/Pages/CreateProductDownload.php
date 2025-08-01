<?php

namespace App\Filament\Resources\ProductDownloadResource\Pages;

use App\Filament\Resources\ProductDownloadResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProductDownload extends CreateRecord
{
    protected static string $resource = ProductDownloadResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 從路由參數中取得語系
        $currentLocale = request()->route('locale') ?: app()->getLocale();
        $data['locale'] = $currentLocale;
        
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        $currentLocale = request()->route('locale') ?: app()->getLocale();
        return "/{$currentLocale}/admin/product-downloads";
    }
}
