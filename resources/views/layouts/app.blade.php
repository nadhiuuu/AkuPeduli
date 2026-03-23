<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-slate-900">

    <nav id="main-nav" class="absolute top-0 left-0 w-full z-[100] transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center flex-shrink-0 h-full">
                    <a href="{{ url('/') }}" class="flex items-center h-full">
                        <img id="nav-logo" src="{{ asset('assets/AkuPeduli color.png') }}" alt="AkuPeduli Logo" class="h-23 md:h-25 w-auto object-contain transition-all duration-300 brightness-0 invert">
                    </a>
                </div>

                <div id="nav-menu" class="hidden md:flex items-center justify-center flex-1 space-x-8 text-white transition-colors duration-300">
                    <a href="#" class="text-base font-semibold hover:opacity-80 transition-opacity">Beranda</a>
                    <a href="#" class="text-base font-semibold hover:opacity-80 transition-opacity">Donasi</a>
                    <a href="#" class="text-base font-semibold hover:opacity-80 transition-opacity">Galang Donasi</a>

                    <div class="relative">
                        <button id="btn-dokumentasi" class="text-base font-semibold hover:opacity-80 transition-opacity flex items-center">
                            Dokumentasi
                        </button>
                        <div id="dropdown-dokumentasi" class="hidden absolute left-0 mt-2 w-48 bg-white border border-slate-100 rounded-xl shadow-lg text-slate-700">
                            <a href="#" class="block px-4 py-3 text-sm hover:bg-slate-50">Galeri</a>
                            <a href="#" class="block px-4 py-3 text-sm hover:bg-slate-50">Laporan</a>
                        </div>
                    </div>

                    <div class="relative">
                        <button id="btn-tentang" class="text-base font-semibold hover:opacity-80 transition-opacity flex items-center">
                            Tentang
                        </button>
                        <div id="dropdown-tentang" class="hidden absolute left-0 mt-2 w-56 bg-white border border-slate-100 rounded-xl shadow-lg text-slate-700">
                            <a href="#" class="block px-4 py-3 text-sm hover:bg-slate-50">Tentang Kami</a>
                            <a href="#" class="block px-4 py-3 text-sm hover:bg-slate-50">FAQ</a>
                            <a href="#" class="block px-4 py-3 text-sm hover:bg-slate-50">Hubungi Kami</a>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 flex-shrink-0">
                    <div id="nav-auth" class="hidden md:flex items-center gap-3 text-white transition-colors duration-300">
                        @auth
                            <div class="relative group">
                                <button class="flex items-center focus:outline-none">
                                    <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center overflow-hidden">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </button>
                                <div class="absolute right-0 mt-2 w-48 bg-white border border-slate-100 rounded-xl shadow-lg opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-5 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50">Logout</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold hover:opacity-80 transition-opacity">Masuk</a>
                            @if (Route::has('register'))
                                <a id="btn-daftar" href="{{ route('register') }}" class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-full shadow-md transition-all active:scale-95">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    </div>

                    <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg text-white transition-colors duration-300">
                        <svg id="menu-icon" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white shadow-inner">
            <div class="px-5 pt-4 pb-8 space-y-3">
                <a href="#" class="block px-4 py-3 rounded-xl text-base font-semibold text-slate-700 hover:bg-blue-50">Beranda</a>
                <a href="#" class="block px-4 py-3 rounded-xl text-base font-semibold text-slate-700 hover:bg-blue-50">Donasi</a>
                <hr class="border-slate-100">
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 text-red-600 font-semibold">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-3 text-slate-700 font-semibold">Masuk</a>
                    <a href="{{ route('register') }}" class="block px-4 py-3 rounded-full text-center bg-blue-600 text-white font-semibold">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="min-h-screen">
        @yield('content')
    </main>

    <script>
        const nav = document.getElementById('main-nav');
        const navLogo = document.getElementById('nav-logo');
        const navMenu = document.getElementById('nav-menu');
        const navAuth = document.getElementById('nav-auth');
        const mobileIcon = document.getElementById('mobile-menu-button');

        const btn = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');
        const icon = document.getElementById('menu-icon');

        const btnDok = document.getElementById('btn-dokumentasi');
        const dropDok = document.getElementById('dropdown-dokumentasi');

        const btnTentang = document.getElementById('btn-tentang');
        const dropTentang = document.getElementById('dropdown-tentang');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                nav.classList.replace('absolute', 'fixed');
                nav.classList.add('bg-white', 'shadow-md', 'border-b', 'border-slate-100');
                navLogo.classList.remove('brightness-0', 'invert');
                navMenu.classList.replace('text-white', 'text-slate-700');
                navAuth.classList.replace('text-white', 'text-slate-700');
                mobileIcon.classList.replace('text-white', 'text-slate-700');
            } else {
                nav.classList.replace('fixed', 'absolute');
                nav.classList.remove('bg-white', 'shadow-md', 'border-b', 'border-slate-100');
                navLogo.classList.add('brightness-0', 'invert');
                navMenu.classList.replace('text-slate-700', 'text-white');
                navAuth.classList.replace('text-slate-700', 'text-white');
                mobileIcon.classList.replace('text-slate-700', 'text-white');
            }
        });

        window.dispatchEvent(new Event('scroll'));

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
            const isHidden = menu.classList.contains('hidden');
            icon.innerHTML = isHidden
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
        });

        const closeDropdowns = () => {
            dropDok.classList.add('hidden');
            dropTentang.classList.add('hidden');
        };

        btnDok.addEventListener('click', (e) => {
            e.stopPropagation();
            dropDok.classList.toggle('hidden');
            dropTentang.classList.add('hidden');
        });

        btnTentang.addEventListener('click', (e) => {
            e.stopPropagation();
            dropTentang.classList.toggle('hidden');
            dropDok.classList.add('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!btnDok.contains(e.target) && !dropDok.contains(e.target)) {
                dropDok.classList.add('hidden');
            }
            if (!btnTentang.contains(e.target) && !dropTentang.contains(e.target)) {
                dropTentang.classList.add('hidden');
            }
        });
    </script>
</body>
</html>