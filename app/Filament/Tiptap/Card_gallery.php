<?php

namespace App\Filament\Tiptap;
use FilamentTiptapEditor\TiptapBlock;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class Card_gallery extends TiptapBlock
{
    public string $preview = 'blocks.previews.card_gallery';

    public string $rendered = 'blocks.rendered.card_gallery';

    public ?string $label = '';

    public ?string $icon = 'icon-card_gallery';

    public function getFormSchema(): array
    {
        return [
            TextInput::make('headline')
                ->label('大標題'),
            Textarea::make('abstract')
                ->label('摘要'),
            Repeater::make('galleries')
                ->schema([
                    FileUpload::make('image')
                        ->required()
                        ->label('圖片'),
                    TextInput::make('title')
                        ->required()
                        ->label('標題'),
                    TextInput::make('subtitle')
                        ->label('副標題'),
                    Textarea::make('contact')
                        ->required()
                        ->label('介紹'),
                ]),
        ];
    }
}
