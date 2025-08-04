<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
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

    protected function afterCreate(): void
    {
        // 建立 UserDetail (如果有資料)
        if (isset($this->userDetailData) && !empty(array_filter($this->userDetailData))) {
            $this->userDetailData['user_id'] = $this->record->id;
            $this->record->userDetail()->create($this->userDetailData);
        }
    }

    protected $userDetailData = [];
}
