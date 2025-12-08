<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Gilgit-Baltistan Fisheries</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Bar -->
                <header class="bg-white shadow-sm border-b border-gray-200">
                    <div class="flex items-center justify-between h-16 px-6">
                        <div class="flex items-center">
                            <button @click="$store.sidebar.toggle()" class="lg:hidden text-gray-500 hover:text-gray-700 mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                            @isset($header)
                                <h2 class="text-xl font-semibold text-gray-800">{{ $header }}</h2>
                            @endisset
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600">{{ now()->format('l, F d, Y') }}</span>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="$store.sidebar.open" @click="$store.sidebar.open = false" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden" x-cloak></div>
    </body>
</html>
