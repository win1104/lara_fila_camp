<?php

namespace App\Filament\Tiptap;
use FilamentTiptapEditor\TiptapBlock;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;

class T_img_b_text extends TiptapBlock
{
    public string $preview = 'blocks.previews.t_img_b_text';

    public string $rendered = 'blocks.rendered.t_img_b_text';
    public string $width = 'xl';

    public ?string $label = '上圖_下文字';
    public ?string $icon = 'heroicon-o-film';

    public function getFormSchema(): array
    {
        return [
            TextInput::make('title')->required(),
            Textarea::make('contact')->required(),
            FileUpload::make('images')->required()
        ];
    }
}