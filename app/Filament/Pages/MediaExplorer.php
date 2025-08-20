<?php

namespace App\Filament\Pages;

use App\Filament\Resources\MediaResource;
use Awcodes\Curator\Models\Media;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MediaExplorer extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static string $view = 'filament.pages.media-explorer';
    protected static ?string $navigationGroup = 'Media';
    protected static ?string $title = 'Media Explorer';

    public ?string $directory = null;
    public string $layoutView = 'grid'; // Added for grid/list toggle

    protected $listeners = [
        'folderSelected' => 'onFolderSelected'
    ];

    public function onFolderSelected(string $directory)
    {
        $this->directory = $directory;
        $this->resetTable();
    }

    public function toggleLayout()
    {
        $this->layoutView = ($this->layoutView === 'grid') ? 'list' : 'grid';
        $this->resetTable();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(MediaResource::getEloquentQuery())
            ->columns(
                $this->layoutView === 'grid'
                    ? MediaResource::getDefaultGridTableColumns()
                    : MediaResource::getDefaultTableColumns(),
            )
            ->contentGrid(function () {
                if ($this->layoutView === 'grid') {
                    return [
                        'md' => 2,
                        'lg' => 3,
                        'xl' => 4,
                    ];
                }
                return null;
            })
            ->actions([
                \Filament\Tables\Actions\EditAction::make()
                    ->form(function (\Filament\Forms\Form $form) {
                        return MediaResource::form($form);
                    }),
                \Filament\Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\DeleteBulkAction::make(),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                if ($this->directory) {
                    $query->where('directory', $this->directory);
                }
            });
    }

    public static function getNavigationLabel(): string
    {
        return 'Media Explorer';
    }
}