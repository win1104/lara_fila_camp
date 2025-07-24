<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Infolists;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PostCategory;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Tables\Columns\DateTimeColumn;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PostResource\Pages;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;

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
    protected static bool $shouldRegisterNavigation = false;

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
                                Forms\Components\RichEditor::make('intro')
                                    // ->visible(fn () => $this->getOwnerRecord()?->type !== 'rabbit')
                                    ->label(__('backstage.intro')),
                            ]),

                        Forms\Components\Section::make(__('backstage.content'))
                            ->schema([
                                Forms\Components\RichEditor::make('content')
                                    ->label(__('backstage.content'))
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

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
                                Forms\Components\Select::make('categories')
                                    ->label(__('backstage.category'))
                                    ->relationship('categories', 'title', fn(Builder $query) => $query->where('locale', app()->getLocale()))
                                    ->multiple()
                                    ->preload()
                                    ->searchable(),
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
            ->columns(3);
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
