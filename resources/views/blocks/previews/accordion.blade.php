<div x-data="{
    openItems: [],
    toggleItem(id) {
        const index = this.openItems.indexOf(id);
        if (index > -1) {
            this.openItems.splice(index, 1);
        } else {
            this.openItems.push(id);
        }
    },
    isOpen(id) {
        return this.openItems.includes(id);
    }
}" class="space-y-2">
    @foreach ($accordions as $key => $accordion)
        <div class="border border-gray-200 rounded-lg bg-white shadow-sm">
            <button
                @click="toggleItem('accordion-{{ $key }}')"
                class="w-full px-4 py-3 text-left flex items-center justify-between hover:bg-gray-50 transition-colors duration-200"
                :class="{ 'bg-gray-50': isOpen('accordion-{{ $key }}') }"
            >
                <span class="font-medium text-gray-900">{{ $accordion['title'] }}</span>
                <svg
                    class="w-5 h-5 text-gray-500 transition-transform duration-200"
                    :class="{ 'rotate-180': isOpen('accordion-{{ $key }}') }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div
                x-show="isOpen('accordion-{{ $key }}')"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-2"
                class="px-4 pb-4"
            >
                <div class="pt-2 text-gray-700">
                    {!! nl2br(e($accordion['contact'])) !!}
                </div>
            </div>
        </div>
    @endforeach
</div>
