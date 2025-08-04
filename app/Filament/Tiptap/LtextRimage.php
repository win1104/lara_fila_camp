<?php

namespace App\Filament\Tiptap;
use FilamentTiptapEditor\TiptapBlock;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload as FilamentFileUpload;

class LtextRimage extends TiptapBlock
{
    public string $preview = 'blocks.previews.ltextrimage';

    public string $rendered = 'blocks.rendered.ltextrimage';

    public function getFormSchema(): array
    {
        return [
            TextInput::make('title')->required(),
            Textarea::make('contact')->required(),
            FilamentFileUpload::make('image')->required(),
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