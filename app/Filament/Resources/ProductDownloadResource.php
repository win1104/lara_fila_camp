<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductDownloadResource\Pages;
use App\Models\ProductDownload;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductDownloadResource extends Resource
{
    protected static ?string $model = ProductDownload::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    public static function getModelLabel(): string
    {
        return __('product.download');
    }
    public static function getModelPluralLabel(): string
    {
        return __('product.download');
    }
    public static function getNavigationLabel(): string
    {
        return __('product.download');
    }
    protected static ?string $navigationGroup = 'Products';

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
                    ->default(fn ($record) => $record?->locale ?? app()->getLocale()),
                Forms\Components\TextInput::make('slug')
                    ->label(__('backstage.slug'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('parent_slug')
                    ->label(__('backstage.parent_slug'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('order')
                    ->label(__('backstage.order'))
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('display')
                    ->label(__('backstage.published')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->where('locale', app()->getLocale()))
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('backstage.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('locale')
                    ->label(__('backstage.locale')),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('backstage.slug'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent_slug')
                    ->label(__('backstage.parent_slug'))
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
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('backstage.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                // Tables\Actions\EditAction::make()
                //     ->url(fn (ProductDownload $record): string => route('filament.admin.resources.product-downloads.edit', ['record' => $record->slug])),
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
            'index' => Pages\ListProductDownloads::route('/'),
            'create' => Pages\CreateProductDownload::route('/create'),
            'edit' => Pages\EditProductDownload::route('/{record}/edit'),
        ];
    }

    public static function getRouteKeyName(): string
    {
        return 'slug';
    }

    public static function resolveRecordRouteBinding($key): ?\Illuminate\Database\Eloquent\Model
    {
        $locale = app()->getLocale();

        return static::getModel()::where('slug', $key)
            ->where('locale', $locale)
            ->first();
    }

    public static function getRecordRouteKeyName(): string
    {
        return 'slug';
    }
}
