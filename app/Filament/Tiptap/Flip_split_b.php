<?php

namespace App\Filament\Tiptap;
use FilamentTiptapEditor\TiptapBlock;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Forms\Components\FileUpload;

class Flip_split_b extends TiptapBlock
{
    public string $preview = 'blocks.previews.flip_split_b';

    public string $rendered = 'blocks.rendered.flip_split_b';
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

            TiptapEditor::make('title_l')
                ->tools([
                    'heading',
                    'bold',
                    'italic',
                    'highlight',
                    'color',
                    'link',
                    'bullet-list',
                    'ordered-list',
                    'align-center',
                    'align-justify',
                    'align-left',
                    'align-right',
                ]),

            TiptapEditor::make('contact_l'),
            FileUpload::make('image_l')->required(),

            FileUpload::make('image_r')->required(),
            TiptapEditor::make('title_r'),
            TiptapEditor::make('contact_r'),
        ];
    }
}
