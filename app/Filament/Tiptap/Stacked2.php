<?php

namespace App\Filament\Tiptap;
use FilamentTiptapEditor\TiptapBlock;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Forms\Components\FileUpload;
use Awcodes\Curator\Components\Forms\CuratorPicker;

class Stacked2 extends TiptapBlock
{
    public string $preview = 'blocks.previews.stacked2';

    public string $rendered = 'blocks.rendered.stacked2';
    public string $width = 'full';

    public ?string $label = '';
    // public ?string $icon = 'icon-timg_btext';
    public ?string $icon = '/storage/blocks/stacked2.png';

    public function getFormSchema(): array
    {
        return [
           TextInput::make('bg_color')
            ->label('背景顏色')
            ->placeholder('#ffffff') // 或者 rgba(0,0,0,0.5)
            ->regex('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/') // 簡單驗證
            ->helperText('輸入 HEX 色碼，例如 #ffffff'),

            CuratorPicker::make('bg_image')
                ->label('背景圖片')
                ->directory('backgrounds'),

            CuratorPicker::make('image_l')->required(),
            TiptapEditor::make('title_l'),
            TiptapEditor::make('contact_l'),

            CuratorPicker::make('image_r')->required(),
            TiptapEditor::make('title_r'),
            TiptapEditor::make('contact_r'),

        ];
    }
}
