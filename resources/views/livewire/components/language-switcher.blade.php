<div class="fi-dropdown">
    <x-filament::dropdown>
        <x-slot name="trigger">
            <x-filament::icon-button
                icon="heroicon-o-globe-alt"
                tooltip="切換語系 / Switch Language"
                class="fi-topbar-item"
            />

            {{-- <x-filament::icon-button tooltip="切換語系 / Switch Language" class="fi-topbar-item">
                <x-heroicon-o-globe-alt class="h-6 w-6" />
            </x-filament::icon-button> --}}


        </x-slot>

        <x-filament::dropdown.list>
            @foreach($this->getAvailableLocales() as $localeCode => $localeName)
                <x-filament::dropdown.list.item
                    onclick="switchLanguageInstant('{{ $localeCode }}')"
                    :active="$this->getCurrentLocale() === $localeCode"
                    style="cursor: pointer;"
                >
                    <div class="flex items-center gap-2">
                        <x-filament::icon icon="heroicon-o-language" class="h-4 w-4" />
                        {{ $localeName }}
                        @if($this->getCurrentLocale() === $localeCode)
                            <x-filament::icon icon="heroicon-o-check" class="h-4 w-4 text-success-500 ml-auto" />
                        @endif
                    </div>
                </x-filament::dropdown.list.item>
            @endforeach
        </x-filament::dropdown.list>
    </x-filament::dropdown>
</div>

<script>
function switchLanguageInstant(locale) {
    const currentUrl = window.location.href;
    const currentPath = window.location.pathname;

    // 分析當前路徑
    const pathSegments = currentPath.split('/').filter(segment => segment !== '');

    let newPath;

    // 檢查是否已有語系前綴
    if (pathSegments.length >= 2 && ['tw', 'en'].includes(pathSegments[0]) && pathSegments[1] === 'admin') {
        // 替換現有的語系前綴
        pathSegments[0] = locale;
        newPath = '/' + pathSegments.join('/');
    } else if (pathSegments.length >= 1 && pathSegments[0] === 'admin') {
        // 添加語系前綴到 admin 前
        pathSegments.unshift(locale);
        newPath = '/' + pathSegments.join('/');
    } else {
        // 預設回到 admin 首頁
        newPath = '/' + locale + '/admin';
    }

    // 保持查詢參數和錨點
    const search = window.location.search;
    const hash = window.location.hash;

    // 即時跳轉
    window.location.href = newPath + search + hash;
}
</script>
