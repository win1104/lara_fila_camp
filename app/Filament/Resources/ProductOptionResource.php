<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductOptionResource\Pages;
use App\Filament\Resources\ProductResource;
use App\Models\ProductOption;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Navigation\NavigationItem;
// use Filament\Forms\Components\Hidden;


class ProductOptionResource extends Resource
{
    protected static ?string $model = ProductOption::class;
    protected static bool $shouldRegisterNavigation = false;
    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationIcon = 'heroicon-o-square-2-stack';
    protected static ?string $navigationGroup = 'Pruoducts';
    protected static ?string $navigationLabel = '產品';
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('type')
                    ->maxLength(255),
                Forms\Components\TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\Toggle::make('display')
                    ->required(),
                Forms\Components\TextInput::make('date')
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('admin_id'),
                Forms\Components\Hidden::make('product_slug'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('display')
                    ->boolean(),
                Tables\Columns\TextColumn::make('date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('admin.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['admin_id'] = auth()->id();
                        return $data;
                    }),
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
            'index' => Pages\ListProductOptions::route('/'),
            // 'create' => Pages\CreateProductOption::route('/create'),
            // 'edit' => Pages\EditProductOption::route('/{record}/edit'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        /** @var ProductOption $record */
        $option = $page->getRecord();
        $product = $option->product;

        if (! $product) {
            return [];
        }

        return [
            NavigationItem::make(ProductResource\Pages\ViewProduct::getNavigationLabel())
                ->icon('heroicon-o-eye')
                ->url(ProductResource\Pages\ViewProduct::getUrl(['record' => $product]))
                ->isActiveWhen(fn () => false),

            NavigationItem::make(ProductResource\Pages\EditProduct::getNavigationLabel())
                ->icon('heroicon-o-pencil-square')
                ->url(ProductResource\Pages\EditProduct::getUrl(['record' => $product]))
                ->isActiveWhen(fn () => false),

            NavigationItem::make('Product Options')
                ->icon('heroicon-o-rectangle-stack')
                ->url(self::getUrl('index', ['record' => $product]))
                ->isActiveWhen(fn () => true),
        ];
    }
}

