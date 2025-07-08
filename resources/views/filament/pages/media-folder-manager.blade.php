<x-filament-panels::page>
    <h2 class="text-xl font-bold mb-4">圖片資料夾管理</h2>

    <div class="flex items-center space-x-3 mb-6">
        <x-filament::input wire:model.defer="newFolderName" placeholder="輸入資料夾名稱" />
        <x-filament::button wire:click="createFolder">新增</x-filament::button>
    </div>

    <ul>
        @foreach ($folders as $folder)
            @include('filament.pages.partials.folder-item', ['folder' => $folder, 'level' => 0])
        @endforeach
    </ul>

    @if ($renamingFolder)
        <div class="mt-6">
            <x-filament::input wire:model.defer="renameTo" placeholder="新資料夾名稱" />
            <x-filament::button wire:click="renameFolder">確定修改</x-filament::button>
            <x-filament::button color="secondary" wire:click="$set('renamingFolder', null)">取消</x-filament::button>
        </div>
    @endif

    @if ($showingSubFolderModal)
        <div class="fixed inset-0 bg-gray-800/75 flex items-center justify-center z-50" x-data
            x-show="$wire.showingSubFolderModal">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-lg font-semibold mb-4">新增子資料夾</h2>

                <x-filament::input wire:model.defer="subFolderName" placeholder="輸入子資料夾名稱" class="w-full mb-4" />

                <div class="flex justify-end gap-2">
                    <x-filament::button wire:click="createSubFolder" type="button">確定</x-filament::button>
                    <x-filament::button wire:click="closeSubFolderModal" color="gray" type="button">取消</x-filament::button>
                </div>
            </div>
        </div>
    @endif


</x-filament-panels::page>
