<?php

namespace App\Filament\Resources\ProductOptionResource\Pages;

use App\Filament\Resources\ProductOptionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProductOption extends CreateRecord
{
    protected static string $resource = ProductOptionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        dd(234);
        $data['product_slug'] = request()->query('product_slug');
        $data['admin_id'] = auth()->id();
        return $data;
    }
}
