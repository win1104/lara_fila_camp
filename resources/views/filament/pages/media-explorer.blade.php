<x-filament-panels::page>
    <div class="flex flex-col lg:flex-row gap-4">
        {{-- Left Column --}}
        <div class="lg:w-1/4 flex-shrink-0">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-4 space-y-6 h-full lg:h-[75vh] overflow-y-auto">
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

                @livewire('folder-tree')
            </div>
        </div>

        {{-- Right Column --}}
        <div class="flex-1">
            <div class="flex justify-end mb-4">
                <x-filament::button wire:click="toggleLayout">
                    {{ $this->layoutView === 'grid' ? '列表視圖' : '網格視圖' }}
                </x-filament::button>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-4 lg:h-[75vh] overflow-y-auto">
                {{ $this->table }}
            </div>
        </div>
    </div>
</x-filament-panels::page>
