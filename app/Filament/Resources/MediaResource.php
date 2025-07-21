<?php

namespace App\Filament\Resources;

use Awcodes\Curator\Resources\MediaResource as BaseResource;

class MediaResource extends BaseResource
{

    public static function getModelLabel(): string
    {
        return __('backstage.media_manage');
    }
    public static function getModelPluralLabel(): string
    {
        return __('backstage.media_manage');
    }
    public static function getNavigationLabel(): string
    {
        return __('backstage.media_manage');
    }


    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'path'];
    }

    /* Navigation 的 label 旁有資料總筆數的數字 */
    public static function getNavigationBadge(): ?string
    {
        // return static::getModel()::count();
        return null;
    }
}
