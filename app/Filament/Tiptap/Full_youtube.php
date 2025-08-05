<?php

namespace App\Filament\Tiptap;
use FilamentTiptapEditor\TiptapBlock;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;

class Full_youtube extends TiptapBlock
{
    public string $preview = 'blocks.previews.full_youtube';

    public string $rendered = 'blocks.rendered.full_youtube';

    public function getFormSchema(): array
    {
        return [
            TextInput::make('url')
                ->label('網址')
                ->type('url')
                ->placeholder('https://example.com')
                ->required()
                ->rule('url'),
        ];
    }
}