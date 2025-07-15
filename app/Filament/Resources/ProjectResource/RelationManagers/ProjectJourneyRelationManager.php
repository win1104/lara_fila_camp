<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use App\Models\ProjectJourney;
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

class ProjectJourneyRelationManager extends RelationManager
{
    protected static string $relationship = 'projectjourney';
    protected static string $view = 'filament.resources.project-resource.relation-managers.project-journey-relation-manager';
    protected static ?string $title = '每日行程';
    protected static ?string $icon = 'heroicon-o-calendar-days';



    public ?string $activeTab = 'all';

    public function setActiveTab($tabKey)
    {
        $this->activeTab = $tabKey;
    }

    public function mount(): void
    {
        // dd($this->getSource());
        // $this->loadDefaultActiveTab();
    }

    protected function getSource(): string
    {
        $url = url()->previous();

        Log::info('ProjectJourneyRelationManager URL:', ['url' => $url]);

        if (str_contains($url, 'widget')) {
            return 'widget';
        }

        return 'table';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $project = $this->getOwnerRecord();
        $data['project_slug'] = $project->slug;
        $data['locale'] = $project->locale;
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $project = $this->getOwnerRecord();
        $data['project_slug'] = $project->slug;
        $data['locale'] = $project->locale;
        return $data;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('locale')
                    ->default(fn () => $this->getOwnerRecord()->locale),
                Forms\Components\Hidden::make('project_slug')
                    ->default(fn () => $this->getOwnerRecord()->slug),
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required(),
                CuratorPicker::make('media_id')
                    ->label('Media')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('display')
                    ->label('Published'),
                Forms\Components\DatePicker::make('date')
                    ->label('Published At'),
                TiptapEditor::make('content')
                    ->label('Content')
                    ->columnSpan('full'),
                Forms\Components\RichEditor::make('intro')
                    ->label('intro')
                    ->columnSpan('full'),
            ]);
    }

    public function table(Table $table): Table
    {
        $project = $this->getOwnerRecord();
        $shouldShowCreateAction = true; // 總是顯示新增按鈕

        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('locale'),
                Tables\Columns\IconColumn::make('display')
                    ->label('上架')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order')
                    ->label('Order')
                    ->sortable(),
                CuratorColumn::make('media_id')
                    ->size(40),
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
            ->reorderable('order')
            ->defaultSort('order')
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

    public function getTabs(): array
    {
        $ownerRecord = $this->getOwnerRecord();

        $tabs = [
            'all' => Tab::make('全部文章')
                ->badge($ownerRecord->projectjourney()->count())
                ->icon('heroicon-o-document-duplicate'),
            'published' => Tab::make('已發布')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('display', 1))
                ->badge($ownerRecord->projectjourney()->where('display', 1)->count())
                ->badgeColor('success')
                ->icon('heroicon-o-check-circle'),
            'unpublished' => Tab::make('未發布')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('display', 0))
                ->badge($ownerRecord->projectjourney()->where('display', 0)->count())
                ->badgeColor('gray')
                ->icon('heroicon-o-x-circle'),
        ];

        return $tabs;
    }
}
