<x-filament-panels::page>
    <div class="flex flex-col lg:flex-row gap-4">
        {{-- Left Column --}}
        <div class="lg:w-1/4 flex-shrink-0">
            {{-- <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-4 space-y-6 h-full lg:h-[75vh] overflow-y-auto"> --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-4 space-y-6">
                {{-- New Root Folder --}}
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-medium mb-4">新增資料夾</h3>
                    <div class="flex items-center space-x-3">
                        <x-filament::input
                            wire:model.defer="newFolderName"
                            placeholder="輸入資料夾名稱"
                            class="flex-1 border border-gray-300 dark:border-gray-600"
                        />
                        <x-filament::button wire:click="createFolder" icon="heroicon-o-plus">
                            新增資料夾
                        </x-filament::button>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-6 h-full">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium">資料夾結構</h3>
                        <div class="flex items-center space-x-2">
                            <x-filament::button
                                wire:click="expandAllFolders"
                                size="sm"
                                color="gray"
                                icon="heroicon-o-plus-circle">
                                全部展開
                            </x-filament::button>
                            <x-filament::button
                                wire:click="collapseAllFolders"
                                size="sm"
                                color="gray"
                                icon="heroicon-o-minus-circle">
                                全部折叠
                            </x-filament::button>
                        </div>
                    </div>

                    @if(empty($folders))
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-5l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                            <p>尚未建立任何資料夾</p>
                        </div>
                    @else
                        <div class="folder-tree space-y-1">
                            @foreach ($folders as $folder)
                                @include('livewire.partials.folder-item', ['folder' => $folder, 'level' => 0, 'selectedDirectory' => $directory])
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="flex-1 min-w-0">
            <div class="flex justify-end mb-4">
                <x-filament::button wire:click="toggleLayout">
                    {{ $this->layoutView === 'grid' ? '列表視圖' : '網格視圖' }}
                </x-filament::button>
            </div>
            {{-- <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-4 lg:h-[75vh] overflow-y-auto"> --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-4 overflow-y-auto overflow-x-auto">
                {{ $this->table }}
            </div>
        </div>
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
</x-filament-panels::page>
