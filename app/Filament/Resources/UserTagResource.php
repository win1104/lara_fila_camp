<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\UserTag;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\Member;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserTagResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserTagResource\RelationManagers;

class UserTagResource extends Resource
{
    protected static ?string $cluster = Member::class;
    protected static ?string $model = UserTag::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    // 在 Cluster 內的排序，UserCategory 是 2，所以 UserTag 設為 3
    protected static ?int $navigationSort = 3;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function getModelLabel(): string
    {
        return __('global.tag');
    }

    public static function getModelPluralLabel(): string
    {
        return __('global.tag_settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('global.tag_settings');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('backstage.title'))
                    ->required()
                    ->maxLength(255),
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
                Forms\Components\ColorPicker::make('color')
                    ->label(__('backstage.color'))
                    ->nullable(),
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
                Tables\Columns\ColorColumn::make('color')
                    ->label(__('backstage.color')),
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
                // Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListUserTags::route('/'),
            // 'create' => Pages\CreateUserTag::route('/create'),
            // 'view' => Pages\ViewUserTag::route('/{record}'),
            // 'edit' => Pages\EditUserTag::route('/{record}/edit'),
        ];
    }
}
