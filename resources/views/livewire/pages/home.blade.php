<div class="p-6">
    @if ( $this->articles->count() > 0 )
        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
                <h2 class="text-2xl font-boad md:text-4xl md:leading-tight dark:text-white">
                    Latest Articles
                </h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ( $this->articles as $article )
                    <livewire:components.article-card :article="$article" :key="$article->id" />
                @endforeach
            </div>
        </div>

    @endif


    If you look to others for fulfillment, you will never truly be fulfilled.
    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})

    <x-mary-progress value="12" max="100" class="progress-warning h-3" />



    <!-- theme switcher at home.blade.php -->
    <button onclick="toggleTheme()"
        class="p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
        <span class="dark:hidden">🌙</span>
        <span class="hidden dark:inline">☀️</span>
    </button>


    <x-mary-button>
        Inbox
        <x-mary-badge value="+99" class="badge-neutral badge-sm" />
    </x-mary-button>

    <x-mary-button class="indicator">
        Inbox
        <x-mary-badge value="7" class="badge-secondary badge-sm indicator-item" />
    </x-mary-button>



</div>
