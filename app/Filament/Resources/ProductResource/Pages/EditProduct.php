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
        // 從 URL 中提取語系
        $path = request()->getPathInfo();
        $locale = app()->getLocale(); // 預設值
        if (preg_match('#^/([a-z]{2})/#', $path, $matches)) {
            $locale = $matches[1];
        }

        // 從 session 中獲取頁次信息
        if ($page = session('products_list_page')) {
            session()->forget('products_list_page');
            return "/{$locale}/admin/products?page={$page}";
        }

        // 預設回到第一頁，保持語系
        return "/{$locale}/admin/products";
    }
}
