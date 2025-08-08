<?php

namespace App\Filament\Tiptap;
use FilamentTiptapEditor\TiptapBlock;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class Step extends TiptapBlock
{
    public string $preview = 'blocks.previews.step';

    public string $rendered = 'blocks.rendered.step';

    public ?string $label = '';

    public ?string $icon = '/icon-step.svg';

    public function getFormSchema(): array
    {
        return [
            Repeater::make('steps')
                ->schema([
                    FileUpload::make('image')
                        ->required()
                        ->label('步驟圖片'),
                    TextInput::make('title')
                        ->label('步驟標題')
                        ->required(),
                    Textarea::make('contact')
                        ->label('步驟內容')
                        ->required(),
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
