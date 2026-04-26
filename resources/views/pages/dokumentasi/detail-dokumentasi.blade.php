@extends('layouts.navbar')
@section('title', 'Detail Penyaluran - AkuPeduli')

@section('content')
    <main class="bg-white pt-28 pb-20">
        <div class="max-w-5xl mx-auto px-4">
            <nav class="flex mb-8 text-sm text-slate-400">
                <a href="{{ route('documentation.index') }}" class="hover:text-blue-600 transition">Dokumentasi</a>
                <span class="mx-2">/</span>
                <span class="text-slate-600 truncate">
                    {{ $documentation->campaign->title }}
                </span>
            </nav>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <div class="lg:col-span-2">
                    <h1 class="text-3xl md:text-4xl font-bold text-slate-900 leading-tight mb-4">
                        {{ $documentation->campaign->title }}
                    </h1>
                    <div class="flex items-center gap-4 mb-4 pb-4 border-b border-slate-100">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($documentation->campaign->user->name ?? 'Admin') }}"
                            class="w-10 h-10 rounded-full border border-slate-200">

                        <!-- Nama + tanggal -->
                        <div>
                            <p class="text-sm font-bold text-slate-800">
                                {{ $documentation->campaign->user->name ?? 'Admin' }}
                            </p>

                            <p class="text-xs text-slate-400">
                                {{ $documentation->created_at->format('d M Y') }}
                            </p>
                        </div>

                    </div>
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $documentation->bukti_foto) }}"
                            class="w-full h-[400px] object-cover rounded-3xl shadow-sm">
                        <p class="text-center text-xs text-slate-400 mt-4 italic">Foto : Tim AkuPeduli saat menyerahkan
                            paket
                            sembako kepada warga.</p>
                    </div>
                    <article class="prose prose-slate max-w-none text-slate-600 leading-relaxed text-justify">
                        <p class="mb-4">
                            {!! $documentation->deskripsi !!}
                        </p>
                        <blockquote
                            class="border-l-4 border-blue-500 pl-4 py-2 my-6 bg-blue-50/50 rounded-r-xl italic font-medium text-blue-900">
                            "Terima kasih donatur AkuPeduli, bantuan ini sangat berarti untuk mereka yang membutuhkan."
                        </blockquote>
                    </article>

                    <div class="mt-12 pt-4 border-t">
                        <p class="text-sm font-bold mb-4">Bagikan kabar baik ini:</p>

                        @php
                            $url = url()->current();
                            $text = "Lihat dokumentasi ini:\n" . $documentation->campaign->title . "\n" . $url;

                            $wa = 'https://wa.me/?text=' . urlencode($text);
                            $fb = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($url);
                            $tw = 'https://twitter.com/intent/tweet?text=' . urlencode($text);
                            $tg = 'https://t.me/share/url?url=' . urlencode($url) . '&text=' . urlencode($text);
                        @endphp

                        <div class="flex flex-wrap gap-3">

                            <!-- WHATSAPP DIRECT -->
                            <a href="{{ $wa }}" target="_blank"
                                class="flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-xl font-bold text-sm hover:bg-green-700">
                                WhatsApp
                            </a>

                            <!-- SHARE DROPDOWN -->
                            <div class="relative">

                                <button onclick="toggleShare()"
                                    class="flex items-center gap-2 px-6 py-3 border border-slate-200 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-100 transition">

                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>

                                    Bagikan
                                </button>

                                <!-- DROPDOWN -->
                                <div id="shareMenu"
                                    class="hidden absolute right-0 w-52 mt-2 bg-white border rounded-xl shadow-lg p-2 space-y-1 z-50">

                                    <a href="{{ $fb }}" target="_blank"
                                        class="flex items-center gap-3 p-2 hover:bg-slate-100 rounded-lg">
                                        <img src="{{ asset('assets/fb.png') }}" class="w-5 h-5">
                                        Facebook
                                    </a>

                                    <a href="{{ $tw }}" target="_blank"
                                        class="flex items-center gap-3 p-2 hover:bg-slate-100 rounded-lg">
                                        <img src="{{ asset('assets/x.png') }}" class="w-5 h-5">
                                        Twitter
                                    </a>

                                    <a href="{{ $tg }}" target="_blank"
                                        class="flex items-center gap-3 p-2 hover:bg-slate-100 rounded-lg">
                                        <img src="{{ asset('assets/tele.png') }}" class="w-5 h-5">
                                        Telegram
                                    </a>

                                    <button onclick="copyLink()"
                                        class="flex items-center gap-3 p-2 hover:bg-slate-100 rounded-lg w-full text-left">
                                        <img src="{{ asset('assets/copylink.png') }}" class="w-5 h-5">
                                        Salin Link
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <x-documentation-sidebar :documentation="$documentation" />
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')

    <script>
        function toggleShare() {
            const menu = document.getElementById('shareMenu');
            if (menu) menu.classList.toggle('hidden');
        }

        // 🔥 KLIK DI LUAR → AUTO CLOSE
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('shareMenu');
            const button = e.target.closest('button');

            // kalau klik bukan tombol Bagikan & bukan menu
            if (!e.target.closest('#shareMenu') && !button) {
                if (menu && !menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                }
            }
        });

        // copy link
        function copyLink() {
            navigator.clipboard.writeText(window.location.href);
            alert("Link berhasil disalin!");
        }
    </script>

@endsection
