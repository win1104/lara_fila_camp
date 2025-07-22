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

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-x-mark';
    // protected static ?string $navigationLabel = '網站選單'; // 只有側邊欄
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

    public static function getRouteKeyName(): string
    {
        return 'slug';
    }

    public static function resolveRecordRouteBinding($key): ?\Illuminate\Database\Eloquent\Model
    {
        $locale = app()->getLocale();

        $result = static::getModel()::where('slug', $key)
            ->where('locale', $locale)
            ->first();

        \Illuminate\Support\Facades\Log::info('PostResource resolveRecordRouteBinding:', [
            'key' => $key,
            'locale' => $locale,
            'route' => request()->route()->getName(),
            'found_record_id' => $result?->id,
            'found_record_locale' => $result?->locale,
            'found_record_title' => $result?->title
        ]);

        return $result;
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('locale')
                    ->label(__('backstage.locale'))
                    ->required(),
                    // ->default(fn ($record) => $record?->locale ?? app()->getLocale()),
                Forms\Components\Select::make('menu_slug')
                    ->label(__('backstage.menu'))
                    ->options(fn ($record) => Menu::where('locale', $record?->locale ?? app()->getLocale())
                        ->pluck('title', 'slug'))
                    ->required()
                    ->searchable(),
                Forms\Components\TextInput::make('title')
                    ->label(__('backstage.title'))
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->label(__('backstage.slug'))
                    ->required(),
                Forms\Components\RichEditor::make('content')
                    ->label(__('backstage.content'))
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
                    ->label(__('backstage.published')),
                Forms\Components\DatePicker::make('date')
                    ->label(__('backstage.published_at')),
                Forms\Components\Textarea::make('intro')
                    ->label(__('backstage.intro'))
                    ->columnSpan('full')
                    // ->visible(fn () => $this->getOwnerRecord()?->type !== 'rabbit')
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->where('locale', app()->getLocale()))
            ->columns([
                // CuratorColumn::make('media_id')
                //     ->label('Media')
                //     ->size('40'),

                Tables\Columns\TextColumn::make('locale')
                    ->label(__('backstage.locale')),
                Tables\Columns\IconColumn::make('display')
                    ->label(__('backstage.published'))
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order')
                    ->label(__('backstage.order'))
                    ->sortable(),
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
            ])
            ->reorderable('order') // 啟用拖拉排序功能
            ->defaultSort('order') // 預設按 sort_order 排序
            ->filters([
                SelectFilter::make('display')
                    ->label(__('backstage.display_status'))
                    ->options([
                        '1' => __('backstage.published'),
                        '0' => __('backstage.unpublished'),
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
