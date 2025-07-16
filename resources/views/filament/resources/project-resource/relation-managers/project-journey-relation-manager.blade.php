<div class="projecttabs">
    <x-filament::tabs>
        @foreach($this->getTabs() as $tabKey => $tab)
            <x-filament::tabs.item
                :active="$activeTab === $tabKey"
                wire:click="setActiveTab('{{ $tabKey }}')"
                :icon="$tab->getIcon()"
            >
                {{ $tab->getLabel() }}
            </x-filament::tabs.item>
        @endforeach
    </x-filament::tabs>

    {{ $this->table }}


    <style>
        .projecttabs .fi-tabs{
            padding: 0.75rem 1rem;
            border-radius: 0.75rem 0.75rem 0 0;
        }
        .fi-ta-ctn{
            border-radius: 0 !important;
        }
    </style>
</div>
