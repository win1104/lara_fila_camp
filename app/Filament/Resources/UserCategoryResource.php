<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserCategoryResource\Pages;
use App\Filament\Resources\UserCategoryResource\RelationManagers;
use App\Models\UserCategory;
use App\Filament\Clusters\Member;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserCategoryResource extends Resource
{
    // 指定這個 Resource 屬於 Blog Cluster
    protected static ?string $cluster = Member::class;
    protected static ?string $model = UserCategory::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // 在 Cluster 內的排序
    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('user.category_label');
    }

    public static function getModelPluralLabel(): string
    {
        return __('user.category_plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('user.category');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('backstage.title'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('locale')
                    ->label(__('backstage.locale'))
                    ->required()
                    ->default(fn($record) => $record?->locale ?? app()->getLocale()),
                Forms\Components\TextInput::make('slug')
                    ->label(__('backstage.slug'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('order')
                    ->label(__('backstage.order'))
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\Toggle::make('display')
                    ->label(__('backstage.published'))
                    ->default(true),
                Forms\Components\Textarea::make('note')
                    ->label(__('backstage.note'))
                    ->rows(3)
                    ->maxLength(500),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->where('locale', app()->getLocale()))
            ->columns([
                Tables\Columns\TextColumn::make('locale')
                    ->label(__('backstage.locale')),
                Tables\Columns\TextColumn::make('order')
                    ->label(__('backstage.order'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('backstage.title'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('backstage.slug'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('display')
                    ->label(__('backstage.published')),
                Tables\Columns\TextColumn::make('users_count')
                    ->label(__('user.users_count'))
                    ->counts('users')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('backstage.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->reorderable('order') // 啟用拖拉排序功能
            ->defaultSort('order', 'asc') // 預設按 order 排序
            ->filters([
                Tables\Filters\TernaryFilter::make('display')
                    ->label(__('backstage.published'))
                    ->boolean()
                    ->trueLabel(__('backstage.published'))
                    ->falseLabel(__('backstage.unpublished'))
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUserCategories::route('/'),
            // 'create' => Pages\CreateUserCategory::route('/create'),
            'view' => Pages\ViewUserCategory::route('/{record}'),
            // 'edit' => Pages\EditUserCategory::route('/{record}/edit'),
        ];
    }
}
