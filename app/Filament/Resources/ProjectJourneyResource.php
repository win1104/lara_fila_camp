<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectJourneyResource\Pages;
use App\Filament\Resources\ProjectJourneyResource\RelationManagers;
use App\Models\ProjectJourney;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectJourneyResource extends Resource
{
    protected static ?string $model = ProjectJourney::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $pluralLabel = '每日行程'; // 這將用於標題和側邊欄
    protected static ?string $label = '每日行程'; // 這將用於單數形式

    // protected static ?string $navigationParentItem = '專案管理';
    protected static ?string $navigationGroup = 'Project';


    /*
    public static function form(Form \$form): Form
    {
        return \$form
            ->schema([
                Forms\Components\TextInput::make('locale')
                    ->required()
                    ->default(fn () => app()->getLocale()),
                Forms\Components\Select::make('project_menu_slug')
                    ->label('Project Menu')
                    ->options(fn () => App\Models\ProjectMenu::where('locale', app()->getLocale())
                        ->pluck('title', 'slug'))
                    ->required()
                    ->searchable(),
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required(),
                Forms\Components\RichEditor::make('content')
                    ->label('Content')
                    ->required(),
                Forms\Components\Toggle::make('display')
                    ->label('Published'),
                Forms\Components\DatePicker::make('date')
                    ->label('Published At'),
                Forms\Components\Textarea::make('intro')
                    ->label('Intro')
                    ->columnSpan('full')
                    ->maxLength(65535),
            ]);
    }
    */

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('locale'),
                Tables\Columns\IconColumn::make('display')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order')
                    ->label('Order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Published At')
                    ->date()
                    ->sortable(),
            ])
            ->reorderable('order')
            ->defaultSort('order')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectJourneys::route('/'),
            'create' => Pages\CreateProjectJourney::route('/create'),
            'view' => Pages\ViewProjectJourney::route('/{record}'),
            'edit' => Pages\EditProjectJourney::route('/{record}/edit'),
        ];
    }
}
