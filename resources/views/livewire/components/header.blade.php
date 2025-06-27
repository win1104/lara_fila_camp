<nav x-data="{ open: false }" class="bg-white border-b border-gray-100" wire:id="header-component">
    <!-- Primary Navigation Menu -->
    <div class="max-w-[1632px] mx-auto">
        <div class="h-16 px-8 lg:px-32">


            <!-- maryUI -->
            <div class="navbar bg-base-100 relative">

                <!-- Logo -->
                <div class="shrink-0 items-center">
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                        {{-- <img src="/storage/bright_future_logo.jpg" alt="logo" width="50" height="50"/> --}}
                    </a>
                </div>




                <div class="navbar-start">
                    <div class="navbar-center hidden lg:flex relative">

                        @if ($menus->count() > 0)
                            @foreach ($menus as $menu)
                                @if ($menu->type === 'posts' || $menu->type === 'lists' || $menu->type === 'grid' || $menu->type === 'timeline' || $menu->type === 'tabs' || $menu->type === 'collapses')
                                    @if($menu->children->count() > 0)
                                        <div class="dropdown dropdown-hover">
                                            <div tabindex="0" role="button" class="btn btn-ghost px-4 text-base">{{ $menu->title }}</div>
                                            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-md rounded-lg bg-base-100 w-52 border-gray-200">
                                                @foreach($menu->children->where('display', 1) as $child)
                                                    <li>
                                                        <a href="{{ route('post.show', ['locale' => app()->getLocale(), 'type' => $menu->type, 'menu' => $menu->slug]) }}">
                                                            {!! $child->title !!}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <x-mary-button link="{{ route('post.show', ['locale' => app()->getLocale(), 'type' => $menu->type, 'menu' => $menu->slug]) }}" class="btn-ghost text-base">
                                            {!! $menu->title !!}
                                        </x-mary-button>
                                    @endif

                                @elseif($menu->type == 'products')
                                    @if($menu->children->count() > 0)
                                        <div class="dropdown dropdown-hover">
                                            <div tabindex="0" role="button" class="btn btn-ghost px-4 text-base">{{ $menu->title }}</div>
                                            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-md rounded-lg bg-base-100 w-52 border-gray-200">
                                                @foreach($menu->children->where('display', 1) as $child)
                                                    <li>
                                                        <a href="{{ route('post.show', ['locale' => app()->getLocale(), 'type' => $menu->type, 'menu' => $menu->slug]) }}">
                                                            {!! $child->title !!}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <x-mary-button link="{{ route('product.show', ['locale' => app()->getLocale()]) }}" class="btn-ghost text-base">
                                            {!! $menu->title !!}
                                        </x-mary-button>
                                    @endif



                                @endif

                            @endforeach



                            <x-mary-button link="{{ route('openai.index', ['locale' => app()->getLocale()]) }}" class="btn-ghost text-base">
                                {{ __('OPEN AI') }}
                            </x-mary-button>
                            <x-mary-button link="{{ route('gpt.index', ['locale' => app()->getLocale()]) }}" class="btn-ghost text-base">
                                {{ __('Chat GTP') }}
                            </x-mary-button>
                            <x-mary-button link="{{ route('mobile.index', ['locale' => app()->getLocale()]) }}" class="btn-ghost text-base">
                                {{ __('Chat Bot') }}
                            </x-mary-button>

                        @endif
                    </div>
                </div>









                        {{-- <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link> --}}
                        {{-- <x-nav-link :href="route('chirps.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('chirps.index')">
                            {{ __('Chirps') }}
                        </x-nav-link>
                        <x-nav-link :href="route('note.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('note.index')">
                            {{ __('Note') }}
                        </x-nav-link>
                        <x-nav-link :href="route('openai.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('openai.index')">
                            {{ __('OPEN AI') }}
                        </x-nav-link>
                        <x-nav-link :href="route('gpt.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('gpt.index')">
                            {{ __('Chat GTP') }}
                        </x-nav-link>
                        <x-nav-link :href="route('mobile.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('mobile.index')">
                            {{ __('Mobile') }}
                        </x-nav-link> --}}






                <div class="navbar-end">
                    <div class="">

                        {{-- <a class="btn btn-ghost text-xl">
                            {{ config("app.name")}}
                        </a> --}}

                        <!-- daisyui modal -->
                        <button class="btn btn-ghost text-xl hidden lg:inline-block" onclick="my_modal_1.showModal()"> {{ config("app.name")}}</button>
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

                        <x-mary-button class="indicator hidden lg:inline-block">
                            Inbox
                            <x-mary-badge value="7" class="badge-secondary badge-sm indicator-item" />
                        </x-mary-button>

                        <!-- theme switcher at home.blade.php -->
                        <button onclick="toggleTheme()"
                            class="p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 hidden lg:inline-block">
                            <span class="dark:hidden">🌙</span>
                            <span class="hidden dark:inline">☀️</span>
                        </button>


                        <div class="dropdown dropdown-end hidden lg:inline-block">
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
                                            src="{{ '/storage/' . auth()->user()->avatar }}" />
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


                    <!-- Settings Dropdown -->
                    <div class="lg:hidden">
                        <div x-data="{ open: false }" class="relative">
                            <!-- Drawer -->
                            <div x-show="open"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform -translate-x-full"
                                x-transition:enter-end="opacity-100 transform translate-x-0"
                                x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="opacity-100 transform translate-x-0"
                                x-transition:leave-end="opacity-0 transform -translate-x-full"
                                class="fixed inset-y-0 left-0 w-9/12 lg:w-1/3 bg-white shadow-lg z-50"
                                @click.away="open = false">
                                <div class="p-4">
                                    <x-mary-menu class="p-0 m-0">
                                        <x-mary-menu-item title="Home" icon="o-home" href="{{ route('home', ['locale' => app()->getLocale()]) }}" wire:navigate/>
                                        {{-- <x-mary-menu-item title="Dashboard" icon="o-newspaper" href="{{ route('dashboard', ['locale' => app()->getLocale()] ) }}" wire:navigate/> --}}
                                    </x-mary-menu>
                                </div>
                            </div>

                            <!-- Mobile Menu Button -->
                            <div aria-label="Mobile Menu Button"
                                tabindex="0"
                                @click="open = !open"
                                role="button"
                                class="btn btn-ghost btn-circle">
                                <x-mary-icon name="o-bars-3" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
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
