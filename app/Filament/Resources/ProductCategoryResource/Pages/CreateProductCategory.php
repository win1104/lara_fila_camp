<?php

namespace App\Filament\Resources\ProductCategoryResource\Pages;

use App\Filament\Resources\ProductCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProductCategory extends CreateRecord
{
    protected static string $resource = ProductCategoryResource::class;

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
        return "/{$currentLocale}/admin/product-categories";
    }
}
