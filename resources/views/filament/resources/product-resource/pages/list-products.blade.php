<x-filament::page>
    <div class="filament-resources-list-records-page">
        {{ $this->getHeader() }}

        <div class="filament-resources-table-container">
            <!-- 自訂的 tabs，與 table 連結 -->
            <div class="rounded-xl overflow-hidden">
                <div class="bg-white dark:bg-gray-900 px-4 py-3 border-b border-gray-200 dark:border-white/10">
                    <nav class="flex gap-1 ">
                        @foreach($this->getTabs() as $tabKey => $tab)
                            <button
                                wire:click="setActiveTab('{{ $tabKey }}')"
                                type="button"
                                {{-- class="fi-tabs-item group flex items-center justify-center gap-x-2 whitespace-nowrap rounded-lg px-3 py-2 text-sm font-medium outline-none transition duration-75 fi-active fi-tabs-item-active bg-gray-50 dark:bg-white/5 whitespace-nowrap --}}
                                class="flex gap-1 items-center py-2 px-4 border-b-2 font-medium text-sm rounded-xl transition hover:bg-gray-50 hover:dark:bg-white/5
                                {{-- class="flex items-center gap-0 py-2 px-3 border-b-2 font-medium text-sm rounded transition --}}
                                    {{ $this->activeTab === $tabKey
                                        ? 'border-none transition duration-75 text-primary-600 dark:text-primary-400 bg-gray-50 dark:bg-white/5'
                                        : 'border-none transition duration-75 text-gray-500 bg-none dark:bg-none'
                                    }}"
                            >
                                @if($tab->getIcon())
                                    <x-dynamic-component :component="$tab->getIcon()" class="w-5 h-5 mr-1" />
                                @endif
                                {{ $tab->getLabel() }}
                            </button>
                        @endforeach
                    </nav>
                </div>

                <!-- Table 直接連接在 tabs 下方 -->
                <div class="border-none overflow-hidden">
                    {{ $this->table }}
                </div>
            </div>
        </div>
    </div>


    <style>
        .fi-ta-ctn{
            border-radius: 0 !important;
        }
    </style>

</x-filament::page>
