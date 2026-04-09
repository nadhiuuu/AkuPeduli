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
            overflow: hidden;
            transition: max-height 0.3s ease-out, opacity 0.2s;
            opacity: 0;
        }
        .mobile-dropdown-open {
            max-height: 500px;
            opacity: 1;
            transition: max-height 0.5s ease-in, opacity 0.3s;
        }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-900">

    <nav id="main-nav" class="absolute top-0 left-0 w-full z-[100] transition-all duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center flex-shrink-0">
                    <a href="{{ url('/') }}" class="flex items-center">
                        <img id="nav-logo" src="{{ asset('assets/AkuPeduli color.png') }}" alt="AkuPeduli Logo" class="h-23 md:h-25 lg:h-26 w-auto object-contain transition-all duration-300 brightness-0 invert">
                    </a>
                </div>

                <div id="nav-menu" class="hidden md:flex items-center justify-center flex-1 md:space-x-4 lg:space-x-8 text-white transition-colors duration-300">
                    <a href="#" class="text-lg font-semibold hover:text-blue-600 transition-colors duration-300">Beranda</a>
                    <a href="#" class="text-lg font-semibold hover:text-blue-600 transition-colors duration-300">Donasi</a>
                    <a href="#" class="text-lg font-semibold hover:text-blue-600 transition-colors duration-300">Galang Donasi</a>
                    <a href="#" class="text-lg font-semibold hover:text-blue-600 transition-colors duration-300">Dokumentasi</a>

                    <div class="relative group">
                        <button id="btn-tentang" class="text-lg font-semibold hover:text-blue-200 transition-colors duration-300 flex items-center gap-1 py-4">
                            Tentang
                        </button>
                        <div id="dropdown-tentang" class="opacity-0 invisible translate-y-2 absolute left-0 mt-0 w-56 bg-white border border-slate-100 rounded-xl shadow-xl text-slate-700 transition-all duration-300 ease-out">
                            <div class="p-2">
                                <a href="#" class="block px-4 py-2.5 rounded-lg text-base hover:text-blue-600">Tentang Kami</a>
                                <a href="#" class="block px-4 py-2.5 rounded-lg text-base hover:text-blue-600">FAQ</a>
                                <a href="#" class="block px-4 py-2.5 rounded-lg text-base hover:text-blue-600">Syarat & Ketentuan</a>
                                <a href="#" class="block px-4 py-2.5 rounded-lg text-base hover:text-blue-600">Kebijakan Privasi</a>
                                <a href="#" class="block px-4 py-2.5 rounded-lg text-base hover:text-blue-600">Hubungi Kami</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 flex-shrink-0">
                    <div id="nav-auth" class="hidden md:flex items-center gap-3 text-white transition-colors duration-300">
                        @auth
                            <div class="relative group">
                                <button class="flex items-center focus:outline-none">
                                    <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center overflow-hidden hover:bg-white/30 transition-all">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </button>
                                <div class="absolute right-0 mt-2 w-48 bg-white border border-slate-100 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-5 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-xl">Logout</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-base font-semibold hover:opacity-30 transition-opacity">Masuk</a>
                            @if (Route::has('register'))
                                <a id="btn-daftar" href="{{ route('register') }}" class="px-6 py-2.5 text-base font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition-all active:scale-95 whitespace-nowrap">
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

        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white shadow-xl max-h-[85vh] overflow-y-auto">
            <div class="px-5 pt-4 pb-8 space-y-2">
                <a href="#" class="block px-4 py-3 rounded-xl text-base font-semibold text-slate-700 hover:bg-blue-50">Beranda</a>
                <a href="#" class="block px-4 py-3 rounded-xl text-base font-semibold text-slate-700 hover:bg-blue-50">Donasi</a>
                <a href="#" class="block px-4 py-3 rounded-xl text-base font-semibold text-slate-700 hover:bg-blue-50">Galang Donasi</a>
                <a href="#" class="block px-4 py-3 rounded-xl text-base font-semibold text-slate-700 hover:bg-blue-50">Dokumentasi</a>
                
                <div class="border-b border-slate-50 my-1"></div>

                <div>
                    <button id="btn-tentang-mobile" class="w-full text-left px-4 py-3 rounded-xl text-base font-semibold text-slate-700 hover:bg-blue-50 flex justify-between items-center transition-colors">
                        Tentang
                        <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="drop-tentang-mobile" class="mobile-dropdown-closed space-y-1 ml-4 border-l-2 border-slate-100">
                        <a href="#" class="block px-6 py-2 text-slate-600 font-medium hover:text-blue-600">Tentang Kami</a>
                        <a href="#" class="block px-6 py-2 text-slate-600 font-medium hover:text-blue-600">FAQ</a>
                        <a href="#" class="block px-6 py-2 text-slate-600 font-medium hover:text-blue-600">Syarat dan Ketentuan</a>
                        <a href="#" class="block px-6 py-2 text-slate-600 font-medium hover:text-blue-600">Kebijakan Privasi</a>
                        <a href="#" class="block px-6 py-2 text-slate-600 font-medium hover:text-blue-600">Hubungi Kami</a>
                    </div>
                </div>

                <div class="pt-4 space-y-3">
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full px-4 py-3 rounded-xl bg-red-50 text-red-600 font-bold text-center">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block px-4 py-3 text-center text-slate-700 font-semibold border border-slate-200 rounded-xl">Masuk</a>
                        <a href="{{ route('register') }}" class="block px-4 py-3 rounded-xl text-center bg-blue-600 text-white font-semibold shadow-md">Daftar Sekarang</a>
                    @endauth
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
        const menuIcon = document.getElementById('menu-icon');
        const drops = {
            tentang: { btn: 'btn-tentang', menu: 'dropdown-tentang' },
            tentangMob: { btn: 'btn-tentang-mobile', menu: 'drop-tentang-mobile' }
        };

        window.addEventListener('scroll', () => {
            const isScrolled = window.scrollY > 50;
            if (isScrolled) {
                nav.classList.replace('absolute', 'fixed');
                nav.classList.add('bg-white', 'shadow-lg', 'border-b', 'border-slate-100');
                navLogo.classList.remove('brightness-0', 'invert');
                [navMenu, navAuth, mobileIconBtn].forEach(el => el.classList.replace('text-white', 'text-slate-700'));
            } else {
                nav.classList.replace('fixed', 'absolute');
                nav.classList.remove('bg-white', 'shadow-lg', 'border-b', 'border-slate-100');
                navLogo.classList.add('brightness-0', 'invert');
                [navMenu, navAuth, mobileIconBtn].forEach(el => el.classList.replace('text-slate-700', 'text-white'));
            }
        });

        function toggleDesktopDropdown(menuId) {
            const menu = document.getElementById(menuId);
            menu.classList.toggle('opacity-0');
            menu.classList.toggle('invisible');
            menu.classList.toggle('translate-y-2');
            menu.classList.toggle('translate-y-0');
        }

        document.getElementById(drops.tentang.btn).addEventListener('click', (e) => {
            e.stopPropagation();
            toggleDesktopDropdown(drops.tentang.menu);
        });

        document.addEventListener('click', () => {
            const el = document.getElementById(drops.tentang.menu);
            el.classList.add('opacity-0', 'invisible', 'translate-y-2');
            el.classList.remove('translate-y-0');
        });

        mobileIconBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            const isOpen = !mobileMenu.classList.contains('hidden');
            menuIcon.innerHTML = isOpen 
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
        });

        function setupMobileAccordion(btnId, menuId) {
            const btn = document.getElementById(btnId);
            const menu = document.getElementById(menuId);
            const svg = btn.querySelector('svg');

            btn.addEventListener('click', () => {
                const isOpen = menu.classList.contains('mobile-dropdown-open');
                if (isOpen) {
                    menu.classList.replace('mobile-dropdown-open', 'mobile-dropdown-closed');
                    svg.classList.remove('rotate-180');
                } else {
                    menu.classList.replace('mobile-dropdown-closed', 'mobile-dropdown-open');
                    svg.classList.add('rotate-180');
                }
            });
        }

        setupMobileAccordion(drops.tentangMob.btn, drops.tentangMob.menu);
        window.dispatchEvent(new Event('scroll'));
    </script>
</body>
</html>