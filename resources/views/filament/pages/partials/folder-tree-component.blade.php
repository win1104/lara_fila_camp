{{-- 修正版的 Alpine.js 樹狀結構組件 --}}
<div x-data="{
    folders: @js($folders),
    expandedFolders: {}
}" class="folder-tree-container">

    {{-- 定義遞迴樹狀結構模板 --}}
    <template x-for="(folder, index) in folders" :key="folder.path">
        <div class="folder-item" x-data="{
            expanded: true,
            toggleExpanded() { this.expanded = !this.expanded }
        }">
            <div class="flex items-center py-2 px-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 group relative transition-all duration-200">
                {{-- 展開/收合按鈕 --}}
                <button
                    x-show="folder.children && folder.children.length > 0"
                    @click="toggleExpanded()"
                    class="w-4 h-4 flex items-center justify-center rounded hover:bg-gray-200 dark:hover:bg-gray-700 mr-1 transition-colors"
                >
                    <svg
                        class="w-3 h-3 transition-transform duration-200 text-gray-600 dark:text-gray-300"
                        :class="{ 'rotate-90': expanded }"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div x-show="!folder.children || folder.children.length === 0" class="w-4 h-4 mr-1"></div>

                {{-- 資料夾圖示和名稱（可點擊區域） --}}
                <div class="flex items-center flex-1 cursor-pointer transition-colors duration-200"
                     :class="{ 'hover:text-blue-600 dark:hover:text-blue-400': folder.children && folder.children.length > 0 }"
                     @click="folder.children && folder.children.length > 0 ? toggleExpanded() : null">
                    <div class="w-5 h-5 mr-2">
                        <svg class="w-full h-full text-blue-500 dark:text-blue-400 transition-colors duration-200"
                             :class="{ 'group-hover:text-blue-600 dark:group-hover:text-blue-300': folder.children && folder.children.length > 0 }"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100 select-none transition-colors duration-200" x-text="folder.name"></span>
                </div>

                {{-- 操作按鈕 --}}
                <div class="flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button
                        @click="$wire.openSubFolderModal(folder.path)"
                        class="p-1 rounded hover:bg-blue-100 dark:hover:bg-blue-900 text-blue-600 dark:text-blue-400 transition-colors"
                        title="新增子資料夾"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </button>

                    <button
                        @click="$wire.renamePrompt(folder.path)"
                        class="p-1 rounded hover:bg-yellow-100 dark:hover:bg-yellow-900 text-yellow-600 dark:text-yellow-400 transition-colors"
                        title="重新命名"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>

                    <button
                        @click="$wire.deleteFolder(folder.path)"
                        class="p-1 rounded hover:bg-red-100 dark:hover:bg-red-900 text-red-600 dark:text-red-400 transition-colors"
                        title="刪除資料夾"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- 子資料夾 --}}
            <div
                x-show="expanded && folder.children && folder.children.length > 0"
                x-transition:enter="transition-all duration-200"
                x-transition:leave="transition-all duration-200"
                class="ml-6"
            >
                <template x-for="child in folder.children" :key="child.path">
                    <div x-data="{
                        expanded: false,
                        toggleExpanded() { this.expanded = !this.expanded }
                    }" class="folder-item">
                        <div class="flex items-center py-2 px-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 group relative transition-all duration-200">
                            {{-- 這裡需要遞迴，但 Alpine.js template 不支持直接遞迴 --}}
                            {{-- 子資料夾的結構 --}}
                            <button
                                x-show="child.children && child.children.length > 0"
                                @click="toggleExpanded()"
                                class="w-4 h-4 flex items-center justify-center rounded hover:bg-gray-200 dark:hover:bg-gray-700 mr-1 transition-colors"
                            >
                                <svg
                                    class="w-3 h-3 transition-transform duration-200 text-gray-600 dark:text-gray-300"
                                    :class="{ 'rotate-90': expanded }"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div x-show="!child.children || child.children.length === 0" class="w-4 h-4 mr-1"></div>

                            {{-- 子資料夾圖示和名稱（可點擊區域） --}}
                            <div class="flex items-center flex-1 cursor-pointer transition-colors duration-200"
                                 :class="{ 'hover:text-blue-600 dark:hover:text-blue-400': child.children && child.children.length > 0 }"
                                 @click="child.children && child.children.length > 0 ? toggleExpanded() : null">
                                <div class="w-5 h-5 mr-2">
                                    <svg class="w-full h-full text-blue-500 dark:text-blue-400 transition-colors duration-200"
                                         :class="{ 'group-hover:text-blue-600 dark:group-hover:text-blue-300': child.children && child.children.length > 0 }"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100 select-none transition-colors duration-200" x-text="child.name"></span>
                            </div>

                            <div class="flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button
                                    @click="$wire.openSubFolderModal(child.path)"
                                    class="p-1 rounded hover:bg-blue-100 dark:hover:bg-blue-900 text-blue-600 dark:text-blue-400 transition-colors"
                                    title="新增子資料夾"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>

                                <button
                                    @click="$wire.renamePrompt(child.path)"
                                    class="p-1 rounded hover:bg-yellow-100 dark:hover:bg-yellow-900 text-yellow-600 dark:text-yellow-400 transition-colors"
                                    title="重新命名"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>

                                <button
                                    @click="$wire.deleteFolder(child.path)"
                                    class="p-1 rounded hover:bg-red-100 dark:hover:bg-red-900 text-red-600 dark:text-red-400 transition-colors"
                                    title="刪除資料夾"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- 注意：Alpine.js 不支援深度遞迴，所以這裡只能處理兩層 --}}
                        <div
                            x-show="expanded && child.children && child.children.length > 0"
                            x-transition:enter="transition-all duration-200"
                            x-transition:leave="transition-all duration-200"
                            class="ml-6"
                        >
                            <template x-for="grandchild in child.children" :key="grandchild.path">
                                <div class="flex items-center py-2 px-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 group relative transition-all duration-200">
                                    <div class="w-4 h-4 mr-1"></div>
                                    {{-- 第三層資料夾圖示和名稱（可點擊但無展開功能，因為已到最深層） --}}
                                    <div class="flex items-center flex-1">
                                        <div class="w-5 h-5 mr-2">
                                            <svg class="w-full h-full text-blue-500 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100 select-none" x-text="grandchild.name"></span>
                                    </div>
                                    <div class="flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button
                                            @click="$wire.openSubFolderModal(grandchild.path)"
                                            class="p-1 rounded hover:bg-blue-100 dark:hover:bg-blue-900 text-blue-600 dark:text-blue-400 transition-colors"
                                            title="新增子資料夾"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                        <button
                                            @click="$wire.renamePrompt(grandchild.path)"
                                            class="p-1 rounded hover:bg-yellow-100 dark:hover:bg-yellow-900 text-yellow-600 dark:text-yellow-400 transition-colors"
                                            title="重新命名"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button
                                            @click="$wire.deleteFolder(grandchild.path)"
                                            class="p-1 rounded hover:bg-red-100 dark:hover:bg-red-900 text-red-600 dark:text-red-400 transition-colors"
                                            title="刪除資料夾"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </template>
</div>
