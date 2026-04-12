<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('assets/AkuPeduli white.png') }}">
    <title>@yield('title', config('app.name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .mobile-dropdown-closed {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: all 0.3s ease-in-out;
        }
        .mobile-dropdown-open {
            max-height: 500px;
            opacity: 1;
            transition: all 0.5s ease-in-out;
        }
        .nav-transition {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-900">
    <nav id="main-nav" class="fixed top-0 left-0 w-full z-[100] nav-transition border-b border-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center flex-shrink-0">
                    <a href="{{ url('/') }}" class="flex items-center">
                        <img id="nav-logo" src="{{ asset('assets/AkuPeduli color.png') }}" alt="Logo" 
                             class="h-25 md:h-25 w-auto object-contain nav-transition brightness-0 invert">
                    </a>
                </div>

                <div id="nav-menu" class="hidden lg:flex items-center justify-center space-x-6 xl:space-x-8 text-white">
                    <a href="{{ route('home') }}" class="text-base font-semibold transition-colors {{ request()->routeIs('home') ? 'text-blue-500' : 'hover:text-blue-400' }}">Beranda</a>
                    <a href="{{ route('donation.index') }}" class="text-base font-semibold transition-colors {{ request()->routeIs('donations.index') ? 'text-blue-500' : 'hover:text-blue-400' }}">Donasi</a>
                    <a href="{{ route('fundraising.index') }}" class="text-base font-semibold transition-colors {{ request()->routeIs('fundraising.index') ? 'text-blue-500' : 'hover:text-blue-400' }}">Galang Donasi</a>
                    <a href="{{ route('documentation.index') }}" class="text-base font-semibold transition-colors {{ request()->routeIs('documentation.index') ? 'text-blue-500' : 'hover:text-blue-400' }}">Dokumentasi</a>

                    <div class="relative group">
                        <button id="btn-tentang" class="text-base font-semibold hover:text-blue-400 transition-colors flex items-center gap-1 py-4">
                            Tentang
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <div id="dropdown-tentang" class="opacity-0 invisible translate-y-2 absolute left-0 w-56 bg-white border border-slate-100 rounded-xl shadow-xl text-slate-700 nav-transition">
                            <div class="p-2">
                                <a href="{{ route('about') }}" class="block px-4 py-2.5 hover:bg-slate-50 hover:text-blue-600 rounded-lg">Tentang Kami</a>
                                <a href="#" class="block px-4 py-2.5 hover:bg-slate-50 hover:text-blue-600 rounded-lg">FAQ</a>
                                <a href="#" class="block px-4 py-2.5 hover:bg-slate-50 hover:text-blue-600 rounded-lg">Syarat & Ketentuan</a>
                                <a href="#" class="block px-4 py-2.5 hover:bg-slate-50 hover:text-blue-600 rounded-lg">Kebijakan Privasi</a>
                                <a href="#" class="block px-4 py-2.5 hover:bg-slate-50 hover:text-blue-600 rounded-lg">Hubungi Kami</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div id="nav-auth" class="hidden md:flex items-center gap-4 text-white">
                        @auth
                            <div class="relative group">
                                <button class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center overflow-hidden hover:bg-white/40 transition-all">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2" /></svg>
                                </button>
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-2 group-hover:translate-y-0 nav-transition">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-5 py-3 text-slate-700 hover:bg-red-50 hover:text-red-600 rounded-xl font-medium">Logout</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ filament()->getLoginUrl() }}" class="text-sm font-bold hover:opacity-75 transition-opacity">Masuk</a>
                            <a href="{{ filament()->getRegistrationUrl() }}" class="px-5 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md active:scale-95 transition-all whitespace-nowrap">Daftar</a>
                        @endauth
                    </div>

                    <button id="mobile-menu-button" class="lg:hidden p-2 rounded-lg text-white nav-transition focus:outline-none">
                        <svg id="menu-icon" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path id="path-1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16" />
                            <path id="path-2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12h16" />
                            <path id="path-3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-slate-100 shadow-2xl overflow-hidden nav-transition">
            <div class="px-4 pt-4 pb-8 space-y-2">
                <a href="{{ route('home') }}" class="block px-4 py-3 text-base font-semibold text-slate-700 rounded-xl hover:bg-blue-50 {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600' : '' }}">Beranda</a>
                <a href="{{ route('donation.index') }}" class="block px-4 py-3 text-base font-semibold text-slate-700 rounded-xl hover:bg-blue-50 {{ request()->routeIs('donations.index') ? 'bg-blue-50 text-blue-600' : '' }}">Donasi</a>
                <a href="{{ route('fundraising.index') }}" class="block px-4 py-3 text-base font-semibold text-slate-700 rounded-xl hover:bg-blue-50 {{ request()->routeIs('fundraising.index') ? 'bg-blue-50 text-blue-600' : '' }}">Galang Donasi</a>
                <a href="{{ route('documentation.index') }}" class="block px-4 py-3 text-base font-semibold text-slate-700 rounded-xl hover:bg-blue-50 {{ request()->routeIs('documentation.index') ? 'bg-blue-50 text-blue-600' : '' }}">Dokumentasi</a>

                <div class="border-t border-slate-50 my-2"></div>

                <button id="btn-tentang-mobile" class="w-full flex justify-between items-center px-4 py-3 text-base font-semibold text-slate-700 rounded-xl hover:bg-blue-50">
                    Tentang
                    <svg class="w-5 h-5 nav-transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round"/></svg>
                </button>
                <div id="drop-tentang-mobile" class="mobile-dropdown-closed pl-4 space-y-1">
                    <a href="{{ route('about') }}" class="block px-4 py-2 text-slate-500 font-medium hover:text-blue-600">Tentang Kami</a>
                    <a href="#" class="block px-4 py-2 text-slate-500 font-medium hover:text-blue-600">FAQ</a>
                    <a href="#" class="block px-4 py-2 text-slate-500 font-medium hover:text-blue-600">Syarat & Ketentuan</a>
                    <a href="#" class="block px-4 py-2 text-slate-500 font-medium hover:text-blue-600">Kebijakan Privasi</a>
                    <a href="#" class="block px-4 py-2 text-slate-500 font-medium hover:text-blue-600">Hubungi Kami</a>
                </div>

                <div class="pt-6 space-y-3">
                    @guest
                        <a href="{{ filament()->getLoginUrl() }}" class="block w-full py-3 text-center font-bold text-slate-700 border border-slate-200 rounded-xl">Masuk</a>
                        <a href="{{ filament()->getRegistrationUrl() }}" class="block w-full py-3 text-center font-bold text-white bg-blue-600 rounded-xl shadow-lg">Daftar Sekarang</a>
                    @else
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full py-3 text-center font-bold text-red-600 bg-red-50 rounded-xl">Logout</button>
                        </form>
                    @endguest
                </div>
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
        const mobileIconBtn = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        const isHomePage = window.location.pathname === '/' || window.location.pathname === '/landing';

        function handleScroll() {
            const isScrolled = window.scrollY > 20 || !isHomePage;

            if (isScrolled) {
                nav.classList.add('bg-white', 'shadow-md', 'border-slate-100');
                nav.classList.remove('border-transparent');
                navLogo.classList.remove('brightness-0', 'invert');
                [navMenu, navAuth, mobileIconBtn].forEach(el => {
                    if(el) { el.classList.remove('text-white'); el.classList.add('text-slate-700'); }
                });
            } else {
                nav.classList.remove('bg-white', 'shadow-md', 'border-slate-100');
                nav.classList.add('border-transparent');
                navLogo.classList.add('brightness-0', 'invert');
                [navMenu, navAuth, mobileIconBtn].forEach(el => {
                    if(el) { el.classList.remove('text-slate-700'); el.classList.add('text-white'); }
                });
            }
        }

        mobileIconBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            const p1 = document.getElementById('path-1');
            const p2 = document.getElementById('path-2');
            const p3 = document.getElementById('path-3');
            
            if (!mobileMenu.classList.contains('hidden')) {
                p1.setAttribute('d', 'M6 18L18 6'); p2.style.opacity = '0'; p3.setAttribute('d', 'M6 6l12 12');
            } else {
                p1.setAttribute('d', 'M4 6h16'); p2.style.opacity = '1'; p3.setAttribute('d', 'M4 18h16');
            }
        });

        const btnTentangMob = document.getElementById('btn-tentang-mobile');
        const dropTentangMob = document.getElementById('drop-tentang-mobile');
        btnTentangMob.addEventListener('click', () => {
            const isOpen = dropTentangMob.classList.contains('mobile-dropdown-open');
            dropTentangMob.classList.toggle('mobile-dropdown-open', !isOpen);
            dropTentangMob.classList.toggle('mobile-dropdown-closed', isOpen);
            btnTentangMob.querySelector('svg').classList.toggle('rotate-180', !isOpen);
        });

        const btnTentang = document.getElementById('btn-tentang');
        const dropTentang = document.getElementById('dropdown-tentang');
        btnTentang.addEventListener('click', (e) => {
            e.stopPropagation();
            dropTentang.classList.toggle('opacity-0');
            dropTentang.classList.toggle('invisible');
            dropTentang.classList.toggle('translate-y-2');
        });

        document.addEventListener('click', () => {
            dropTentang.classList.add('opacity-0', 'invisible', 'translate-y-2');
        });

        window.addEventListener('scroll', handleScroll);
        window.addEventListener('load', handleScroll);
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>