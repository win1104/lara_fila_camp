<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostCategoryResource\Pages;
use App\Filament\Resources\PostCategoryResource\RelationManagers;
use App\Models\PostCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostCategoryResource extends Resource
{
    protected static ?string $model = PostCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Website';

    public static function getModelLabel(): string
    {
        return __('post.c_label');
    }

    public static function getModelPluralLabel(): string
    {
        return __('post.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('post.category');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('backstage.title'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('locale')
                    ->label(__('backstage.locale'))
                    ->required()
                    ->default(fn($record) => $record?->locale ?? app()->getLocale()),
                Forms\Components\TextInput::make('slug')
                    ->label(__('backstage.slug'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('order')
                    ->label(__('backstage.order'))
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\Toggle::make('display')
                    ->label(__('backstage.published')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->where('locale', app()->getLocale()))
            ->columns([
                Tables\Columns\TextColumn::make('locale')
                    ->label(__('backstage.locale')),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('backstage.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('backstage.slug'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('order')
                    ->label(__('backstage.order'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('backstage.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListPostCategories::route('/'),
            'create' => Pages\CreatePostCategory::route('/create'),
            'edit' => Pages\EditPostCategory::route('/{record}/edit'),
        ];
    }
}
