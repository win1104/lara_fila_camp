<?php

namespace App\Filament\Tiptap;
use FilamentTiptapEditor\TiptapBlock;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Forms\Components\FileUpload;

class Three_flip extends TiptapBlock
{
    public string $preview = 'blocks.previews.three_flip';

    public string $rendered = 'blocks.rendered.three_flip';
    public string $width = 'xl';

    public ?string $label = '';
    public ?string $icon = 'icon-timg_btext';

    public function getFormSchema(): array
    {
        return [
           TextInput::make('bg_color')
            ->label('背景顏色')
            ->placeholder('#ffffff') // 或者 rgba(0,0,0,0.5)
            ->regex('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/') // 簡單驗證
            ->helperText('輸入 HEX 色碼，例如 #ffffff'),

            FileUpload::make('bg_image')
                ->label('背景圖片')
                ->directory('backgrounds'),

            TiptapEditor::make('title_l'),
            TiptapEditor::make('contact_l'),
            FileUpload::make('image_l')->required(),

            FileUpload::make('image_c')->required(),
            TiptapEditor::make('title_c'),
            TiptapEditor::make('contact_c'),

            TiptapEditor::make('title_r'),
            TiptapEditor::make('contact_r'),
            FileUpload::make('image_r')->required(),

        ];
    }
}
