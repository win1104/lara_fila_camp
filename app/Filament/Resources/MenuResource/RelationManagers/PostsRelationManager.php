<?php

namespace App\Filament\Resources\MenuResource\RelationManagers;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Log;
use Filament\Resources\Components\Tab;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PostResource\Pages;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Filament\Resources\RelationManagers\RelationManager;
use App\Models\PostCategory;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    protected bool $isUrlType = false;

    public function mount(): void
    {
        $menu = $this->getOwnerRecord();
        if ($menu->type === 'url') {
            $this->isUrlType = true;
        }



        //     redirect('http://127.0.0.1:8000/tw/admin/products')->send();
        //     exit; // 防止後續執行
        // dd($this->getSource());
        // $this->loadDefaultActiveTab();
    }

    // 覆寫基礎查詢，避免 Menu 模型中的語系過濾
    protected function getTableQuery(): Builder
    {
        $menu = $this->getOwnerRecord();

        // 直接查詢 Post 模型，不通過 Menu 關聯
        return Post::query()->where('menu_slug', $menu->slug);
    }

    // protected static string $view = 'filament.relation-managers.posts-relation-manager';

    // public ?string $activeTab = 'all'; // 預設值

    // protected static ?string $recordTitleAttribute = 'title';

    // public function setActiveTab($tabKey)
    // {
    //     $this->activeTab = $tabKey;
    // }

    protected function getSource(): string
    {
        $url = url()->previous();

        // Log::info('PostsRelationManager URL:', ['url' => $url]);

        if (str_contains($url, 'widget')) {
            return 'widget';
        }

        return 'table';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $menu = $this->getOwnerRecord();
        $currentLocale = app()->getLocale();
        $data['menu_slug'] = $menu->slug;
        $data['locale'] = $currentLocale;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $menu = $this->getOwnerRecord();
        $currentLocale = app()->getLocale();
        $data['menu_slug'] = $menu->slug;
        $data['locale'] = $currentLocale;

        return $data;
    }

    public function form(Form $form): Form
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
                                //     // ->visible(fn () => $this->getOwnerRecord()?->type !== 'rabbit')
                                //     ->label(__('backstage.intro')),
                                TiptapEditor::make('intro')
                                    ->label(__('backstage.intro'))
                                    ->columnSpan('full'),
                            ]),
                        Forms\Components\Section::make(__('backstage.content'))
                            ->schema([
                                TiptapEditor::make('content')
                                    ->label(__('backstage.content'))
                                    ->columnSpan('full'),
                                // Forms\Components\RichEditor::make('content')
                                //     ->label(__('backstage.content'))
                                //     ->columnSpan('full'),
                                    // ->toolbarButtons([
                                    //     'blockquote',
                                    //     'bold',
                                    //     'bulletList',
                                    //     'codeBlock',
                                    //     'h2',
                                    //     'h3',
                                    //     'italic',
                                    //     'link',
                                    //     'orderedList',
                                    //     'redo',
                                    //     'strike',
                                    //     'undo',
                                    //     'html', // 啟用 HTML 編輯按鈕
                                    // ]),
                            ]),
                    ])
                    ->columnSpan(['lg' => 3]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make(__('backstage.setting'))
                            ->schema([
                                Forms\Components\Toggle::make('display')
                                    ->label(__('backstage.published')),
                                Forms\Components\Hidden::make('locale')
                                    ->label(__('backstage.locale'))
                                    ->required()
                                    ->default(fn ($record) => $record?->locale ?? app()->getLocale()),
                                Forms\Components\DatePicker::make('date')
                                    ->label(__('backstage.published_at')),
                                Forms\Components\Select::make('post_categories')
                                    ->label(__('backstage.category'))
                                    ->relationship('post_category_for_filament', 'title',fn (Builder $query) => $query->where('post_categories.locale', app()->getLocale()))
                                    ->multiple()
                                    ->preload()
                                    ->searchable()
                                    ->saveRelationshipsUsing(function (Post $record, $state) {
                                        $currentLocale = app()->getLocale();
                                        $record->post_category()->sync(
                                            collect($state)->mapWithKeys(function ($slug) use ($record, $currentLocale) {
                                                return [$slug => [
                                                    'post_slug' => $record->slug,
                                                    'locale' => $currentLocale
                                                ]];
                                            })
                                        );
                                    }),
                                // SelectTree::make('product_categories')
                                //     ->label(__('backstage.product_category'))
                                //     ->placeholder(__('backstage.select_category'))
                                //     ->parentNullValue('home')
                                //     ->withKey('slug')
                                //     ->relationship('product_category', 'title', 'parent_slug', function ($query, $record) {
                                //         return $query->where('locale', $record?->locale ?? app()->getLocale());
                                //     })
                                //     ->withCount()
                                //     ->expandSelected(true)
                                //     // ->alwaysOpen()
                                //     ->multiple(true)
                                //     ->searchable()
                                //     ->saveRelationshipsUsing(function (Product $record, $state) {
                                //         $record->product_category()->sync(
                                //             collect($state)->mapWithKeys(function ($slug) use ($record) {
                                //                 return [$slug => ['product_slug' => $record->slug]];
                                //             })
                                //         );
                                //     }),
                                Forms\Components\TextInput::make('url')
                                    ->label(__('backstage.url'))
                                    ->placeholder('https://example.com')
                                    ->helperText(__('backstage.url_helper')),
                                Forms\Components\Toggle::make('url_target')
                                    ->label(__('backstage.url_target'))
                                    ->helperText(__('backstage.url_target_helper')),
                            ]),
                        Forms\Components\Section::make()
                            ->schema([
                                CuratorPicker::make('images') // 這是你的模型關聯名稱
                                    ->label(__('backstage.images'))
                                    ->multiple() // 啟用多選模式，這是關鍵！
                                    ->constrained(true) // 可選：限制圖片尺寸比例
                                    ->columnSpanFull() // 讓圖片欄位佔滿整行
                                    ->relationship('images', 'id') // 這是關鍵！指定關聯名稱和要儲存的 ID 欄位
                                    ->orderColumn('order')
                                    ->buttonLabel('Closure')
                                    ->pathGenerator(CustomPathGenerator::class), // 可選：指定中間表中的排序欄位
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(4);
    }

    public function table(Table $table): Table
    {
        /* 如果 menu 的 type 為 url 表示不會有資料，因此不需顯示 */
        if ($this->isUrlType) {
            // 回傳一個空白 view
            return $table->view('filament.pages.blank');
        }


        $menu = $this->getOwnerRecord();
        $shouldShowCreateAction = $menu->type !== 'posts';

        return $table
            // ->heading('病患資料')
            ->recordTitleAttribute('title')
            ->modifyQueryUsing(function (Builder $query) use ($menu) {
                // 根據 URL 的語系過濾資料
                $currentLocale = app()->getLocale();
                // 只需要按語系過濾，menu_slug 已經在 getTableQuery 中處理
                $query->where('locale', $currentLocale);
            })
            ->columns([
                // CuratorColumn::make('media_id')
                //     ->label('Media')
                //     ->size('40'),

                Tables\Columns\TextColumn::make('locale'),
                Tables\Columns\IconColumn::make('display')
                    ->label('上架')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order')
                    ->label('Order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('post_category_titles')
                    ->label(__('post.category'))
                    ->getStateUsing(function ($record) {
                        $currentLocale = app()->getLocale();
                        return $record->post_category()
                            ->wherePivot('locale', $currentLocale)
                            ->where('post_categories.locale', $currentLocale)
                            ->pluck('title')
                            ->join(', ');
                    })
                    ->searchable(false),



                // CuratorColumn::make('images') // 這裡也是你的模型關聯名稱
                //     ->size(40) // 可選：圖片寬度
                //     ->circular() // 可選：顯示為圓形圖片
                //     ->stacked() // 可選：多張圖片疊加顯示
                //     ->limit(3) // 可選：限制只顯示前3張，然後顯示 +N
                //     ->limitedRemainingText(), // 可選：顯示剩餘圖片數量
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
            ])
            ->reorderable('order') // 啟用拖拉排序功能
            ->defaultSort('order') // 預設按 sort_order 排序
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->visible($shouldShowCreateAction)
                    ->closeModalByClickingAway(false)
                    ->modalWidth('7xl'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->closeModalByClickingAway(false)
                    ->modalWidth('8xl'),
                /* 另開新獨立頁面 */
                // Tables\Actions\EditAction::make()
                //     ->url(fn (Post $record): string => route('filament.admin.resources.posts.edit', [
                //         'locale' => app()->getLocale(),
                //         'record' => $record->slug
                //     ])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function getHeaderActions(): array
    {
        return [
            // 將 tabs 作為 header actions
            Action::make('tabs')
                // ->view('filament.components.custom-tabs')
                ->extraAttributes(['class' => 'w-full']),
        ];

        // return $this->table(new \Filament\Tables\Table($this))->getHeaderActions();
    }


    // public static function getTabs(): array
    public function getTabs(): array
    {
        /* 如果 menu 的 type 為 url 表示不會有資料，因此不需顯示 */
        if ($this->isUrlType) {
            return array();
        }



        $ownerRecord = $this->getOwnerRecord();
        $currentLocale = app()->getLocale();

        // 直接查詢 Post 模型，不通過 Menu 關聯
        $baseQuery = Post::where('menu_slug', $ownerRecord->slug);

        // 基於用戶權限的 Tab
        $tabs = [
            'all' => Tab::make('全部文章')
                ->badge($baseQuery->where('locale', $currentLocale)->count())
                ->icon('heroicon-o-document-duplicate'),
            'published' => Tab::make('已發布')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('display', 1)->where('locale', $currentLocale))
                ->badge($baseQuery->where('display', 1)->where('locale', $currentLocale)->count())
                ->badgeColor('success')
                ->icon('heroicon-o-check-circle'),
            'unpublished' => Tab::make('未發布')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('display', 0)->where('locale', $currentLocale))
                ->badge($baseQuery->where('display', 0)->where('locale', $currentLocale)->count())
                ->badgeColor('gray')
                ->icon('heroicon-o-x-circle'),
        ];

        // if (auth()->user()->can('view_draft_posts')) {
        //     $tabs['recent'] = Tab::make('最近更新')
        //         ->modifyQueryUsing(fn (Builder $query) => $query->where('updated_at', '>=', now()->subDays(7)))
        //         ->badge(Post::where('updated_at', '>=', now()->subDays(7))->count())
        //         ->badgeColor('warning');
        // }

        // if (auth()->user()->can('view_archived_posts')) {
        //     $tabs['this_month'] = Tab::make('本月發布')
        //         ->modifyQueryUsing(fn (Builder $query) => $query->whereMonth('created_at', now()->month))
        //         ->badge(Post::whereMonth('created_at', now()->month)->count())
        //         ->badgeColor('warning');
        // }

        return $tabs;
    }

    // 提供給視圖使用的資料
    protected function getViewData(): array
    {
        return [
            'tabs' => $this->getTabs(),
            'activeTab' => $this->activeTab,
            'relationship' => static::$relationship,
            'ownerRecord' => $this->getOwnerRecord(),
        ];
    }

    // 取得當前 tab 的計數
    public function getCurrentTabCount(): int
    {
        $ownerRecord = $this->getOwnerRecord();
        $currentLocale = app()->getLocale();

        // 直接查詢 Post 模型，不通過 Menu 關聯
        $baseQuery = Post::where('menu_slug', $ownerRecord->slug);

        switch ($this->activeTab) {
            case 'published':
                return $baseQuery->where('display', '1')->where('locale', $currentLocale)->count();
            case 'unpublished':
                return $baseQuery->where('display', '0')->where('locale', $currentLocale)->count();
            // case 'scheduled':
            //     return $baseQuery->where('status', 'scheduled')->count();
            // case 'archived':
            //     return $baseQuery->where('status', 'archived')->count();
            default:
                return $baseQuery->where('locale', $currentLocale)->count();
        }
    }
}
