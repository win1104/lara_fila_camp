<?php

namespace App\Filament\Pages;

use App\Filament\Resources\MediaResource;
use Awcodes\Curator\Models\Media;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\File;
use Filament\Notifications\Notification;

class MediaExplorer extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static string $view = 'filament.pages.media-explorer';
    protected static ?string $navigationGroup = 'Media';
    protected static ?string $title = 'Media Explorer';

    // --- Properties from MediaExplorer ---
    public ?string $directory = null;
    public string $layoutView = 'grid';

    // --- Properties from MediaFolderManager ---
    public string $renameTo = '';
    public ?string $renamingFolder = null;
    public string $newFolderName = '';
    public ?string $parentFolder = null;
    public ?string $showSubFolderModalFor = null;
    public string $subFolderName = '';
    public bool $showingSubFolderModal = false;
    public string|null $confirmingDeleteFolder = null;
    public array $folders = [];
    public bool $expandAll = false;

    protected $listeners = [
        'folderSelected' => 'onFolderSelected'
    ];

    public function mount(): void
    {
        $this->loadFolders();
    }

    public function loadFolders()
    {
        $this->folders = $this->getFoldersRecursive(storage_path('app/public/media'));
    }

    private function getFoldersRecursive($path): array
    {
        $folders = [];
        foreach (File::directories($path) as $dir) {
            $folders[] = [
                'name' => basename($dir),
                'path' => str_replace(storage_path('app/public/media/'), '', $dir),
                'children' => $this->getFoldersRecursive($dir),
            ];
        }
        return $folders;
    }

    public function createFolder()
    {
        if (!$this->newFolderName) {
            Notification::make()->title('請輸入資料夾名稱')->danger()->send();
            return;
        }
        $path = storage_path("app/public/media/{$this->parentFolder}/{$this->newFolderName}");
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
            Notification::make()->title("已建立資料夾")->success()->send();
        } else {
            Notification::make()->title("資料夾已存在")->warning()->send();
        }
        $this->reset(['newFolderName', 'parentFolder']);
        $this->loadFolders();
    }

    public function createSubFolder()
    {
        $parentPath = $this->showSubFolderModalFor;
        $newFolderName = $this->subFolderName;
        if (empty($newFolderName)) {
            Notification::make()->title('請輸入資料夾名稱')->danger()->send();
            return;
        }
        $newPath = storage_path("app/public/media/{$parentPath}/{$newFolderName}");
        if (!File::exists($newPath)) {
            File::makeDirectory($newPath, 0755, true);
            Notification::make()->title("子資料夾已建立")->success()->send();
        } else {
            Notification::make()->title("資料夾已存在")->warning()->send();
        }
        $this->subFolderName = '';
        $this->showSubFolderModalFor = null;
        $this->showingSubFolderModal = false;
        $this->loadFolders();
    }

    public function openSubFolderModal($parentPath)
    {
        $this->showSubFolderModalFor = $parentPath;
        $this->subFolderName = '';
        $this->showingSubFolderModal = true;
    }

    public function closeSubFolderModal()
    {
        $this->showingSubFolderModal = false;
        $this->showSubFolderModalFor = null;
        $this->subFolderName = '';
    }

    public function deleteFolder($path)
    {
        $realPath = storage_path("app/public/media/{$path}");
        if (count(File::allFiles($realPath)) > 0 || count(File::directories($realPath)) > 0) {
            $this->confirmingDeleteFolder = $this->confirmingDeleteFolder === $path ? null : $path;
            return;
        }
        $this->forceDeleteFolder($path);
    }

    public function forceDeleteFolder($path)
    {
        $realPath = storage_path("app/public/media/{$path}");
        File::deleteDirectory($realPath);
        Notification::make()->title("已刪除資料夾：{$path}")->success()->send();
        $this->confirmingDeleteFolder = null;
        $this->loadFolders();
    }

    public function renamePrompt($folder)
    {
        $this->renamingFolder = $folder;
        $this->renameTo = basename($folder);
    }

    public function renameFolder()
    {
        if (!$this->renamingFolder || !$this->renameTo) return;

        $from = storage_path("app/public/media/{$this->renamingFolder}");

        $parentPath = dirname($this->renamingFolder);
        $newFullPath = ($parentPath === '.' || $parentPath === '/') ? $this->renameTo : $parentPath . '/' . $this->renameTo;
        $to = storage_path("app/public/media/{$newFullPath}");

        if (!File::exists($from)) {
            Notification::make()->title("原始資料夾不存在")->danger()->send();
            return;
        }

        if (File::exists($to)) {
            Notification::make()->title("新資料夾名稱已存在")->danger()->send();
            return;
        }

        File::move($from, $to);
        Notification::make()->title("已重新命名為：{$this->renameTo}")->success()->send();

        $this->renamingFolder = null;
        $this->renameTo = '';
        $this->loadFolders();
    }

    public function expandAllFolders()
    {
        $this->expandAll = true;
        $this->dispatch('expand-all-folders');
    }

    public function collapseAllFolders()
    {
        $this->expandAll = false;
        $this->dispatch('collapse-all-folders');
    }

    public function selectDirectory(string $path)
    {
        $this->onFolderSelected($path);
    }

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
                    : [
                        CuratorColumn::make('url')
                            ->label(trans('curator::tables.columns.url'))
                            ->size(40),
                        TextColumn::make('name')
                            ->label(trans('curator::tables.columns.name'))
                            ->searchable()
                            ->sortable()
                            ->wrap(),
                        // TextColumn::make('directory')
                        //     ->label(trans('curator::tables.columns.directory'))
                        //     ->searchable()
                        //     ->sortable()
                        //     ->wrap(),
                            // ->toggleable(isToggledHiddenByDefault: true),
                        TextColumn::make('created_at')
                            ->label(trans('curator::tables.columns.created_at'))
                            ->dateTime()
                            ->sortable(),
                    ]
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
                    $prefixed_directory = 'media/' . $this->directory;
                    $query->where(function (Builder $q) use ($prefixed_directory) {
                        $q->where('directory', $prefixed_directory)
                          ->orWhere('directory', 'like', $prefixed_directory . '/');
                    });
                }
            })
            ->defaultPaginationPageOption(12)
            ->paginationPageOptions([6, 12, 24, 48, 'all'])
            ->recordUrl(false);
    }

    public static function getNavigationLabel(): string
    {
        return 'Media Explorer';
    }
}
