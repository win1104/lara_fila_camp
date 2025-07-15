<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Project;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $label = '專案'; // 這將用於單數形式

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $pluralLabel = '專案管理'; // 這將用於標題和側邊欄
    protected static ?string $navigationLabel = '專案管理'; // 只有側邊欄
    protected static ?string $navigationGroup = 'Project';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->key('project-form-card')
                    ->heading('選單資料')
                    ->icon('heroicon-m-bars-4')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('locale')
                            ->required(),
                        Forms\Components\TextInput::make('slug')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('parent_slug')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('order')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\Select::make('type')
                            ->options([
                                'posts' => 'Posts',
                                'listS' => 'Lists',
                                'tilelists' => 'Tilelists',
                                'tabs' => 'Tabs',
                                'collapses' => 'Collapses',
                            ])
                            ->required(),
                        Forms\Components\Select::make('sales_id')
                            ->label('銷售人員')
                            ->relationship('projectsales', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('姓名')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('phone')
                                    ->label('電話')
                                    ->tel()
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->nullable(),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->footerActions([
                        Forms\Components\Actions\Action::make('save')
                            ->label('儲存資料')
                            ->submit('project-form-card')
                            ->color('primary'),
                    ]),
                ])
                ->columns(12)
                ->live();
    }

    public static function table(Table $table): Table
    {
        return $table
            // ->heading('網站架構（表格模式）')
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('locale'),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent_slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('projectsales.name')
                    ->label('銷售人員')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->reorderable('order') // 啟用拖拉排序功能
            ->defaultSort('order', 'asc') // 預設按 sort_order 排序
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
                // Tables\Actions\ViewAction::make()->url(fn (Project $record): string => static::getUrl('view', ['record' => $record->slug])),
                Tables\Actions\EditAction::make()->url(fn (Project $record): string => static::getUrl('edit', ['record' => $record->slug])),
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
            // 'view' => Pages\ViewProject::route('/{record}'),
        ];
    }

    public static function getRouteKeyName(): string
    {
        return 'slug';
    }

    public static function getRecordRouteKeyName(): string
    {
        return 'slug';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
