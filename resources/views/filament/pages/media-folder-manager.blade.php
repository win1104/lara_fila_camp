<x-filament-panels::page>
    {{-- 自定義 CSS 樣式 --}}
    <style>
        .folder-tree {
            --tree-indent: 24px;
            --tree-line-color: #e5e7eb;
            --tree-hover-bg: #f9fafb;
            --tree-radius: 6px;
            position: relative;
            overflow: hidden; /* 防止樹狀線條跑出容器 */
            padding: 8px; /* 給予適當的內邊距 */
        }

        /* 深色模式支援 */
        .dark .folder-tree {
            --tree-line-color: #374151;
            --tree-hover-bg: #1f2937;
        }

        .folder-tree-item {
            position: relative;
        }

        .folder-expand-btn {
            transition: transform 0.2s ease;
        }

        .folder-expand-btn.expanded {
            transform: rotate(90deg);
        }

        .folder-actions {
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .folder-tree-item:hover .folder-actions {
            opacity: 1;
        }

        /* 深色模式下的其他元素調整 */
        .dark .bg-white {
            background-color: #1f2937 !important;
        }

        .dark .border-gray-200 {
            border-color: #374151 !important;
        }

        .dark .text-gray-900 {
            color: #f3f4f6 !important;
        }

        .dark .text-gray-500 {
            color: #9ca3af !important;
        }

        .dark .text-gray-700 {
            color: #d1d5db !important;
        }
        
        /* 強制顯示 input 邊框 */
        .fi-input {
            border: 1px solid #d1d5db !important;
            border-radius: 0.375rem !important;
        }
        
        .dark .fi-input {
            border-color: #4b5563 !important;
        }
        
        .fi-input:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 1px #3b82f6 !important;
        }
        
        .dark .fi-input:focus {
            border-color: #60a5fa !important;
            box-shadow: 0 0 0 1px #60a5fa !important;
        }
    </style>

    <div class="space-y-6">
        {{-- 頁面標題 --}}
        {{-- <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">資料夾管理</h1>
            <div class="text-sm text-gray-500">
                管理您的媒體檔案資料夾
            </div>
        </div> --}}

        {{-- 新增根資料夾 --}}
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

        {{-- 資料夾樹狀結構 --}}
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-medium mb-4">資料夾結構</h3>

            @if(empty($folders))
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-5l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                    <p>尚未建立任何資料夾</p>
                </div>
            @else
                <div class="folder-tree space-y-1">
                    {{-- //使用 component ，但反應較慢，更新不即時，要自己重整 --}}
                    {{-- @include('filament.pages.partials.folder-tree-component') --}}

                    {{-- //使用自訂的樣式，美觀低，但操作順手、更新即時 --}}
                    @foreach ($folders as $folder)
                        @include('filament.pages.partials.folder-item', ['folder' => $folder, 'level' => 0])
                    @endforeach
                </div>
            @endif
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
