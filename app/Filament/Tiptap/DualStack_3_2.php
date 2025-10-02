<?php

namespace App\Filament\Tiptap;
use FilamentTiptapEditor\TiptapBlock;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Forms\Components\FileUpload;
use Awcodes\Curator\Components\Forms\CuratorPicker;

class DualStack_3_2 extends TiptapBlock
{
    public string $preview = 'blocks.previews.dualStack_3_2';

    public string $rendered = 'blocks.rendered.dualStack_3_2';
    public string $width = 'full';

    public ?string $label = '';
    // public ?string $icon = 'icon-timg_btext';
    public ?string $icon = '/storage/blocks/dualStack_3_2.png';

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

            TiptapEditor::make('title_l1'),
            TiptapEditor::make('contact_l1'),
            CuratorPicker::make('image_l')->required(),
            TiptapEditor::make('title_l2'),
            TiptapEditor::make('contact_l2'),

            CuratorPicker::make('image_r')->required(),
            TiptapEditor::make('title_r'),
            TiptapEditor::make('contact_r'),
        ];
    }
}
