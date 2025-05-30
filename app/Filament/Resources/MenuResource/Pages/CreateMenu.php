<?php

namespace App\Filament\Resources\MenuResource\Pages;

use App\Filament\Resources\MenuResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMenu extends CreateRecord
{
    protected static string $resource = MenuResource::class;

    protected function afterCreate(): void
    {
        // 創建相關的 post 資料
        $this->record->posts()->create([
            'title' => $this->record->title,
            'slug' => $this->record->slug,
            'menu_slug' => $this->record->slug,
            'locale' => $this->record->locale,
            'display' => false,
            'order' => 1,
        ]);
    }
}
