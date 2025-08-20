<?php

namespace App\Livewire;

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class FolderTree extends Component
{
    public array $tree = [];
    public ?string $selectedDirectory = null;

    // Properties for folder management
    public string $newFolderName = '';
    public ?string $parentFolder = null;
    public ?string $showSubFolderModalFor = null;
    public string $subFolderName = '';
    public bool $showingSubFolderModal = false;
    public bool $delSubFolderModal = false;
    public string|null $confirmingDeleteFolder = null;
    public string $renameTo = '';
    public ?string $renamingFolder = null;

    public function mount()
    {
        $this->loadFolderTree();
    }

    public function loadFolderTree()
    {
        $baseDir = config('curator.directory', 'media');
        $disk = config('curator.disk', 'public');
        $this->tree = $this->getFoldersRecursive(Storage::disk($disk), $baseDir);
    }

    private function getFoldersRecursive($disk, $path): array
    {
        $folders = [];

        foreach ($disk->directories($path) as $dir) {
            $folders[] = [
                'name' => basename($dir),
                'path' => str_replace($disk->path(''), '', $dir),
                'children' => $this->getFoldersRecursive($disk, $dir),
            ];
        }

        return $folders;
    }

    public function selectDirectory(string $path)
    {
        $this->selectedDirectory = $path;
        $this->dispatch('folderSelected', $path);
    }

    public function createFolder()
    {
        if (!$this->newFolderName) {
            Notification::make()->title('請輸入資料夾名稱')->danger()->send();
            return;
        }

        $disk = config('curator.disk', 'public');
        $baseDir = config('curator.directory', 'media');
        $path = $baseDir . '/' . $this->newFolderName;

        if (Storage::disk($disk)->exists($path)) {
            Notification::make()->title("資料夾已存在")->warning()->send();
        } else {
            Storage::disk($disk)->makeDirectory($path);
            Notification::make()->title("已建立資料夾")->success()->send();
        }

        $this->reset(['newFolderName']);
        $this->loadFolderTree();
    }

    public function createSubFolder()
    {
        $disk = config('curator.disk', 'public');
        $baseDir = config('curator.directory', 'media');

        $parentPath = $this->showSubFolderModalFor;
        $newFolderName = $this->subFolderName;

        if (empty($newFolderName)) {
            Notification::make()->title('請輸入資料夾名稱')->danger()->send();
            return;
        }

        $newPath = $parentPath ? $parentPath . '/' . $newFolderName : $baseDir . '/' . $newFolderName;

        if (Storage::disk($disk)->exists($newPath)) {
            Notification::make()->title("資料夾已存在")->warning()->send();
        } else {
            Storage::disk($disk)->makeDirectory($newPath);
            Notification::make()->title("子資料夾已建立")->success()->send();
        }

        $this->subFolderName = '';
        $this->showSubFolderModalFor = null;
        $this->showingSubFolderModal = false;

        $this->loadFolderTree();
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
        $disk = config('curator.disk', 'public');
        $realPath = config('curator.directory', 'media') . '/' . $path;

        if (Storage::disk($disk)->allFiles($realPath) || Storage::disk($disk)->allDirectories($realPath)) {
            $this->confirmingDeleteFolder = $this->confirmingDeleteFolder === $path ? null : $path;
            return;
        }

        $this->forceDeleteFolder($path);
    }

    public function forceDeleteFolder($path)
    {
        $disk = config('curator.disk', 'public');
        $realPath = config('curator.directory', 'media') . '/' . $path;

        Storage::disk($disk)->deleteDirectory($realPath);
        Notification::make()->title("已刪除資料夾：{$path}")->success()->send();

        $this->confirmingDeleteFolder = null;
        $this->delSubFolderModal = false;
        $this->loadFolderTree();
    }

    public function renamePrompt($folder)
    {
        $this->renamingFolder = $folder;
        $this->renameTo = $folder;
    }

    public function renameFolder()
    {
        if (!$this->renamingFolder || !$this->renameTo)
            return;

        $disk = config('curator.disk', 'public');
        $baseDir = config('curator.directory', 'media');

        $from = $baseDir . '/' . $this->renamingFolder;
        $to = $baseDir . '/' . $this->renameTo;

        if (!Storage::disk($disk)->exists($from)) {
            Notification::make()->title("原始資料夾不存在")->danger()->send();
            return;
        }

        if (Storage::disk($disk)->exists($to)) {
            Notification::make()->title("新資料夾名稱已存在")->danger()->send();
            return;
        }

        Storage::disk($disk)->move($from, $to);
        Notification::make()->title("已重新命名為：{$this->renameTo}")->success()->send();

        $this->renamingFolder = null;
        $this->renameTo = '';
        $this->loadFolderTree();
    }

    public function expandAllFolders()
    {
        $this->dispatch('expand-all-folders');
    }

    public function collapseAllFolders()
    {
        $this->dispatch('collapse-all-folders');
    }

    public function render()
    {
        return view('livewire.folder-tree');
    }
}
