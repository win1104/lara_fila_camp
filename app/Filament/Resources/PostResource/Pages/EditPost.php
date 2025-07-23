<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        // 檢查是否來自 MenuResource 的 PostsRelationManager
        $previousUrl = url()->previous();
        if (str_contains($previousUrl, '/admin/menus/') && str_contains($previousUrl, '/edit')) {
            // 如果來自 MenuResource，檢查是否有保存的頁次信息
            if (preg_match('/\/admin\/menus\/([^\/]+)\/edit/', $previousUrl, $matches)) {
                $menuSlug = $matches[1];
                
                // 檢查是否有 menus 的頁次信息
                if ($page = session('menus_list_page')) {
                    // 不要忘記頁次信息，因為用戶可能還會繼續編輯其他 posts
                    // session()->forget('menus_list_page');  
                    
                    // 回到 MenuResource 列表頁面的對應頁次
                    return route('filament.admin.resources.menus.index', [
                        'locale' => app()->getLocale(),
                        'page' => $page
                    ]);
                }
                
                // 沒有頁次信息就回到該 Menu 的編輯頁面
                return route('filament.admin.resources.menus.edit', [
                    'locale' => app()->getLocale(),
                    'record' => $menuSlug
                ]);
            }
        }

        // 否則使用一般的重定向邏輯（回到 PostResource 列表）
        if ($page = session('posts_list_page')) {
            session()->forget('posts_list_page');
            return static::$resource::getUrl('index', ['page' => $page]);
        }

        // 預設回到第一頁
        return static::$resource::getUrl('index');
    }
}
