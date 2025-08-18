<li class="ml-{{ $level * 4 }} flex items-center space-x-2">
    <span>📁</span>
    <span>{{ $folder['name'] }}</span>

    <!-- 新增子資料夾 -->
    <button wire:click="openSubFolderModal('{{ $folder['path'] }}')" class="text-blue-500 text-xs" type="button">新增子資料夾</button>

    <!-- 刪除資料夾 -->
    <x-filament::button wire:click="deleteFolder('{{ $folder['path'] }}')"
         color="danger" size="sm">
        刪除
    </x-filament::button>

    @if ($confirmingDeleteFolder === $folder['path'])
        <div class="fixed inset-0 bg-gray-800/75 flex items-center justify-center z-50" x-data
        x-show="$wire.delSubFolderModal">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-lg font-semibold mb-4">資料夾內還有資料，確定要刪除嗎？</h2>
                <div class="mt-1 space-x-2">
                    <x-filament::button wire:click="forceDeleteFolder('{{ $folder['path'] }}')" color="danger" size="xs">
                        確定刪除
                    </x-filament::button>
                    <x-filament::button wire:click="$set('confirmingDeleteFolder', null)" size="xs">
                        取消
                    </x-filament::button>
                </div>
            </div>
        </div>
    @endif

    @if (!empty($folder['children']))
        <ul class="mt-2">
            @foreach ($folder['children'] as $child)
                @include('filament.pages.partials.folder-item', ['folder' => $child, 'level' => $level + 1])
            @endforeach
        </ul>
    @endif

</li>




<li class="block relative" style="padding-left: calc(2 * var(--spacing) - var(--radius) - 2px);">
    <details {{ $level === 0 ? 'open' : '' }}>
        <summary class="flex items-center space-x-2" style="">
            <span>📁</span>
            <span>{{ $folder['name'] }}</span>

            <!-- 新增子資料夾 -->
            <button wire:click="openSubFolderModal('{{ $folder['path'] }}')" class="text-blue-500 text-xs ml-2"
                type="button">
                新增子資料夾
            </button>

            <!-- 刪除資料夾 -->
            <x-filament::button wire:click="deleteFolder('{{ $folder['path'] }}')" color="danger" size="sm">
                刪除
            </x-filament::button>
        </summary>

        <!-- 刪除確認 modal -->
        @if ($confirmingDeleteFolder === $folder['path'])
            <div class="fixed inset-0 bg-gray-800/75 flex items-center justify-center z-50" x-data
                x-show="$wire.delSubFolderModal">
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                    <h2 class="text-lg font-semibold mb-4">資料夾內還有資料，確定要刪除嗎？</h2>
                    <div class="mt-1 space-x-2">
                        <x-filament::button wire:click="forceDeleteFolder('{{ $folder['path'] }}')" color="danger"
                            size="xs">
                            確定刪除
                        </x-filament::button>
                        <x-filament::button wire:click="$set('confirmingDeleteFolder', null)" size="xs">
                            取消
                        </x-filament::button>
                    </div>
                </div>
            </div>
        @endif

        <!-- 子資料夾 -->
        @if (!empty($folder['children']))
            <ul class="pl-0" style="margin-left: calc(var(--radius) - var(--spacing));">
                @foreach ($folder['children'] as $child)
                    @include('filament.pages.partials.folder-item', ['folder' => $child, 'level' => $level + 1])
                @endforeach
            </ul>
        @endif
    </details>
</li>
