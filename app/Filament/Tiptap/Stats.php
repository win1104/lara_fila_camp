<?php

namespace App\Filament\Tiptap;
use FilamentTiptapEditor\TiptapBlock;
use Filament\Forms\Components\TextInput;

class Stats extends TiptapBlock
{
    public string $preview = 'blocks.previews.stats';

    public string $rendered = 'blocks.rendered.stats';

    public function getFormSchema(): array
    {
        return [
            TextInput::make('title')->required(),
            TextInput::make('value')->required(),
            TextInput::make('description')->required(),
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