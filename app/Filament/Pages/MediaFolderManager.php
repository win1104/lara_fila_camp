<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\File;
use Filament\Notifications\Notification;

class MediaFolderManager extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static string $view = 'filament.pages.media-folder-manager';

    // public string $newFolder = '';
    public string $renameTo = '';
    public ?string $renamingFolder = null;
    public string $newFolderName = '';
    public ?string $parentFolder = null;
    public ?string $showSubFolderModalFor = null; // 記錄目前要新增子資料夾的父資料夾路徑
    public string $subFolderName = ''; // 彈窗裡的輸入值
    public bool $showingSubFolderModal = false;
    public bool $delSubFolderModal = false;
    // public string $confirmingFolder = '';
    public string|null $confirmingDeleteFolder = null;
    protected static ?string $navigationGroup = 'Content';

    // protected static bool $shouldRegisterNavigation = false;


    public array $folders = [];
    public array $subFolderNames = [];

    public function mount(): void
    {
        $this->loadFolders();
        // $this->mediaFolderOptions = $this->flattenFolders($this->folders);
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
        // $name = $this->subFolderNames[$parentPath] ?? '';
        // if (!$name) {
        //     Notification::make()->title('請輸入子資料夾名稱')->danger()->send();
        //     return;
        // }
        // $path = storage_path("app/public/media/{$parentPath}/{$name}");
        // if (!File::exists($path)) {
        //     File::makeDirectory($path, 0755, true);
        //     Notification::make()->title("已建立子資料夾")->success()->send();
        // } else {
        //     Notification::make()->title("子資料夾已存在")->warning()->send();
        // }
        // $this->subFolderNames[$parentPath] = '';
        // $this->loadFolders();
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

        // 清除狀態與關閉 modal
        $this->subFolderName = '';
        $this->showSubFolderModalFor = null;
        $this->showingSubFolderModal = false;

        $this->loadFolders(); // 重新載入資料夾
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
        $this->delSubFolderModal = true;
        $realPath = storage_path("app/public/media/{$path}");

        if (count(File::allFiles($realPath)) > 0 || count(File::directories($realPath)) > 0) {
            // Notification::make()->title("資料夾非空，請先清空再刪除")->danger()->send();
            $this->confirmingDeleteFolder = $this->confirmingDeleteFolder === $path ? null : $path;
            return;
        }

        // File::deleteDirectory($realPath);
        // Notification::make()->title("已刪除資料夾：{$path}")->success()->send();
        // $this->loadFolders();
        $this->forceDeleteFolder($path);

        // if (File::exists($path)) {
        //     if (count(File::files($path)) > 0) {
        //         // 有這個資料夾，而且裡面有東西
        //         Notification::make()->title("資料夾內還有資料，確定要刪除嗎？")->danger()->send();
        //         return;
        //     } else {
        //         // 有這個資料夾，但裡面是空的
        //         File::deleteDirectory($path);
        //         Notification::make()->title("已刪除：{$folder}")->success()->send();
        //     }
        // } else {
        //     // 資料夾不存在
        //     Notification::make()->title("資料夾已不存在。")->danger()->send();
        //     return;
        // }
    }

    public function forceDeleteFolder($path)
    {
        $realPath = storage_path("app/public/media/{$path}");

        File::deleteDirectory($realPath);
        Notification::make()->title("已刪除資料夾：{$path}")->success()->send();

        $this->confirmingDeleteFolder = null;
        $this->delSubFolderModal = false;
        $this->loadFolders();
    }


    // public function askDeleteFolder(string $path)
    // {
    //     $realPath = storage_path("app/public/media/{$path}");

    //     if (count(File::allFiles($realPath)) > 0 || count(File::directories($realPath)) > 0) {
    //         $this->dispatchBrowserEvent('confirm-delete-folder', ['path' => $path]);
    //         return;
    //     }

    //     File::deleteDirectory($realPath);
    //     Notification::make()->title("已刪除資料夾：{$path}")->success()->send();
    //     $this->loadFolders();
    // }

    public function renamePrompt($folder)
    {
        $this->renamingFolder = $folder;
        $this->renameTo = $folder;
    }

    public function renameFolder()
    {
        if (!$this->renamingFolder || !$this->renameTo)
            return;

        $from = storage_path("app/public/media/{$this->renamingFolder}");
        $to = storage_path("app/public/media/{$this->renameTo}");

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

    public function prepareCreateFolder($parentPath)
    {
        $this->parentFolder = $parentPath;
    }

    // public static function flattenFolders(array $folders, string $prefix = ''): array
    // {
    //     $result = [];

    //     foreach ($folders as $folder) {
    //         $name = $prefix ? "{$prefix}/{$folder['name']}" : $folder['name'];
    //         $result[$name] = $name;

    //         if (!empty($folder['children'])) {
    //             $result += self::flattenFolders($folder['children'], $name);
    //         }
    //     }

    //     return $result;
    // }

}
