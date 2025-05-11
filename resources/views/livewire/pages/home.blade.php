<div class="p-6">
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
