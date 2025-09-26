<?php

namespace App\Filament\Tiptap;
use FilamentTiptapEditor\TiptapBlock;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use FilamentTiptapEditor\TiptapEditor;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Components\FileUpload;

class Flip_split_b extends TiptapBlock
{
    public string $preview = 'blocks.previews.flip_split_b';

    public string $rendered = 'blocks.rendered.flip_split_b';
    public string $width = 'full';

    public ?string $label = '';
    // public ?string $icon = 'icon-timg_btext';
    public ?string $icon = '/storage/blocks/flip_split_b.png';

    public function getFormSchema(): array
    {
        return [
           TextInput::make('bg_color')
            ->label('背景顏色')
            ->placeholder('#ffffff') // 或者 rgba(0,0,0,0.5)
            ->regex('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/') // 簡單驗證
            ->helperText('輸入 HEX 色碼，例如 #ffffff1'),

            CuratorPicker::make('bg_image')
                ->label('背景圖片')
                ->directory(''),
                // ->imageEditor(),

            TiptapEditor::make('title_l'),

            TiptapEditor::make('contact_l'),
            CuratorPicker::make('image_l')
                ->label('左邊圖片')
                ->directory(''),
            CuratorPicker::make('image_r')
                ->label('右邊圖片')
                ->directory(''),
            TiptapEditor::make('title_r'),
            TiptapEditor::make('contact_r'),
        ];
    }
}
