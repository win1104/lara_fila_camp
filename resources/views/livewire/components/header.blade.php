<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-18">


                <!-- maryUI -->
                <div class="navbar bg-base-100 ">

                    <div class="navbar-start">
                        <!-- Logo -->
                        <div class="shrink-0 items-center">
                            <a href="{{ route('home') }}">
                                <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                                {{-- <img src="/storage/bright_future_logo.jpg" alt="logo" width="50" height="50"/> --}}
                            </a>
                        </div>
                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('chirps.index')" :active="request()->routeIs('chirps.index')">
                                {{ __('Chirps') }}
                            </x-nav-link>
                            <x-nav-link :href="route('note.index')" :active="request()->routeIs('note.index')">
                                {{ __('Note') }}
                            </x-nav-link>
                            <x-nav-link :href="route('openai.index')" :active="request()->routeIs('openai.index')">
                                {{ __('OPEN AI') }}
                            </x-nav-link>
                            <x-nav-link :href="route('gpt.index')" :active="request()->routeIs('gpt.index')">
                                {{ __('Chat GTP') }}
                            </x-nav-link>
                            <x-nav-link :href="route('mobile')" :active="request()->routeIs('assistant.index')">
                                {{ __('Mobile') }}
                            </x-nav-link>
                        </div>
                    </div>


                    <div class="navbar-end">
                        <div class="">

                            {{-- <a class="btn btn-ghost text-xl">
                                {{ config("app.name")}}
                            </a> --}}

                            <!-- daisyui modal -->
                            <button class="btn btn-ghost text-xl" onclick="my_modal_1.showModal()"> {{ config("app.name")}}</button>
                            <dialog id="my_modal_1" class="modal">
                                <div class="modal-box">
                                    <h3 class="text-lg font-bold">Hello!</h3>
                                    <p class="py-4">Press ESC key or click the button below to close</p>
                                    <div class="modal-action">
                                    <form method="dialog">
                                        <!-- if there is a button in form, it will close the modal -->
                                        <button class="btn">Close</button>
                                    </form>
                                    </div>
                                </div>
                            </dialog>

                            <x-mary-button class="indicator">
                                Inbox
                                <x-mary-badge value="7" class="badge-secondary badge-sm indicator-item" />
                            </x-mary-button>

                            <!-- theme switcher at home.blade.php -->
                            <button onclick="toggleTheme()"
                                class="p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
                                <span class="dark:hidden">🌙</span>
                                <span class="hidden dark:inline">☀️</span>
                            </button>


                            <div class="dropdown dropdown-end">
                                <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                                    <div class="indicator">
                                        <x-mary-icon name="o-shopping-cart"/>
                                        <span class="badge badge-sm indicator-item">8</span>
                                    </div>
                                </div>
                                <div
                                    tabindex="0"
                                    class="card card-compact dropdown-content bg-base-100 z-1 mt-3 w-52 shadow">
                                    <div class="card-body">
                                        <span class="text-lg font-bold">8 Items</span>
                                        <span class="text-info">Subtotal: $999</span>
                                        <div class="card-actions">
                                            <button class="btn btn-primary btn-block">View cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- user dropdown -->
                            @guest
                                <x-mary-button icon="o-user" class="btn-circle" link="{{ route('login') }}"/>
                            @endguest
                            @auth
                                <div class="dropdown dropdown-end">
                                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                                        <div class="w-10 rounded-full">
                                            <img
                                                alt="{{ auth()->user()->name }} profile picture"
                                                src="{{ './storage/'.auth()->user()->avatar }}" />
                                        </div>
                                    </div>
                                    <ul
                                        tabindex="0"
                                        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                                        <li>
                                            <a wire:navigate href="{{ route('profile.edit') }}">
                                                Profile
                                                <span class="badge">New</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/admin">
                                                Settings
                                            </a>
                                        </li>
                                        <li>
                                            <a>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button type="submit">Logout</button>
                                                </form>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            @endauth
                        </div>
                    </div>

                </div>






            <!-- Settings Dropdown -->
            {{-- <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div> --}}

            <!-- Hamburger -->
            {{-- <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div> --}}
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    {{-- <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('chirps.index')" :active="request()->routeIs('chirps.index')">
                {{ __('Chirps') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('note.index')" :active="request()->routeIs('note.index')">
                {{ __('Note') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('chirps.index')" :active="request()->routeIs('chirps.index')">
                {{ __('OPEN AI') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div> --}}
</nav>
