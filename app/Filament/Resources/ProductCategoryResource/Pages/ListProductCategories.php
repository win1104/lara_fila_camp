<?php

namespace App\Filament\Resources\ProductCategoryResource\Pages;

use Filament\Actions;
// use App\Filament\Widgets\ProductCategory;
// use App\Filament\Widgets\ProductCategoryWidget;
// use App\Filament\Widgets\ProductCategoryWidget as ProductCategory;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ProductCategoryResource;
use App\Filament\Widgets\ProductCategoryWidget;

class ListProductCategories extends ListRecords
{
    protected static string $resource = ProductCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ProductCategoryWidget::class
        ];
    }
}
