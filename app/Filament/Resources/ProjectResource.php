<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Project;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-globe-asia-australia';

    public static function getModelLabel(): string
    {
        return __('project.label');
    }
    public static function getModelPluralLabel(): string
    {
        return __('project.plural');
    }
    public static function getNavigationLabel(): string
    {
        return __('project.navigation');
    }
    protected static ?string $navigationGroup = 'Project';

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
                Forms\Components\Card::make()
                    ->key('project-form-card')
                    ->heading(__('backstage.menu_data'))
                    ->icon('heroicon-m-bars-4')
                    ->schema([
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label(__('backstage.title'))
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('slug')
                                            ->label(__('backstage.slug'))
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true),
                                        Forms\Components\Select::make('parent_slug')
                                            ->label(__('backstage.area'))
                                            ->options(function () {
                                                return \App\Models\ProductCategory::where('parent_slug', 'tarvelgroups')
                                                    ->pluck('title', 'slug');
                                            })
                                            ->searchable()
                                            ->required(),
                                        Forms\Components\TextInput::make('order')
                                            ->label(__('backstage.order'))
                                            ->required()
                                            ->numeric()
                                            ->default(0),
                                        Forms\Components\Select::make('type')
                                            ->label(__('backstage.type'))
                                            ->options([
                                                'posts' => __('backstage.type_posts'),
                                                'listS' => __('backstage.type_lists'),
                                                'tilelists' => __('backstage.type_tilelists'),
                                                'tabs' => __('backstage.type_tabs'),
                                                'collapses' => __('backstage.type_collapses'),
                                            ])
                                            ->required(),
                                        Forms\Components\RichEditor::make('note')
                                            ->label(__('backstage.content')),
                                    ]),
                            ])
                            ->columnSpan(['lg' => 2]),
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make(__('backstage.setting'))
                                    ->schema([
                                        Forms\Components\TextInput::make('locale')
                                            ->label(__('backstage.locale'))
                                            ->required(),
                                        Forms\Components\Select::make('sales_id')
                                            ->label(__('backstage.sales'))
                                            ->relationship('projectsales', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name')
                                                    ->label(__('backstage.name'))
                                                    ->required()
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('email')
                                                    ->label('Email')
                                                    ->email()
                                                    ->required()
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('phone')
                                                    ->label(__('backstage.phone'))
                                                    ->tel()
                                                    ->required()
                                                    ->maxLength(255),
                                            ])
                                            ->nullable(),
                                    ]),
                            ])
                            ->columnSpan(['lg' => 1]),
                    ])
                    ->columns(3)
                    ->collapsible()
                    ->collapsed()
                    ->footerActions([
                        Forms\Components\Actions\Action::make('save')
                            ->label(__('backstage.save'))
                            ->submit('project-form-card')
                            ->color('primary'),
                    ]),
                ])
                ->live();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->where('locale', app()->getLocale()))
            // ->heading('網站架構（表格模式）')
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label(__('backstage.order'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('backstage.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('locale')
                    ->label(__('backstage.locale')),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('backstage.slug'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent_slug')
                    ->label(__('backstage.area'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('backstage.type'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('projectsales.name')
                    ->label(__('backstage.sales'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('backstage.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('backstage.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            RelationManagers\ProjectJourneyRelationManager::class,
            RelationManagers\ProjectOptionsRelationManager::class,
            RelationManagers\ProjectFlightRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }

    /* Navigation 的 label 旁有資料總筆數的數字 */
    // public static function getNavigationBadge(): ?string
    // {
    //     return static::getModel()::count();
    // }
}
