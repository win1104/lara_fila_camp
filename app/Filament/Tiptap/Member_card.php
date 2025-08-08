<?php

namespace App\Filament\Tiptap;
use FilamentTiptapEditor\TiptapBlock;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class Member_card extends TiptapBlock
{
    public string $preview = 'blocks.previews.member_card';

    public string $rendered = 'blocks.rendered.member_card';

    public ?string $label = '';

    public ?string $icon = '/icon-member_card.svg';

    public function getFormSchema(): array
    {
        return [
            Repeater::make('cards')
                ->schema([
                    FileUpload::make('image')
                        ->required()
                        ->label('成員圖片'),
                    TextInput::make('title')
                        ->label('成員名稱')
                        ->required(),
                    Textarea::make('contact')
                        ->label('成員介紹')
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
