<?php

namespace App\Filament\Resources;

use Awcodes\Curator\Resources\MediaResource as BaseResource;

class MediaResource extends BaseResource
{
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'path'];
    }
}