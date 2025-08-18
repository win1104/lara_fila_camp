<?php

namespace App\Filament\Tiptap;
use FilamentTiptapEditor\TiptapBlock;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class Testimonial extends TiptapBlock
{
    public string $preview = 'blocks.previews.testimonial';

    public string $rendered = 'blocks.rendered.testimonial';

    public ?string $label = '';

    public ?string $icon = 'icon-testimonial';

    public function getFormSchema(): array
    {
        return [
            Repeater::make('testimonials')
                ->schema([
                    Textarea::make('contact')
                        ->label('介紹'),
                    FileUpload::make('image')
                        ->label('圖片'),
                    TextInput::make('title')
                        ->label('標題'),
                    TextInput::make('subtitle')
                        ->label('副標題'),
                ]),
        ];
    }
}
