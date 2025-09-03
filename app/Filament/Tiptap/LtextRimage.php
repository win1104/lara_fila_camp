<?php

namespace App\Filament\Tiptap;
use FilamentTiptapEditor\TiptapBlock;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class LtextRimage extends TiptapBlock
{
    public string $preview = 'blocks.previews.ltextrimage';

    public string $rendered = 'blocks.rendered.ltextrimage';

    public string $width = 'xl';

    public ?string $label = '';

    public ?string $icon = 'icon-ltext_rimage';

    public function getFormSchema(): array
    {
        return [
            TiptapEditor::make('title')->required()
                ->tools([
                    'heading',
                    // 'bold',
                    // 'italic',
                    // 'highlight',
                    // 'color',
                    // 'link',
                    // 'bullet-list',
                    // 'ordered-list',
                    // 'align-center',
                    // 'align-justify',
                    // 'align-left',
                    // 'align-right',
                ]),
            Textarea::make('contact'),
            // FileUpload::make('image'),
            // Repeater::make('images')
            //     ->schema([
                    FileUpload::make('images')->required()
                // ])
                // ->multiple()
                // ->maxParallelUploads(1),
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
