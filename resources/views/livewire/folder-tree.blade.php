<div>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-medium">資料夾</h3>
        <div class="flex items-center space-x-2">
            <x-filament::button
                wire:click="expandAllFolders"
                size="sm"
                color="gray"
                icon="heroicon-o-plus-circle">
                全展開
            </x-filament::button>
            <x-filament::button
                wire:click="collapseAllFolders"
                size="sm"
                color="gray"
                icon="heroicon-o-minus-circle">
                全折叠
            </x-filament::button>
        </div>
    </div>
    @foreach($tree as $folder)
        @include('livewire.partials.folder-item', ['folder' => $folder, 'level' => 0, 'selectedDirectory' => $selectedDirectory])
    @endforeach
</div>

    {{-- 重新命名 Modal --}}
    @if ($renamingFolder)
        <div class="fixed inset-0 bg-gray-800/75 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-lg font-semibold mb-4">重新命名資料夾</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">新資料夾名稱</label>
                        <x-filament::input
                            wire:model.defer="renameTo"
                            placeholder="輸入新資料夾名稱"
                            class="w-full border border-gray-300 dark:border-gray-600"
                        />
                    </div>
                    <div class="flex justify-end space-x-3">
                        <x-filament::button wire:click="$set('renamingFolder', null)" color="gray">
                            取消
                        </x-filament::button>
                        <x-filament::button wire:click="renameFolder">
                            確定重新命名
                        </x-filament::button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- 新增子資料夾 Modal --}}
    @if ($showingSubFolderModal)
        <div class="fixed inset-0 bg-gray-800/75 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-lg font-semibold mb-4">新增子資料夾</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">子資料夾名稱</label>
                        <x-filament::input
                            wire:model.defer="subFolderName"
                            placeholder="輸入子資料夾名稱"
                            class="w-full border border-gray-300 dark:border-gray-600"
                        />
                    </div>
                    <div class="text-sm text-gray-500">
                        將在 <span class="font-medium">{{ $showSubFolderModalFor }}</span> 中建立
                    </div>
                    <div class="flex justify-end space-x-3">
                        <x-filament::button wire:click="closeSubFolderModal" color="gray">
                            取消
                        </x-filament::button>
                        <x-filament::button wire:click="createSubFolder">
                            建立子資料夾
                        </x-filament::button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- 刪除確認 Modal --}}
    @if($confirmingDeleteFolder)
        <div class="fixed inset-0 bg-gray-800/75 dark:bg-gray-900/80 flex items-center justify-center z-50" x-data x-show="$wire.confirmingDeleteFolder">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5l-6.928-12c-.77-.833-1.732-.833-2.502 0L1.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">確認刪除</h2>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-6">此資料夾內還有檔案或子資料夾，確定要一併刪除所有內容嗎？</p>
                <div class="flex justify-end space-x-3">
                    <x-filament::button wire:click="$set('confirmingDeleteFolder', null)" color="gray">
                        取消
                    </x-filament::button>
                    <x-filament::button wire:click="forceDeleteFolder('{{ $confirmingDeleteFolder }}')" color="danger">
                        確定刪除
                    </x-filament::button>
                </div>
            </div>
        </div>
    @endif
