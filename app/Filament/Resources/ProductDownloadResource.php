<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ProductDownload;
use Filament\Resources\Resource;
use App\Filament\Clusters\Product;
use Filament\Pages\SubNavigationPosition;
use App\Filament\Resources\ProductDownloadResource\Pages;


class ProductDownloadResource extends Resource
{
    protected static ?string $cluster = Product::class;
    protected static ?string $model = ProductDownload::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-on-square';

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
        return __('product.download_navigation');
    }

    protected static ?int $navigationSort = 4;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

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
                Forms\Components\Select::make('products')
                    ->label(__('backstage.product'))
                    ->placeholder(__('backstage.select_product'))
                    // ->options(fn () => ProductCategory::getProductTree(app()->getLocale()))
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->relationship(
                        name: 'products',
                        titleAttribute: 'title',
                        modifyQueryUsing: function ($query) {
                            $locale = app()->getLocale();
                            $routeLocale = request()->route('locale');

                            if (!$routeLocale && request()->header('Referer')) {
                                $refererPath = parse_url(request()->header('Referer'), PHP_URL_PATH);
                                if (preg_match('/^\/([a-z]{2})\//', $refererPath, $matches)) {
                                    $routeLocale = $matches[1];
                                }
                            }

                            $actualLocale = $routeLocale ?: $locale;
                            return $query->where('products.locale', $actualLocale);
                        }
                    ),
                // SelectTree::make('products')
                //     ->label(__('backstage.product'))
                //     ->placeholder(__('backstage.select_product'))
                //     ->parentNullValue('home')
                //     ->withKey('slug')
                //     ->relationship('products', 'title', 'slug', function ($query, $record) {
                //         // 取得當前語系
                //         $locale = app()->getLocale();
                //         $routeLocale = request()->route('locale');

                //         // 如果是 Livewire 請求，從 referer 中提取語言
                //         if (!$routeLocale && request()->header('Referer')) {
                //             $refererPath = parse_url(request()->header('Referer'), PHP_URL_PATH);
                //             if (preg_match('/^\/([a-z]{2})\//', $refererPath, $matches)) {
                //                 $routeLocale = $matches[1];
                //             }
                //         }

                //         $actualLocale = $routeLocale ?: $locale;
                //         return $query->where('locale', $actualLocale);
                //     })
                //     ->withCount()
                //     ->expandSelected(true)
                //     ->multiple(true)
                //     ->searchable()
                //     ->saveRelationshipsUsing(function (Products $record, $state) {
                //         $record->products()->sync(
                //             collect($state)->mapWithKeys(function ($slug) use ($record) {
                //                 return [$slug => ['product_slug' => $record->slug]];
                //             })
                //         );
                //     }),

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
