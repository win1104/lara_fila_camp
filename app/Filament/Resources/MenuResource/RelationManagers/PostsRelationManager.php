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
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Filament\Resources\RelationManagers\RelationManager;

class PostsRelationManager extends RelationManager
{


    protected static string $relationship = 'posts';

    // protected static string $view = 'filament.relation-managers.posts-relation-manager';

    // public ?string $activeTab = 'all'; // 預設值

    // protected static ?string $recordTitleAttribute = 'title';

    // public function setActiveTab($tabKey)
    // {
    //     $this->activeTab = $tabKey;
    // }

    public function mount(): void
    {
        // dd($this->getSource());
        // $this->loadDefaultActiveTab();
    }

    protected function getSource(): string
    {
        $url = url()->previous();

        Log::info('PostsRelationManager URL:', ['url' => $url]);

        if (str_contains($url, 'widget')) {
            return 'widget';
        }

        return 'table';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $menu = $this->getOwnerRecord();
        $data['menu_slug'] = $menu->slug;
        $data['locale'] = $menu->locale;
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $menu = $this->getOwnerRecord();
        $data['menu_slug'] = $menu->slug;
        $data['locale'] = $menu->locale;
        return $data;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('locale')
                    ->default(fn () => $this->getOwnerRecord()->locale)
                    // ->disabled()
                    ->dehydrated(false),
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required(),
                CuratorPicker::make('media_id')
                    ->label('Media')
                    ->multiple() // 啟用多選模式，這是關鍵！
                    ->constrained(true) // 可選：限制圖片尺寸比例
                    ->columnSpanFull() // 讓圖片欄位佔滿整行
                    ->relationship('images', 'id') // 這是關鍵！指定關聯名稱和要儲存的 ID 欄位
                    ->orderColumn('order'), // 可選：指定中間表中的排序欄位
                Forms\Components\Toggle::make('display')
                    ->label('Published'),
                Forms\Components\DatePicker::make('date')
                    ->label('Published At'),
                TiptapEditor::make('content')
                    ->label('Content')
                    ->columnSpan('full'),
                    // ->visible(fn () => $this->getOwnerRecord()?->type !== 'rabbit')
                    // ->maxLength(65535),
                Forms\Components\RichEditor::make('intro')
                    ->label('intro')
                    ->columnSpan('full'),
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
                    // ])
                    // ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        $menu = $this->getOwnerRecord();
        $shouldShowCreateAction = $menu->type !== 'posts';

        return $table
            // ->heading('病患資料')
            ->recordTitleAttribute('title')
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
            ])
            ->reorderable('order') // 啟用拖拉排序功能
            ->defaultSort('order') // 預設按 sort_order 排序
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->visible($shouldShowCreateAction),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
        $ownerRecord = $this->getOwnerRecord();

        // 基於用戶權限的 Tab
        $tabs = [
            'all' => Tab::make('全部文章')
                ->badge($ownerRecord->posts()->count())
                // ->badge(Post::count())
                ->icon('heroicon-o-document-duplicate'),
            'published' => Tab::make('已發布')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('display', 1))
                ->badge(Post::where('display', 1)->count())
                ->badgeColor('success')
                ->icon('heroicon-o-check-circle'),
            'unpublished' => Tab::make('未發布')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('display', 0))
                ->badge(Post::where('display', 0)->count())
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

        switch ($this->activeTab) {
            case 'published':
                return $ownerRecord->posts()->where('display', '1')->count();
            case 'unpublished':
                return $ownerRecord->posts()->where('display', '0')->count();
            // case 'scheduled':
            //     return $ownerRecord->posts()->where('status', 'scheduled')->count();
            // case 'archived':
            //     return $ownerRecord->posts()->where('status', 'archived')->count();
            default:
                return $ownerRecord->posts()->count();
        }
    }
}
