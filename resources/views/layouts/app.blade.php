<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SmartClass') }}</title>

    <!-- Fonts Poppins -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="font-sans antialiased bg-pinkbg text-gray-900">
    <div class="min-h-screen flex flex-col md:flex-row">

        <!-- Sidebar Desktop -->
        <aside class="hidden md:flex flex-col w-64 bg-white shadow-halus min-h-screen fixed">
            <div class="flex items-center justify-center h-20 border-b border-gray-100">
                <!-- PERBAIKAN: Bungkus dengan tag <a> -->
                <a href="{{ url('/') }}" class="hover:opacity-80 transition-opacity duration-200">
                    <h1 class="text-2xl font-bold text-primary">SmartClass</h1>
                </a>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('dashboard') }}"
                    class="{{ request()->routeIs('dashboard') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-pinkbg hover:text-primary' }} flex items-center gap-3 px-4 py-3 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('jadwal.index') }}"
                    class="{{ request()->routeIs('jadwal.index') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-pinkbg hover:text-primary' }} flex items-center gap-3 px-4 py-3 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    Jadwal Kuliah
                </a>

                <!-- Menu Roster (Khusus Mahasiswa) -->
                @if (auth()->user()->role === 'user')
                    <a href="{{ route('jadwal.roster') }}"
                        class="{{ request()->routeIs('jadwal.roster') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-pinkbg hover:text-primary' }} flex items-center gap-3 px-4 py-3 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                        </svg>
                        Roster Ku
                    </a>
                @endif

                <!-- Menu User Management (Khusus Admin) -->
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('users.index') }}"
                        class="{{ request()->routeIs('users.*') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-pinkbg hover:text-primary' }} flex items-center gap-3 px-4 py-3 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        User Management
                    </a>
                @endif

            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 md:ml-64 flex flex-col min-h-screen">

            <!-- Navbar -->
            <header
                class="bg-white shadow-sm h-20 flex items-center justify-between px-6 md:px-8 z-10 rounded-b-xl md:rounded-none">
                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <!-- PERBAIKAN: Bungkus dengan tag <a> -->
                    <a href="{{ url('/') }}" class="hover:opacity-80 transition-opacity duration-200">
                        <h1 class="text-xl font-bold text-primary">SmartClass</h1>
                    </a>
                </div>

                <div class="flex items-center space-x-4 ml-auto">
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-xl text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }} ({{ Auth::user()->role }})</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
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
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 md:p-8">
                {{ $slot }}
            </main>
        </div>

        <!-- Mobile Bottom Nav -->
        <div
            class="md:hidden fixed bottom-0 w-full bg-white shadow-[0_-4px_20px_-2px_rgba(0,0,0,0.05)] flex justify-around py-3 rounded-t-xl z-20">
            <a href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'text-primary' : 'text-gray-400' }} flex flex-col items-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>
                </svg>
                <span class="text-xs mt-1">Dashboard</span>
            </a>

            <a href="{{ route('jadwal.index') }}"
                class="{{ request()->routeIs('jadwal.index') ? 'text-primary' : 'text-gray-400' }} flex flex-col items-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                <span class="text-xs mt-1">Jadwal</span>
            </a>

            <!-- Menu Roster Mobile (Khusus Mahasiswa) -->
            @if (auth()->user()->role === 'user')
                <a href="{{ route('jadwal.roster') }}"
                    class="{{ request()->routeIs('jadwal.roster') ? 'text-primary' : 'text-gray-400' }} flex flex-col items-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                    </svg>
                    <span class="text-xs mt-1">Roster</span>
                </a>
            @endif

            <!-- Menu User Mobile (Khusus Admin) -->
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('users.index') }}"
                    class="{{ request()->routeIs('users.*') ? 'text-primary' : 'text-gray-400' }} flex flex-col items-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <span class="text-xs mt-1">Users</span>
                </a>
            @endif
        </div>
    </div>
</body>

</html>
