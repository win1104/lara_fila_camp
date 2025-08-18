{{-- 改良版的樹狀結構展示 --}}
<div class="folder-tree-item" x-data="{ expanded: true }">
    <div class="flex items-center py-2 px-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 group relative">
        {{-- 樹狀結構線條 --}}
        @if($level > 0)
            <div class="absolute left-0 top-0 h-full w-px bg-gray-200 dark:bg-gray-600" style="left: {{ ($level - 1) * 24 + 12 }}px;"></div>
            <div class="absolute top-1/2 w-3 h-px bg-gray-200 dark:bg-gray-600" style="left: {{ ($level - 1) * 24 + 12 }}px;"></div>
        @endif

        {{-- 縮排和展開/收縮按鈕 --}}
        <div class="flex items-center" style="margin-left: {{ $level * 24 }}px;">
            @if(!empty($folder['children']))
                <button @click="expanded = !expanded" class="w-4 h-4 flex items-center justify-center rounded hover:bg-gray-200 dark:hover:bg-gray-700 mr-1">
                    <svg class="w-3 h-3 transition-transform text-gray-600 dark:text-gray-300" :class="{ 'rotate-90': expanded }" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            @else
                <div class="w-4 h-4 mr-1"></div>
            @endif

            {{-- 資料夾圖示和名稱 --}}
            <div class="flex items-center space-x-2 flex-1
                        @if(!empty($folder['children'])) cursor-pointer hover:text-blue-600 dark:hover:text-blue-400 @endif
                        transition-colors duration-200"
                @if(!empty($folder['children']))
                    @click="expanded = !expanded"
                @endif>
                <svg class="w-5 h-5 text-blue-500 dark:text-blue-400
                            @if(!empty($folder['children'])) group-hover:text-blue-600 dark:group-hover:text-blue-300 @endif
                            transition-colors duration-200"
                        fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                </svg>
                <span class="text-sm font-medium text-gray-900 dark:text-gray-100 select-none transition-colors duration-200 pr-4">{{ $folder['name'] }}</span>
            </div>

            {{-- 動作按鈕 --}}
            <div class="flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                <button wire:click="openSubFolderModal('{{ $folder['path'] }}')"
                        class="p-1 rounded hover:bg-blue-100 dark:hover:bg-blue-900 text-blue-600 dark:text-blue-400"
                        title="新增子資料夾">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </button>

                <button wire:click="renamePrompt('{{ $folder['path'] }}')"
                        class="p-1 rounded hover:bg-yellow-100 dark:hover:bg-yellow-900 text-yellow-600 dark:text-yellow-400"
                        title="重新命名">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </button>

                <button wire:click="deleteFolder('{{ $folder['path'] }}')"
                        class="p-1 rounded hover:bg-red-100 dark:hover:bg-red-900 text-red-600 dark:text-red-400"
                        title="刪除資料夾">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- 子資料夾 --}}
    @if(!empty($folder['children']))
        <div x-show="expanded" x-transition:enter="transition-all duration-200" x-transition:leave="transition-all duration-200" class="ml-6">
            @foreach($folder['children'] as $child)
                @include('filament.pages.partials.folder-item', ['folder' => $child, 'level' => $level + 1])
            @endforeach
        </div>
    @endif

    {{-- 刪除確認 Modal --}}
    @if($confirmingDeleteFolder === $folder['path'])
        <div class="fixed inset-0 bg-gray-800/75 dark:bg-gray-900/80 flex items-center justify-center z-50" x-data x-show="$wire.delSubFolderModal">
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
                    <x-filament::button wire:click="forceDeleteFolder('{{ $folder['path'] }}')" color="danger">
                        確定刪除
                    </x-filament::button>
                </div>
            </div>
        </div>
    @endif
</div>
