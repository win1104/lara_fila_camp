<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        // 從 session 中獲取頁次信息
        if ($page = session('products_list_page')) {
            session()->forget('products_list_page');
            return static::$resource::getUrl('index', ['page' => $page]);
        }

        // 預設回到第一頁
        return static::$resource::getUrl('index');
    }
}
