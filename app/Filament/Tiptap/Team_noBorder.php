<?php

namespace App\Filament\Tiptap;
use FilamentTiptapEditor\TiptapBlock;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class Team_noBorder extends TiptapBlock
{
    public string $preview = 'blocks.previews.team_noborder';

    public string $rendered = 'blocks.rendered.team_noborder';

    public ?string $label = '';

    public ?string $icon = 'icon-team_noborder';

    public function getFormSchema(): array
    {
        return [
            Repeater::make('teams')
                ->schema([
                    FileUpload::make('image')
                        ->required()
                        ->label('成員圖片'),
                    TextInput::make('title')
                        ->label('成員名稱')
                        ->required(),
                    TextInput::make('subtitle')
                        ->label('成員職稱'),
                    Textarea::make('contact')
                        ->label('成員介紹'),
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
