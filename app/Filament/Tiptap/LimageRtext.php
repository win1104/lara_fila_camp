<?php

namespace App\Filament\Tiptap;
use FilamentTiptapEditor\TiptapBlock;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class LimageRtext extends TiptapBlock
{
    public string $preview = 'blocks.previews.limagertext';

    public string $rendered = 'blocks.rendered.limagertext';

    public ?string $label = '';

    public ?string $icon = '/icon-limage_rtext.svg';

    public function getFormSchema(): array
    {
        return [
            TextInput::make('title')->required(),
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
