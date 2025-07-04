<li class="ml-{{ $level * 4 }} flex items-center space-x-2">
    <span>📁</span>
    <span>{{ $folder['name'] }}</span>

    <!-- 新增子資料夾 -->
    {{-- <button wire:click="prepareCreateFolder('{{ $folder['path'] }}')" class="text-blue-500 text-xs">新增子資料夾</button> --}}
    {{-- <button wire:click="createSubFolder('{{ $folder['path'] }}')" class="text-blue-500 text-xs">新增子資料夾</button> --}}
    <button wire:click="openSubFolderModal('{{ $folder['path'] }}')" class="text-blue-500 text-xs" type="button">新增子資料夾</button>
    {{-- <input wire:model.defer="subFolderNames.{{ $folder['path'] }}" placeholder="輸入子資料夾名稱" /> --}}

    <!-- 刪除資料夾 -->
    <x-filament::button wire:click="deleteFolder('{{ $folder['path'] }}')"
         color="danger" size="sm">
        刪除
    </x-filament::button>

    {{-- @if ($confirmingFolder === $folder)
        <div class="text-sm mt-2 text-red-500">
            確定要刪除「{{ $folder }}」嗎？<br>
            <x-filament::button wire:click="deleteFolder('{{ $folder }}')" color="danger" size="xs">確認刪除</x-filament::button>
            <x-filament::button wire:click="$set('confirmingFolder', '')" color="gray" size="xs">取消</x-filament::button>
        </div>
    @endif --}}
    {{-- <div class="fixed inset-0 bg-gray-800/75 flex items-center justify-center z-50" x-data
        x-show="$wire.showingSubFolderModal">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4">新增子資料夾</h2>

            <x-filament::input wire:model.defer="subFolderName" placeholder="輸入子資料夾名稱" class="w-full mb-4" />

            <div class="flex justify-end gap-2">
                <x-filament::button wire:click="createSubFolder" type="button">確定</x-filament::button>
                <x-filament::button wire:click="closeSubFolderModal" color="gray" type="button">取消</x-filament::button>
            </div>
        </div>
    </div> --}}
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

    {{-- @if ($confirmingDeleteFolder === $folder['path'])
        <div class="mt-2 text-red-600 text-sm">
            此資料夾非空，確定要一併刪除裡面的內容？
            <div class="mt-1 space-x-2">
                <x-filament::button wire:click="forceDeleteFolder('{{ $folder['path'] }}')" color="danger" size="xs">
                    確定刪除
                </x-filament::button>
                <x-filament::button wire:click="$set('confirmingDeleteFolder', null)" size="xs">
                    取消
                </x-filament::button>
            </div>
        </div>
    @endif --}}

    @if (!empty($folder['children']))
        <ul class="mt-2">
            @foreach ($folder['children'] as $child)
                @include('filament.pages.partials.folder-item', ['folder' => $child, 'level' => $level + 1])
            @endforeach
        </ul>
    @endif

    {{-- @if ($parentFolder === $folder['path'])
        <div class="mt-4">
            <x-filament::input wire:model.defer="subFolderNames.{{ $folder['path'] }}" placeholder="輸入子資料夾名稱" />
            <x-filament::button wire:click="createSubFolder('{{ $folder['path'] }}')">建立於 {{ $parentFolder }}</x-filament::button>
        </div>
    @endif --}}
</li>