{{-- This is a new partial for the Livewire component --}}
<div class="folder-tree-item ml-{{ $level * 4 }}" x-data="{
    expanded: {{ $level === 0 ? 'true' : 'false' }},
    init() {
        this.$wire.on('expand-all-folders', () => {
            this.expanded = true;
        });
        this.$wire.on('collapse-all-folders', () => {
            this.expanded = false;
        });
    }
}">
    <div
        @class([
    'flex items-center py-2 px-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group relative cursor-pointer',
    'bg-gray-100 dark:bg-gray-700' => $selectedDirectory === $folder['path'],
])
        wire:click="selectDirectory('{{ $folder['path'] }}')"
    >
    @if($level > 0)
        <div class="absolute left-0 top-0 h-full w-px bg-gray-200 dark:bg-gray-600"
            style="left: {{ ($level - 1) * 12 + 12 }}px;"></div>
        <div class="absolute top-1/2 w-3 h-px bg-gray-200 dark:bg-gray-600" style="left: {{ ($level - 1) * 12 + 12 }}px;"></div>
    @endif
        <div class="flex items-center" style="margin-left: {{ $level * 12 }}px;"> {{-- Added flex-1 here --}}
            @if(!empty($folder['children']))
                <button @click.stop="expanded = !expanded" class="w-6 h-6 flex items-center justify-center rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 mr-1">
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-90': expanded }" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            @else
                <div class="w-6 h-6 mr-1"></div> {{-- Placeholder for alignment --}}
            @endif

            <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
            </svg>
            <span class="text-sm font-medium text-gray-900 dark:text-gray-100 select-none">{{ $folder['name'] }}</span>
        </div>
        {{-- Action buttons --}}
        <div class="flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
            <button wire:click.stop="openSubFolderModal('{{ $folder['path'] }}')"
                    class="p-1 rounded hover:bg-blue-100 dark:hover:bg-blue-900 text-blue-600 dark:text-blue-400"
                    title="新增子資料夾">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </button>

            <button wire:click.stop="renamePrompt('{{ $folder['path'] }}')"
                    class="p-1 rounded hover:bg-yellow-100 dark:hover:bg-yellow-900 text-yellow-600 dark:text-yellow-400"
                    title="重新命名">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </button>

            <button wire:click.stop="deleteFolder('{{ $folder['path'] }}')"
                    class="p-1 rounded hover:bg-red-100 dark:hover:bg-red-900 text-red-600 dark:text-red-400"
                    title="刪除資料夾">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
    </div>

    @if(!empty($folder['children']))
        <div x-show="expanded" x-collapse class="mt-1">
            @foreach($folder['children'] as $child)
                @include('livewire.partials.folder-item', ['folder' => $child, 'level' => $level + 1, 'selectedDirectory' => $selectedDirectory])
            @endforeach
        </div>
    @endif
</div>
