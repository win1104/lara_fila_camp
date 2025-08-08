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

    public ?string $label = '';
    public ?string $icon = '/icon-timg_btext.svg';

    public function getFormSchema(): array
    {
        return [
            TextInput::make('title')->required(),
            Textarea::make('contact')->required(),
            FileUpload::make('images')->required()
        ];
    }
}
