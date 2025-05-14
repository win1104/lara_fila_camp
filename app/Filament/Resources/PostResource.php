<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\DatePicker;
use Tables\Columns\DateTimeColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $pluralLabel = '內容管理'; // 這將用於標題和側邊欄
    // protected static ?string $navigationLabel = '網站選單'; // 只有側邊欄
    protected static ?string $label = '文章'; // 這將用於單數形式
    protected static ?string $navigationGroup = 'Website';


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
                // CuratorPicker::make('media_id')
                //     ->label('Media'),
                    // ->required(),
                Forms\Components\Toggle::make('display')
                    ->label('Published'),
                Forms\Components\DatePicker::make('date')
                    ->label('Published At'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // CuratorColumn::make('media_id')
                //     ->label('Media')
                //     ->size('40'),
                Tables\Columns\IconColumn::make('display')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort')
                    ->label('Sort')
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
            ->reorderable('sort') // 啟用拖拉排序功能
            ->defaultSort('sort') // 預設按 sort_order 排序
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
