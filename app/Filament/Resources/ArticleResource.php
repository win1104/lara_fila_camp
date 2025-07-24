<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Article;
use Filament\Forms\Form;
use Tables\Columns\Text;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ArticleResource\Pages;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ArticleResource\RelationManagers;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Filament\Resources\Components\Tab;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-x-mark';

    public static function getModelLabel(): string
    {
        return __('post.label');
    }
    public static function getModelPluralLabel(): string
    {
        return __('post.plural');
    }
    public static function getNavigationLabel(): string
    {
        return __('post.navigation');
    }
    protected static ?string $navigationGroup = 'Website';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                CuratorPicker::make('media_id')
                    ->label('Media'),
                    // ->required(),
                Forms\Components\Toggle::make('is_published')
                    ->label('Published'),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Published At'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                CuratorColumn::make('media_id')
                    ->label('Media')
                    ->size('40'),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable(),
                // Tables\Columns\DateTimeColumn::make('published_at')
                //     ->label('Published At')
                //     ->sortable(),

            ])
            ->reorderable('sort') // 啟用拖拉排序功能
            ->defaultSort('sort') // 預設按 sort_order 排序
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getTabs(): array
    {
        return [
            'all' => Tab::make('全部文章')
                ->badge(Article::count()),
            'published' => Tab::make('已發布')
                ->badge(Article::where('is_published', 1)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_published', 1)),
            'unpublished' => Tab::make('未發布')
                ->badge(Article::where('is_published', 0)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_published', 0)),
            'recent' => Tab::make('最近更新')
                ->badge(Article::where('updated_at', '>=', now()->subDays(7))->count())
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
