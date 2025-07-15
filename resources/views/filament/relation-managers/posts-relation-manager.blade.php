<x-filament::resources.relation-manager
    :active-locale="$this->activeLocale ?? null"
    :active-tab="$this->activeTab ?? null"
    :can-create-any="$this->canCreate()"
    :can-delete-any="$this->canDeleteAny()"
    :has-header-actions="filled($this->getHeaderActions())"
    {{-- :heading="$this->getTitle()" --}}
    :owner-record="$this->getOwnerRecord()"
    :relationship="static::$relationship"
>
    <x-slot name="actions">
        @foreach ($this->getHeaderActions() as $action)
            {{ $action }}
        @endforeach
    </x-slot>

    <!-- Custom Tabs + Table Container -->
    <div class="filament-relation-manager-table-container">
        <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 rounded-xl overflow-hidden">

            <!-- Tabs Header -->
            <div class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                <div class="px-6">
                    <!-- Tab Navigation -->
                    <nav class="flex -mb-px" aria-label="Tabs">
                        @foreach($this->getTabs() as $tabKey => $tab)
                            <button
                                wire:click="$set('activeTab', '{{ $tabKey }}')"
                                type="button"
                                class="relative py-4 px-1 mr-8 text-sm font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2
                                    {{ $this->activeTab === $tabKey
                                        ? 'text-primary-600 dark:text-primary-400'
                                        : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300'
                                    }}"
                                wire:loading.attr="disabled"
                                wire:target="activeTab"
                            >
                                <div class="flex items-center gap-2">
                                    <span>{{ $tab->getLabel() }}</span>

                                    @if($tab->getBadge())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors
                                            {{ $tab->getBadgeColor() === 'primary' ? 'bg-primary-100 text-primary-800 dark:bg-primary-800 dark:text-primary-100' : '' }}
                                            {{ $tab->getBadgeColor() === 'success' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : '' }}
                                            {{ $tab->getBadgeColor() === 'warning' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' : '' }}
                                            {{ $tab->getBadgeColor() === 'danger' ? 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' : '' }}
                                            {{ $tab->getBadgeColor() === 'info' ? 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100' : '' }}
                                        ">
                                            {{ $tab->getBadge() }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Active Tab Indicator -->
                                @if($this->activeTab === $tabKey)
                                    <span class="absolute inset-x-0 bottom-0 h-0.5 bg-primary-600 dark:bg-primary-400 rounded-full transition-all duration-200"></span>
                                @endif
                            </button>
                        @endforeach
                    </nav>

                    <!-- Tab Actions (如果需要的話) -->
                    <div class="flex justify-between items-center mt-3 pb-3">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            共 {{ $this->getCurrentTabCount() }} 筆資料
                        </div>

                        <!-- Quick Actions -->
                        <div class="flex gap-2">
                            @if($this->activeTab === 'draft')
                                <button
                                    wire:click="$emit('openModal', 'bulk-publish')"
                                    class="text-xs px-3 py-1 bg-green-100 text-green-800 rounded-full hover:bg-green-200 transition-colors"
                                >
                                    批量發布
                                </button>
                            @endif

                            @if($this->activeTab === 'published')
                                <button
                                    wire:click="$emit('openModal', 'bulk-archive')"
                                    class="text-xs px-3 py-1 bg-gray-100 text-gray-800 rounded-full hover:bg-gray-200 transition-colors"
                                >
                                    批量封存
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loading Overlay -->
            <div wire:loading.delay wire:target="activeTab" class="absolute inset-0 bg-white/50 dark:bg-gray-900/50 z-20 flex items-center justify-center">
                <div class="flex items-center gap-3 px-4 py-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border">
                    <svg class="animate-spin h-5 w-5 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm text-gray-600 dark:text-gray-400">切換中...</span>
                </div>
            </div>

            <!-- Table Content -->
            <div class="filament-tables-container relative">
                {{ $this->table }}
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        /* 確保 table 與 tabs 完美連接 */
        .filament-relation-manager-table-container .filament-tables-container .filament-tables-table {
            border-top: none !important;
            border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
            box-shadow: none !important;
        }

        /* 移除 relation manager 預設的間距 */
        .filament-relation-manager-table-container .filament-tables-container {
            margin-top: 0 !important;
        }

        /* Tab 懸停效果 */
        .filament-relation-manager-table-container nav button:hover {
            background-color: rgba(0, 0, 0, 0.02);
            border-radius: 0.375rem 0.375rem 0 0;
        }

        .dark .filament-relation-manager-table-container nav button:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        /* 響應式調整 */
        @media (max-width: 768px) {
            .filament-relation-manager-table-container nav {
                overflow-x: auto;
                scrollbar-width: none;
                -ms-overflow-style: none;
                padding-bottom: 0.5rem;
            }

            .filament-relation-manager-table-container nav::-webkit-scrollbar {
                display: none;
            }

            .filament-relation-manager-table-container nav button {
                white-space: nowrap;
                margin-right: 1.5rem;
                flex-shrink: 0;
            }

            .filament-relation-manager-table-container .flex.justify-between {
                flex-direction: column;
                gap: 0.5rem;
                align-items: flex-start;
            }
        }

        /* 改善 loading 狀態的視覺效果 */
        .filament-relation-manager-table-container [wire\:loading\.delay] {
            backdrop-filter: blur(2px);
        }

        /* Tab indicator 動畫 */
        .filament-relation-manager-table-container nav button span:last-child {
            transform-origin: left;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: scaleX(0);
            }
            to {
                transform: scaleX(1);
            }
        }
    </style>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 平滑滾動效果
            window.addEventListener('tabChanged', function(event) {
                const container = document.querySelector('.filament-relation-manager-table-container');
                if (container) {
                    container.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start',
                        inline: 'nearest'
                    });
                }
            });

            // 鍵盤導航
            document.addEventListener('keydown', function(e) {
                const tabContainer = e.target.closest('nav[aria-label="Tabs"]');
                if (tabContainer) {
                    const tabs = Array.from(tabContainer.querySelectorAll('button'));
                    const currentIndex = tabs.findIndex(tab => tab === document.activeElement);

                    if (e.key === 'ArrowRight' && currentIndex < tabs.length - 1) {
                        e.preventDefault();
                        tabs[currentIndex + 1].focus();
                    } else if (e.key === 'ArrowLeft' && currentIndex > 0) {
                        e.preventDefault();
                        tabs[currentIndex - 1].focus();
                    } else if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        e.target.click();
                    }
                }
            });

            // 觸控支援（行動裝置）
            let touchStartX = 0;
            let touchEndX = 0;

            const tabContainer = document.querySelector('nav[aria-label="Tabs"]');
            if (tabContainer) {
                tabContainer.addEventListener('touchstart', function(e) {
                    touchStartX = e.changedTouches[0].screenX;
                });

                tabContainer.addEventListener('touchend', function(e) {
                    touchEndX = e.changedTouches[0].screenX;
                    handleSwipe();
                });

                function handleSwipe() {
                    const swipeThreshold = 50;
                    const diff = touchStartX - touchEndX;

                    if (Math.abs(diff) > swipeThreshold) {
                        const tabs = Array.from(tabContainer.querySelectorAll('button'));
                        const activeTab = tabContainer.querySelector('button[class*="text-primary"]');
                        const currentIndex = tabs.indexOf(activeTab);

                        if (diff > 0 && currentIndex < tabs.length - 1) {
                            // 向左滑動，切換到下一個 tab
                            tabs[currentIndex + 1].click();
                        } else if (diff < 0 && currentIndex > 0) {
                            // 向右滑動，切換到上一個 tab
                            tabs[currentIndex - 1].click();
                        }
                    }
                }
            }
        });
    </script>
</x-filament::resources.relation-manager>
