<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Menu;
use App\Models\Post;
use Filament\Tables;
use Filament\Infolists;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Tables\Columns\DateTimeColumn;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;
use Filament\Tables\Filters\SelectFilter;
use Filament\Resources\Components\Tab;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-x-mark';
    protected static ?string $pluralLabel = 'Post'; // 這將用於標題和側邊欄
    // protected static ?string $navigationLabel = '網站選單'; // 只有側邊欄
    protected static ?string $label = '文章'; // 這將用於單數形式

    protected static ?string $navigationParentItem = 'Article';
    protected static ?string $navigationGroup = 'Website';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('locale')
                    ->required()
                    ->default(fn () => app()->getLocale()),
                Forms\Components\Select::make('menu_slug')
                    ->label('Menu')
                    ->options(fn () => Menu::where('locale', app()->getLocale())
                        ->pluck('title', 'slug'))
                    ->required()
                    ->searchable(),
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required(),
                Forms\Components\RichEditor::make('content')
                    ->label('Content')
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
                    ->required(),
                // CuratorPicker::make('media_id')
                //     ->label('Media'),
                    // ->required(),
                Forms\Components\Toggle::make('display')
                    ->label('Published'),
                Forms\Components\DatePicker::make('date')
                    ->label('Published At'),
                Forms\Components\Textarea::make('intro')
                    ->label('Intro')
                    ->columnSpan('full')
                    // ->visible(fn () => $this->getOwnerRecord()?->type !== 'rabbit')
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // CuratorColumn::make('media_id')
                //     ->label('Media')
                //     ->size('40'),

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
                Infolists\Components\TextEntry::make('title'),
                Infolists\Components\TextEntry::make('slug'),
                Infolists\Components\TextEntry::make('date')
                    ->columnSpanFull(),
            ]);
    }

    public static function getTabs(): array
    {
        return [
            'all' => Tab::make('全部文章')
                ->badge(Post::count()),
            'published' => Tab::make('已發布')
                ->badge(Post::where('display', 1)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('display', 1)),
            'unpublished' => Tab::make('未發布')
                ->badge(Post::where('display', 0)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('display', 0)),
            'recent' => Tab::make('最近更新')
                ->badge(Post::where('updated_at', '>=', now()->subDays(7))->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('updated_at', '>=', now()->subDays(7))),
            'this_month' => Tab::make('本月發布')
                ->badge(Post::whereMonth('created_at', now()->month)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->whereMonth('created_at', now()->month)),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
