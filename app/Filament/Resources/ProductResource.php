<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ProductCategory;
use Filament\Resources\Resource;
// use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;



class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-2-stack';
    protected static ?string $navigationLabel = '產品';
    protected static ?string $navigationGroup = 'Pruoducts';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('locale')
                    ->required()
                    ->default(fn () => app()->getLocale()),
                SelectTree::make('product_categories')
                    ->label('產品分類')
                    ->withCount()
                    ->searchable()
                    ->alwaysOpen()
                    ->multiple() // 開啟多選
                    ->parentNullValue('home')
                    ->placeholder('Select Category')
                    ->withKey('slug')
                    // ->relationship(relationship: 'product_category', titleAttribute: 'title', parentAttribute: 'parent_slug', modifyChildQueryUsing: fn($query) => $query),
                    // ->relationship(relationship: 'product_category', titleAttribute: 'title', parentAttribute: 'parent_id', modifyChildQueryUsing: fn($query) => $query));
                    // ->relationship('category', 'name', 'parent_id'),
                    ->relationship('product_category', 'title', 'parent_slug'),
                    // ->relationship('product_category', 'title', 'parent_id'),
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
                // Forms\Components\Textarea::make('intro')
                //     ->label('Intro')
                //     ->columnSpan('full')
                //     ->visible(fn () => $this->getOwnerRecord()?->type !== 'rabbit')
                //     ->maxLength(65535),
            ]);
    }

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
                Tables\Columns\TextColumn::make('category_id')
                    ->searchable(),
            ])
            ->reorderable('order') // 啟用拖拉排序功能
            ->defaultSort('order') // 預設按 sort_order 排序
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    // public static function afterCreate(Form $form, $record): void
    // {
    //     $newId = $record->id;

    //     Log::info('新增產品', ['user_id' => auth()->id(), 'post_id' => $newId]); // 現在 $newId 包含了剛建立的記錄的 ID
    //     // Log::error('發生錯誤：' . $e->getMessage(), ['exception' => $e]);
    //     // Log::emergency('系統崩潰', ['exception' => $e]);
    //     // Log::warning('密碼嘗試次數過多', ['ip_address' => $request->ip()]);
    //     // Log::debug('變數值：' . $variable);
    // }

    // public static function afterSave(Form $form, $record): void
    // {
    //     if ($record->wasRecentlyCreated) {
    //         $logMessage = static::getModelLabel() . " 已建立，ID： " . $record->id;
    //         $logType = '建立';
    //     } else {
    //         $logMessage = static::getModelLabel() . " 已更新，ID： " . $record->id;
    //         $logType = '更新';
    //     }

    //     Log::info($logType . 'info紀錄', [
    //         'model' => static::getModelLabel(),
    //         'id' => $record->id,
    //         'data' => $record->toArray(),
    //     ]);
    //     Log::debug($logType . 'debug紀錄', [
    //         'model' => static::getModelLabel(),
    //         'id' => $record->id,
    //         'data' => $record->toArray(),
    //     ]);
    // }
}
