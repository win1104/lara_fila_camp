<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Wizard\Step;

class CreatePost extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;
    protected static string $resource = PostResource::class;


    protected function getSteps(): array
    {
        return [
            Step::make('Name')
                ->description('Give the category a clear and unique name')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                    TextInput::make('slug')
                        ->disabled()
                        ->required()
                        ->unique(Category::class, 'slug', fn ($record) => $record),
                ]),
            Step::make('Description')
                ->description('Add some extra details')
                ->schema([
                    MarkdownEditor::make('description')
                        ->columnSpan('full'),
                ]),
            Step::make('Visibility')
                ->description('Control who can view it')
                ->schema([
                    Toggle::make('is_visible')
                        ->label('Visible to customers.')
                        ->default(true),
                ]),
        ];
    }
}
