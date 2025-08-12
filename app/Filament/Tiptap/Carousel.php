<?php

namespace App\Filament\Tiptap;

use FilamentTiptapEditor\TiptapBlock;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Component;

class Carousel extends TiptapBlock
{
    public string $preview = 'blocks.previews.carousel';

    public string $rendered = 'blocks.rendered.carousel';

    public ?string $label = '';

    public ?string $icon = 'icon-carousel';

    // public function getIcon(): ?string
    // {
    //     return 'custom-icons::logo-icon';
    // }

    public function getFormSchema(): array
    {
        return [
            Repeater::make('images')
                ->schema([
                    FileUpload::make('image')->required()
                ])

        ];
    }
}
