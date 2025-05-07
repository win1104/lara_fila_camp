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

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = '產品';
    protected static ?string $navigationGroup = 'Pruoducts';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

            SelectTree::make('category_id')
                ->label('Category')
                ->withCount()
                ->searchable()
                ->alwaysOpen()
                // ->multiple() // 開啟多選
                ->parentNullValue(-1)
                ->placeholder('Select Category')
                ->relationship('product_category', 'title', 'parent_id'),
                // ->relationship(relationship: 'product_category', titleAttribute: 'title', parentAttribute: 'parent_id', modifyChildQueryUsing: fn($query) => $query));
                // ->relationship('category', 'name', 'parent_id'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category_id')
                    ->searchable(),
            ])
            ->reorderable('name') // 啟用拖拉排序功能
            ->defaultSort('name') // 預設按 sort_order 排序
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
