<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Infolists;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
// use Illuminate\Support\Facades\Log;
use Filament\Resources\Pages\Page;
use Filament\Resources\Components\Tab;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Support\Facades\Request;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter;

use App\Filament\Resources\ProductResource\Pages;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;
// use App\Filament\Resources\ProductResource\RelationManagers;



class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-2-stack';
    protected static ?string $navigationLabel = '產品';
    protected static ?string $navigationGroup = 'Pruoducts';
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([

                                Forms\Components\TextInput::make('title')
                                    ->label('Title')
                                    ->required(),
                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug')
                                    ->required(),
                                Forms\Components\RichEditor::make('intro')
                                    ->label('簡介')
                                    ->required(),
                                Forms\Components\DatePicker::make('date')
                                    ->label('Published At'),
                                // Forms\Components\Textarea::make('intro')
                                //     ->label('Intro')
                                //     ->columnSpan('full')
                                //     ->visible(fn () => $this->getOwnerRecord()?->type !== 'rabbit')
                                //     ->maxLength(65535),
                            ]),

                        Forms\Components\Section::make('圖片')
                            ->schema([

                                // CuratorPicker::make('media_id')
                                //     ->label('Media')
                                //     ->multiple()
                                //     ->relationship('product', 'image')
                                //     ->orderColumn('order'),
                                CuratorPicker::make('images') // 這是你的模型關聯名稱
                                    ->label('產品圖片')
                                    ->multiple() // 啟用多選模式，這是關鍵！
                                    ->constrained(true) // 可選：限制圖片尺寸比例
                                    ->columnSpanFull() // 讓圖片欄位佔滿整行
                                    ->relationship('images', 'id') // 這是關鍵！指定關聯名稱和要儲存的 ID 欄位
                                    ->orderColumn('order'), // 可選：指定中間表中的排序欄位
                            ]),

                        Forms\Components\Section::make('庫存')
                            ->schema([
                                Forms\Components\RichEditor::make('content')
                                    ->label('說明')
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make(__('設定'))
                            ->schema([
                                Forms\Components\Toggle::make('display')
                                    ->label('上架'),
                                Forms\Components\TextInput::make('locale')
                                    ->label('語系')
                                    ->required()
                                    ->default(fn () => Request::route('locale')),
                                SelectTree::make('product_categories')
                                    ->label('產品分類')
                                    ->placeholder('Select Category')
                                    ->parentNullValue('home')
                                    ->withKey('slug')
                                    ->relationship('product_category', 'title', 'parent_slug')
                                    ->withCount()
                                    ->expandSelected(true)
                                    // ->alwaysOpen()
                                    ->multiple(true)
                                    ->searchable()
                                    ->saveRelationshipsUsing(function (Product $record, $state) {
                                        $record->product_category()->sync(
                                            collect($state)->mapWithKeys(function ($slug) use ($record) {
                                                return [$slug => ['product_slug' => $record->slug]];
                                            })
                                        );
                                    }),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),

            ])
            ->columns(3);
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
                CuratorColumn::make('images') // 這裡也是你的模型關聯名稱
                    ->size(40) // 可選：圖片寬度
                    ->circular() // 可選：顯示為圓形圖片
                    ->stacked() // 可選：多張圖片疊加顯示
                    ->limit(3) // 可選：限制只顯示前3張，然後顯示 +N
                    ->limitedRemainingText(), // 可選：顯示剩餘圖片數量
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
                SelectFilter::make('display')
                    ->label('發布狀態')
                    ->options([
                        '1' => '已發布',
                        '0' => '未發布',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value']) {
                            '1' => $query->where('display', 1),
                            '0' => $query->where('display', 0),
                            default => $query,
                        };
                    }),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Group::make()
                    ->schema([
                        Infolists\Components\Section::make()
                            ->schema([
                                Infolists\Components\TextEntry::make('locale'),
                                Infolists\Components\TextEntry::make('title'),
                                Infolists\Components\TextEntry::make('slug'),
                                Infolists\Components\TextEntry::make('date'),
                            ]),

                        Infolists\Components\Section::make(__('title'))
                            ->schema([
                                Infolists\Components\ImageEntry::make('images')
                                    ->hiddenLabel()
                                    ->circular(),
                            ])
                            ->visible(fn ($record): bool => ! empty($record->images)),
                    ])
                    ->columnSpan(['lg' => 2]),
                Infolists\Components\Group::make()
                    ->schema([
                        Infolists\Components\Section::make(__('title'))
                            ->schema([
                                Infolists\Components\TextEntry::make('display')
                            ])
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function getTabs(): array
    {
        return [
            'all' => Tab::make('全部產品')
                ->badge(Product::count()),
            'published' => Tab::make('已發布')
                ->badge(Product::where('display', 1)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('display', 1)),
            'unpublished' => Tab::make('未發布')
                ->badge(Product::where('display', 0)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('display', 0)),
            'recent' => Tab::make('最近更新')
                ->badge(Product::where('updated_at', '>=', now()->subDays(7))->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('updated_at', '>=', now()->subDays(7))),
        ];
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
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ViewProduct::class,
            Pages\EditProduct::class,
            // Pages\EditCustomerContact::class,
            // Pages\ManageCustomerAddresses::class,
            // Pages\ManageCustomerPayments::class,
        ]);
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
