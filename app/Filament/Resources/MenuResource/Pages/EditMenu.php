<?php

namespace App\Filament\Resources\MenuResource\Pages;

use App\Filament\Resources\MenuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Menu;

class EditMenu extends EditRecord
{
    protected static string $resource = MenuResource::class;

    public function mount(int | string $record): void
    {
        $url = request()->query('code');
        // $url = url()->current();

        // Log::info('PostsRelationManager URL:', ['url' => $url]);

        if (str_contains($url, 'widget')) {
            $url_title = 'widget';
        }

        $url_title = 'table';




        $this->record = $this->resolveRecord($record);

        $this->authorizeAccess();

        $this->fillForm();

        $this->previousUrl = url()->previous();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [];
    }
}
