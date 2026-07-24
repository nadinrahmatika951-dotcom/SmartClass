<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SmartClass') }}</title>

    <!-- Fonts Poppins -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-pinkbg text-gray-900 min-h-screen flex flex-col">

    <!-- Navbar Welcome Page -->
    <header
        class="bg-white shadow-sm h-20 flex items-center justify-between px-6 md:px-12 z-10 rounded-b-xl md:rounded-none">
        <div class="flex items-center">
            <h1 class="text-2xl font-bold text-primary">SmartClass</h1>
        </div>
        <div class="flex items-center space-x-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="text-gray-600 hover:text-primary font-medium transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-primary font-medium transition">Log
                        in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="bg-[#b94a48] text-white px-5 py-2 rounded-xl hover:bg-red-700 transition font-medium shadow-sm">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </header>

    <!-- Main Hero Section -->
    <main class="flex-1 flex items-center justify-center p-6 text-center">
        <div class="max-w-3xl">
            <!-- Icon/Ilustrasi -->
            <div class="flex justify-center mb-6">
                <div class="bg-white p-4 rounded-full shadow-sm border border-gray-100">
                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                        </path>
                    </svg>
                </div>
            </div>

            <h2 class="text-4xl md:text-5xl font-bold text-primary mb-6 leading-tight">
                Sistem Manajemen Kelas <br> Cerdas & Modern
            </h2>
            <p class="text-lg text-gray-600 mb-10 px-4 md:px-16">
                Platform terpadu untuk mengelola jadwal perkuliahan, pengambilan kelas, dan pemantauan data akademik
                secara efisien.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="bg-primary text-white bg-[#b94a48] px-8 py-3 rounded-xl hover:bg-red-800 transition font-semibold text-lg shadow-lg">
                        Kembali ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-primary text-white bg-[#b94a48] px-8 py-3 rounded-xl hover:bg-red-800 transition font-semibold text-lg shadow-lg">
                        Mulai Sekarang
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="bg-white text-primary border-2 border-[#b94a48] px-8 py-3 rounded-xl hover:bg-pinkbg transition font-semibold text-lg">
                            Daftar Akun
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-6 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} SmartClass. Ujian Akhir Semester Web Lanjut.
    </footer>
</body>

</html>
