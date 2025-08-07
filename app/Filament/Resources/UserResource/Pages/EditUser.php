<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // 載入 UserDetail 資料到表單
        if ($this->record->userDetail) {
            foreach ($this->record->userDetail->toArray() as $key => $value) {
                if ($key !== 'id' && $key !== 'user_id' && $key !== 'created_at' && $key !== 'updated_at' && $key !== 'deleted_at') {
                    $data["detail_{$key}"] = $value;
                }
            }
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // 分離 User 和 UserDetail 的資料，只返回 User 的資料
        $userData = [];
        $userDetailData = [];
        
        foreach ($data as $key => $value) {
            if (str_starts_with($key, 'detail_')) {
                $userDetailKey = str_replace('detail_', '', $key);
                $userDetailData[$userDetailKey] = $value;
            } else {
                $userData[$key] = $value;
            }
        }

        // 將 UserDetail 資料暫存
        $this->userDetailData = $userDetailData;

        return $userData;
    }

    protected function afterSave(): void
    {
        // 更新或建立 UserDetail
        if (isset($this->userDetailData) && !empty(array_filter($this->userDetailData))) {
            if ($this->record->userDetail) {
                $this->record->userDetail->update($this->userDetailData);
            } else {
                $this->userDetailData['user_id'] = $this->record->id;
                $this->record->userDetail()->create($this->userDetailData);
            }
        }
    }

    protected $userDetailData = [];
}
