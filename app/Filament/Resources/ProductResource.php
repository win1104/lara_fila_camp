<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Illuminate\Support\Str;
use App\Models\Product as ModelsProduct;
use App\Models\ProductTag;
use Filament\Infolists;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
// use Illuminate\Support\Facades\Log;
use Filament\Resources\Pages\Page;
use Filament\Tables\Filters\Filter;
use Filament\Resources\Components\Tab;
use Filament\Navigation\NavigationItem;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Filament\Pages\SubNavigationPosition;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use FilamentTiptapEditor\TiptapEditor;
use App\Filament\Clusters\Product;
use App\Filament\Resources\ProductResource\Pages;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Awcodes\Curator\PathGenerators\DefaultPathGenerator;
// use App\Filament\Resources\ProductResource\RelationManagers;



class ProductResource extends Resource
{
    protected static ?string $cluster = Product::class;
    protected static ?string $model = ModelsProduct::class;
    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function getModelLabel(): string
    {
        return __('product.label');
    }
    public static function getModelPluralLabel(): string
    {
        return __('product.plural');
    }
    public static function getNavigationLabel(): string
    {
        return __('product.navigation');
    }

    protected static ?int $navigationSort = 1;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function getRouteKeyName(): string
    {
        return 'slug';
    }

    public static function getEloquentQuery(): Builder
    {
        $path = request()->getPathInfo();
        if (preg_match('#^/([a-z]{2})/#', $path, $matches)) {
            $locale = $matches[1];
        } else {
            $locale = app()->getLocale();
        }
        return parent::getEloquentQuery()->where('locale', $locale);
    }




    /* 全文檢索 start */
    protected static int $globalSearchResultsLimit = 10;
    public static function getGlobalSearchResultTitle($record): string
    {
        return $record->title;
    }
    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Slug' => $record->slug,
            // 移除 Category 以避免 N+1 查詢問題
        ];
    }
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->select(['id', 'title', 'slug', 'display', 'locale']) // 只選擇需要的欄位
            ->where('locale', app()->getLocale())
            ->where('display', 1) // 只搜尋已發布的內容
            ->orderBy('title'); // 加入排序提升使用者體驗
    }
    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'slug']; // 移除 content 和 intro 以提升效能
    }
    /* 全文檢索 end */


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([

                                Forms\Components\TextInput::make('title')
                                    ->label(__('backstage.title'))
                                    ->required(),
                                Forms\Components\TextInput::make('slug')
                                    ->label(__('backstage.slug'))
                                    ->required(),
                                // Forms\Components\RichEditor::make('intro')
                                //     ->label(__('backstage.intro')),
                                TiptapEditor::make('intro')
                                    ->label(__('backstage.intro')),
                                    // ->columnSpan('full'),
                                Forms\Components\DatePicker::make('date')
                                    ->label(__('backstage.published_at')),
                                // Forms\Components\Textarea::make('intro')
                                //     ->label('Intro')
                                //     ->columnSpan('full')
                                //     ->visible(fn () => $this->getOwnerRecord()?->type !== 'rabbit')
                                //     ->maxLength(65535),
                            ]),

                        Forms\Components\Section::make(__('backstage.stock'))
                            ->schema([
                                // Forms\Components\RichEditor::make('content')
                                //     ->label(__('backstage.content'))
                                //     ->required(),
                                TiptapEditor::make('content')
                                    ->label(__('backstage.content'))
                                    ->required(),
                                // ->columnSpan('full'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make(__('backstage.setting'))
                            ->schema([
                                Forms\Components\Toggle::make('display')
                                    ->label(__('backstage.published')),
                                Forms\Components\TextInput::make('locale')
                                    ->label(__('backstage.locale'))
                                    ->live() //new
                                    ->required()
                                    ->default(fn ($record) => $record?->locale ?? app()->getLocale()),
                                // SelectTree::make('product_categories')
                                // Select::make('product_categories')
                                //     ->label(__('backstage.product_category'))
                                //     ->placeholder(__('backstage.select_category'))
                                //     // ->parentNullValue('home')
                                //     // ->withKey('slug')
                                //     // ->relationship('product_category', 'title', 'parent_slug', function ($query, ?Product $record) {
                                //     //     // If editing an existing product, use its locale to filter categories.
                                //     //     if ($record?->locale) {
                                //     //         return $query->where('locale', $record->locale);
                                //     //     }

                                //     //     // When creating a new product, determine the locale from the request context.
                                //     //     $locale = app()->getLocale();
                                //     //     $routeLocale = request()->route('locale');

                                //     //     // For Livewire requests, the locale might be in the referer URL.
                                //     //     // The regex is improved to handle locales like 'zh-TW'.
                                //     //     if (!$routeLocale && request()->header('Referer')) {
                                //     //         $refererPath = parse_url(request()->header('Referer'), PHP_URL_PATH);
                                //     //         if (preg_match('#/(?P<locale>[a-z]{2}(?:-[A-Z]{2})?)/#', $refererPath, $matches)) {
                                //     //             $routeLocale = $matches['locale'];
                                //     //         }
                                //     //     }

                                //     //     $actualLocale = $routeLocale ?: $locale;
                                //     //     return $query->where('locale', $actualLocale);
                                //     // })
                                //     // ->withCount()
                                //     // ->expandSelected(true)
                                //     // // ->alwaysOpen()
                                //     // ->multiple(true)
                                //     // ->searchable()
                                //     ->multiple()
                                //     ->searchable()
                                //     ->options(function (Get $get, ?Product $record) {
                                //         // First, try to get the locale from the live form state, for when the user types manually.
                                //         $locale = $get('locale');

                                //         // If the form state is not available (e.g., on initial page load), determine the locale from the context.
                                //         if (!$locale) {
                                //             if ($record) {
                                //                 // On the EDIT page, the record's own locale is the source of truth.
                                //                 $locale = $record->locale;
                                //             } else {
                                //                 // On the CREATE page, the URL segment (`/en/` or `/tw/`) is the source of truth.
                                //                 $locale = request()->route('locale') ?? app()->getLocale();
                                //             }
                                //         }

                                //         if (!$locale) {
                                //             return []; // Cannot determine locale, so return empty options.
                                //         }

                                //         $categories = \App\Models\ProductCategory::where('locale', $locale)->get();
                                //         $grouped = $categories->groupBy('parent_slug');

                                //         $buildOptions = function ($parentSlug = 'home') use (&$buildOptions, $grouped) {
                                //             if (!$grouped->has($parentSlug)) {
                                //                 return [];
                                //             }

                                //             $options = [];
                                //             foreach ($grouped[$parentSlug] as $item) {
                                //                 $children = $buildOptions($item->slug);
                                //                 if (!empty($children)) {
                                //                     // This is a parent category, so it becomes an optgroup.
                                //                     $options[$item->title] = $children;
                                //                 } else {
                                //                     // This is a selectable child category.
                                //                     $options[$item->slug] = $item->title;
                                //                 }
                                //             }
                                //             return $options;
                                //         };

                                //         return $buildOptions();
                                //     })
                                //     ->saveRelationshipsUsing(function (Product $record, $state) {
                                //         $record->product_category()->sync(
                                //             collect($state)->mapWithKeys(function ($slug) use ($record) {
                                //                 return [$slug => ['product_slug' => $record->slug]];
                                //             })
                                //         );
                                //     }),
                                SelectTree::make('product_categories')
                                    ->label(__('backstage.product_category'))
                                    ->placeholder(__('backstage.select_category'))
                                    ->parentNullValue('home')
                                    ->withKey('slug')
                                    ->relationship('product_category', 'title', 'parent_slug', function ($query, $record) {
                                        // 編輯模式時使用記錄的語系，新增模式時使用當前語系
                                        $locale = app()->getLocale();
                                        // $locale = $record ? $record->locale : app()->getLocale();

                                        // 使用更明確的查詢方式
                                        return $query->select('product_categories.*')
                                            ->where('product_categories.locale', $locale)
                                            ->withoutGlobalScopes()
                                            ->orderBy('product_categories.order', 'asc');

                                        // return $query->where('product_categories.locale', app()->getLocale())
                                        //     ->orderBy('product_categories.order', 'asc');
                                    },function ($query, $record) {
                                        // 編輯模式時使用記錄的語系，新增模式時使用當前語系
                                        $locale = app()->getLocale();
                                        // $locale = $record ? $record->locale : app()->getLocale();

                                        // 使用更明確的查詢方式
                                        return $query->select('product_categories.*')
                                            ->where('product_categories.locale', $locale)
                                            ->withoutGlobalScopes()
                                            ->orderBy('product_categories.order', 'asc');
                                    }, )
                                    ->withCount()
                                    ->expandSelected(true)
                                    // ->alwaysOpen()
                                    ->multiple(true)
                                    ->searchable()
                                    ->saveRelationshipsUsing(function (ModelsProduct $record, $state) {
                                        $record->product_category()->sync(
                                            collect($state)->mapWithKeys(function ($slug) use ($record) {
                                                // return [$slug => ['product_slug' => $record->slug]];
                                                return [$slug => [
                                                    'product_slug' => $record->slug,
                                                    'locale' => app()->getLocale()
                                                ]];

                                            })
                                        );

                                        // // 先刪除當前語系的關聯
                                        // $record->product_category()->wherePivot('locale', $record->locale)->detach();
                                        // // 重新建立關聯
                                        // if (!empty($state)) {
                                        //     $syncData = collect($state)->mapWithKeys(function ($slug) use ($record) {
                                        //         return [$slug => [
                                        //             'product_slug' => $record->slug,
                                        //             'locale' => $record->locale
                                        //         ]];
                                        //     });
                                        //     $record->product_category()->attach($syncData->toArray());
                                        // }
                                    }),

                                    Forms\Components\Select::make('productTags')
                                        ->label(__('global.tag'))
                                        ->multiple()
                                        ->relationship('productTags', 'title')
                                        ->getOptionLabelFromRecordUsing(fn (ProductTag $record): string => $record->title)
                                        ->createOptionForm([
                                            Forms\Components\TextInput::make('title')
                                                ->label(__('global.tag'))
                                                ->required()
                                                ->maxLength(255),

                                            Forms\Components\ColorPicker::make('color')
                                                ->label(__('user.color'))
                                                ->default('#3b82f6'),
                                        ])
                                        ->createOptionUsing(function (array $data): int {
                                            $tag = ProductTag::create([
                                                'locale' => app()->getLocale(),
                                                'title' => $data['title'],
                                                'slug' => \Str::slug($data['title']) . '-' . time(),
                                                'color' => $data['color'],
                                                'creator_id' => auth()->id(),
                                                'display' => true,
                                                'order' => 1,
                                            ]);
                                            return $tag->id;
                                        })
                                        ->searchable()
                                        ->preload(),



                                // SelectTree::make('product_downloads')
                                //     ->label(__('backstage.product_download'))
                                //     ->placeholder(__('backstage.select_category'))
                                //     ->parentNullValue('home')
                                //     ->withKey('slug')
                                //     ->relationship('product_download', 'title', 'parent_slug', function ($query, ?Product $record) {
                                //         // If editing an existing product, use its locale to filter categories.
                                //         if ($record?->locale) {
                                //             return $query->where('locale', $record->locale);
                                //         }

                                //         // When creating a new product, determine the locale from the request context.
                                //         $locale = app()->getLocale();
                                //         $routeLocale = request()->route('locale');

                                //         // For Livewire requests, the locale might be in the referer URL.
                                //         // The regex is improved to handle locales like 'zh-TW'.
                                //         if (!$routeLocale && request()->header('Referer')) {
                                //             $refererPath = parse_url(request()->header('Referer'), PHP_URL_PATH);
                                //             if (preg_match('#/(?P<locale>[a-z]{2}(?:-[A-Z]{2})?)/#', $refererPath, $matches)) {
                                //                 $routeLocale = $matches['locale'];
                                //             }
                                //         }

                                //         $actualLocale = $routeLocale ?: $locale;
                                //         return $query->where('locale', $actualLocale);
                                //     })
                                //     ->withCount()
                                //     ->expandSelected(true)
                                //     // ->alwaysOpen()
                                //     ->multiple(true)
                                //     // ->searchable()
                                // Select::make('product_downloads')
                                //     ->label(__('backstage.product_download'))
                                //     ->placeholder(__('backstage.select_category'))
                                //     ->multiple()
                                //     ->searchable()
                                //     ->relationship('product_download', 'title')
                                //     ->options(function (Get $get, ?Product $record) {
                                //         // First, try to get the locale from the live form state, for when the user types manually.
                                //         $locale = $get('locale');

                                //         // If the form state is not available (e.g., on initial page load), determine the locale from the context.
                                //         if (!$locale) {
                                //             if ($record) {
                                //                 // On the EDIT page, the record's own locale is the source of truth.
                                //                 $locale = $record->locale;
                                //             } else {
                                //                 // On the CREATE page, the URL segment (`/en/` or `/tw/`) is the source of truth.
                                //                 $locale = request()->route('locale') ?? app()->getLocale();
                                //             }
                                //         }

                                //         if (!$locale) {
                                //             return []; // Cannot determine locale, so return empty options.
                                //         }

                                //         $categories = \App\Models\ProductDownload::where('locale', $locale)->get();
                                //         $grouped = $categories->groupBy('parent_slug');

                                //         $buildOptions = function ($parentSlug = 'home') use (&$buildOptions, $grouped) {
                                //             if (!$grouped->has($parentSlug)) {
                                //                 return [];
                                //             }

                                //             $options = [];
                                //             foreach ($grouped[$parentSlug] as $item) {
                                //                 $children = $buildOptions($item->slug);
                                //                 if (!empty($children)) {
                                //                     // This is a parent category, so it becomes an optgroup.
                                //                     $options[$item->title] = $children;
                                //                 } else {
                                //                     // This is a selectable child category.
                                //                     $options[$item->slug] = $item->title;
                                //                 }
                                //             }
                                //             return $options;
                                //         };

                                //         return $buildOptions();
                                //     })
                                //     ->saveRelationshipsUsing(function (Product $record, $state) {
                                //         $record->product_download()->sync(
                                //             collect($state)->mapWithKeys(function ($slug) use ($record) {
                                //                 return [$slug => ['product_slug' => $record->slug]];
                                //             })
                                //         );
                                //     })
                                //     ->dehydrated(false),
                                Forms\Components\TextInput::make('url')
                                    ->label(__('backstage.url'))
                                    ->placeholder('https://example.com')
                                    ->helperText(__('backstage.url_helper')),
                                Forms\Components\Toggle::make('url_target')
                                    ->label(__('backstage.url_target'))
                                    ->helperText(__('backstage.url_target_helper')),
                            ]),
                        Forms\Components\Section::make('圖片')
                            ->schema([

                                // CuratorPicker::make('media_id')
                                //     ->label('Media')
                                //     ->multiple()
                                //     ->relationship('product', 'image')
                                //     ->orderColumn('order'),
                                CuratorPicker::make('images') // 這是你的模型關聯名稱
                                    ->label(__('backstage.images'))
                                    ->multiple() // 啟用多選模式，這是關鍵！
                                    ->constrained(true) // 可選：限制圖片尺寸比例
                                    ->columnSpanFull() // 讓圖片欄位佔滿整行
                                    ->relationship('images', 'id') // 這是關鍵！指定關聯名稱和要儲存的 ID 欄位
                                    ->orderColumn('order')
                                    ->pathGenerator(DefaultPathGenerator::class), // 可選：指定中間表中的排序欄位
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),

            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                // 根據 URL 的語系過濾資料
                $currentLocale = app()->getLocale(); //tw
                // 只需要按語系過濾，menu_slug 已經在 getTableQuery 中處理
                $query->where('locale', $currentLocale);
            })
            ->columns([
                Tables\Columns\TextColumn::make('locale')
                    ->label(__('backstage.locale')),
                Tables\Columns\IconColumn::make('display')
                    ->label(__('backstage.published'))
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order')
                    ->label(__('backstage.order'))
                    ->sortable(),
                CuratorColumn::make('images') // 這裡也是你的模型關聯名稱
                    ->size(40) // 可選：圖片寬度
                    ->circular() // 可選：顯示為圓形圖片
                    ->stacked() // 可選：多張圖片疊加顯示
                    ->limit(3) // 可選：限制只顯示前3張，然後顯示 +N
                    ->limitedRemainingText(), // 可選：顯示剩餘圖片數量
                Tables\Columns\TextColumn::make('title')
                    ->label(__('backstage.title'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('backstage.slug'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label(__('backstage.published_at'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product_category.title')
                    ->label(__('backstage.product_category'))
                    ->getStateUsing(function ($record) {
                        $currentLocale = app()->getLocale();
                        return $record->product_category()
                            ->wherePivot('locale', $currentLocale)
                            ->where('product_categories.locale', $currentLocale)
                            ->pluck('title')
                            ->join(', ');
                    })
                    ->searchable(),
            ])
            ->reorderable('order') // 啟用拖拉排序功能
            ->defaultSort('order', 'asc') // 預設按 sort_order 排序
            ->filters([
                Filter::make(__('product.phase_out'))
                    ->query(fn (Builder $query) => $query->where('check', 1)),
                SelectFilter::make(__('backstage.status'))
                    ->options([
                        'draft' => __('backstage.draft'),
                        'reviewing' => __('backstage.reviewing'),
                        'published' => __('backstage.published'),
                    ]),
                SelectFilter::make(__('backstage.display'))
                    ->options([
                        '1' => __('backstage.display'),
                        '0' => __('backstage.undisplay'),
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
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\RestoreAction::make()
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title(__('title'))
                                ->body(__('body')),
                        ),
                    Tables\Actions\DeleteAction::make()
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title(__('title'))
                                ->body(__('body')),
                        ),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('print')
                        // ->label(__('label'))
                        ->icon('heroicon-o-printer')
                        ->form([
                            Forms\Components\TextInput::make('quantity')
                                ->label(__('form.fields.quantity'))
                                ->required()
                                ->numeric()
                                ->minValue(1)
                                ->maxValue(100),
                            Forms\Components\Radio::make('format')
                                ->label(__('form.fields.format'))
                                ->options([
                                    'dymo'       => __('form.fields.format-options.dymo'),
                                    '2x7_price'  => __('form.fields.format-options.2x7_price'),
                                    '4x7_price'  => __('form.fields.format-options.4x7_price'),
                                    '4x12'       => __('form.fields.format-options.4x12'),
                                    '4x12_price' => __('form.fields.format-options.4x12_price'),
                                ])
                                ->default('2x7_price')
                                ->required(),
                        ])
                        ->action(function (array $data, $records) {
                            // $pdf = PDF::loadView('products::filament.resources.products.actions.print', [
                            //     'records'  => $records,
                            //     'quantity' => $data['quantity'],
                            //     'format'   => $data['format'],
                            // ]);

                            // $paperSize = match ($data['format']) {
                            //     'dymo'  => [0, 0, 252.2, 144],
                            //     default => 'a4',
                            // };

                            // $pdf->setPaper($paperSize, 'portrait');

                            // return response()->streamDownload(function () use ($pdf) {
                            //     echo $pdf->output();
                            // }, 'Product-Barcode.pdf');
                            return null;
                        }),
                    Tables\Actions\RestoreBulkAction::make()
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title(__('notification.title'))
                                ->body(__('notification.body')),
                        ),
                    Tables\Actions\DeleteBulkAction::make()
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title(__('notification.title'))
                                ->body(__('notification.body')),
                        ),
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
        $record = $page->getRecord();

        // return $page->generateNavigationItems([
        //     Pages\ViewProduct::class,
        //     Pages\EditProduct::class,
        // ]);

        return [
            NavigationItem::make(Pages\ViewProduct::getNavigationLabel())
                ->icon('heroicon-o-eye')
                ->url(Pages\ViewProduct::getUrl(['record' => $record]))
                ->isActiveWhen(fn () => $page instanceof Pages\ViewProduct),

            NavigationItem::make(Pages\EditProduct::getNavigationLabel())
                ->icon('heroicon-o-pencil-square')
                ->url(Pages\EditProduct::getUrl(['record' => $record]))
                ->isActiveWhen(fn () => $page instanceof Pages\EditProduct),

            NavigationItem::make('Product Options')
                ->icon('heroicon-o-rectangle-stack')
                ->url(ProductOptionResource::getUrl('index', ['record' => $record]))
                ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.product-options.*')),
        ];
    }

}
