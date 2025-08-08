<?php

namespace App\Filament\Tiptap;
use FilamentTiptapEditor\TiptapBlock;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;

class Full_bg extends TiptapBlock
{
    public string $preview = 'blocks.previews.full_bg';

    public string $rendered = 'blocks.rendered.full_bg';

    public ?string $label = '';

    public ?string $icon = '/icon-full_bg.svg';

    public function getFormSchema(): array
    {
        return [
            TextInput::make('title')->required(),
            Textarea::make('contact'),
            FileUpload::make('images')->required(),
            // TextInput::make('color'),
            // Select::make('side')
            //     ->options([
            //         'Hero' => 'Hero',
            //         'Villain' => 'Villain',
            //     ])
            //     ->default('Hero')
        ];
    }
}
