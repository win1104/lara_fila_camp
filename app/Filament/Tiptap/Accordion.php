<?php

namespace App\Filament\Tiptap;
use FilamentTiptapEditor\TiptapBlock;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class Accordion extends TiptapBlock
{
    public string $preview = 'blocks.previews.accordion';

    public string $rendered = 'blocks.rendered.accordion';

    public string $width = 'xl';

    public ?string $label = '';

    public ?string $icon = 'icon-accordion';

    public function getFormSchema(): array
    {
        return [
            Repeater::make('accordions')
                ->schema([
                    TextInput::make('title')
                        ->label('手風琴標題')
                        ->required(),
                    Textarea::make('contact')
                        ->label('手風琴內容')
                        ->required(),
                ]),
        ];
    }
}
