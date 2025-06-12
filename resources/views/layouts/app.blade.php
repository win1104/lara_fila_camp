<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Mary UI -->
        <link href="https://cdn.jsdelivr.net/npm/mary-ui@2.3.0/dist/mary.min.css" rel="stylesheet">
        <!-- Tailwind CDN（測試用）-->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <style>
            .dropdown {
                position: relative;
            }
            .dropdown-content {
                position: absolute !important;
                transform: none !important;
                margin-top: 0 !important;
                padding-top: 0.5rem !important;
                font-size: 1rem;
            }
            .dropdown-content::before {
                content: '';
                position: absolute;
                top: -0.5rem;
                left: 0;
                right: 0;
                height: 0.5rem;
            }
            .dropdown-content ul {
                margin-top: 0 !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">

        <div class="min-h-screen bg-white">

            {{-- @include('layouts.navigation') --}}
            <livewire:components.header />

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-[1632px] mx-auto px-8 py-6 lg:px-32">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="max-w-[1632px] mx-auto px-8 lg:px-32">
                {{ $slot }}
            </main>
        </div>
        @livewire('chat-widget')
        {{-- @livewire('doc-bot') --}}

        <!-- Livewire Scripts (必須在 Alpine 之前) -->
        @livewireScripts
        <script src="{{ asset('js/app.js') }}"></script>

        <!-- Mary UI Scripts -->
        {{-- <script src="https://cdn.jsdelivr.net/npm/mary-ui@2.3.0/dist/mary.min.js"></script> --}}
    </body>
</html>
