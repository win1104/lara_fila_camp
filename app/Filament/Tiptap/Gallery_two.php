<?php

namespace App\Filament\Tiptap;
use FilamentTiptapEditor\TiptapBlock;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class Gallery_two extends TiptapBlock
{
    public string $preview = 'blocks.previews.gallery_two';

    public string $rendered = 'blocks.rendered.gallery_two';

    public ?string $label = '';

    public ?string $icon = '/icon-gallery_two.svg';

    public function getFormSchema(): array
    {
        return [
            Repeater::make('galleries')
                ->schema([
                    FileUpload::make('image')
                        ->required()
                        ->label('圖片'),
                    TextInput::make('subtitle')
                        ->label('副標題'),
                    TextInput::make('title')
                        ->label('標題'),
                    Textarea::make('contact')
                        ->label('介紹'),
                ]),
            // TextInput::make('title1')->required(),
            // FileUpload::make('images1')->required(),
            // TextInput::make('title2'),
            // Textarea::make('contact2'),
            // FileUpload::make('images2'),
            // TextInput::make('title3'),
            // Textarea::make('contact3'),
            // FileUpload::make('images3'),
            // TextInput::make('title4'),
            // Textarea::make('contact4'),
            // FileUpload::make('images4'),
        ];
    }
}
