@props(['raised', 'goal', 'percentage', 'donors', 'daysLeft', 'author', 'slug'])

<div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 sticky top-28">
    <h3 class="text-lg font-bold text-slate-900 mb-4">Donasi Terkumpul</h3>
    <div class="flex items-end gap-2 mb-1">
        <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($raised, 0, ',', '.') }}</span>
        <span class="text-slate-400 text-sm mb-1">dari Rp {{ number_format($goal, 0, ',', '.') }}</span>
    </div>
    <div class="w-full bg-slate-100 h-3 rounded-full mb-6 overflow-hidden">
        <div class="bg-blue-600 h-full rounded-full" style="width: {{ $percentage }}%"></div>
    </div>
    <div class="grid grid-cols-2 gap-4 mb-8">
        <div class="text-center p-3 bg-slate-50 rounded-2xl">
            <p class="text-slate-500 text-xs uppercase font-bold tracking-wider">Donatur</p>
            <p class="text-slate-900 font-bold text-lg">{{ $donors }}</p>
        </div>
        <div class="text-center p-3 bg-slate-50 rounded-2xl">
            <p class="text-slate-500 text-xs uppercase font-bold tracking-wider">Hari Lagi</p>
            <p class="text-slate-900 font-bold text-lg">{{ $daysLeft }}</p>
        </div>
    </div>
    @php
        $url = url()->current();
        $text = "Lihat campaign donasi ini:\n" . $author . "\n" . $url;

        $wa = 'https://wa.me/?text=' . urlencode($text);
        $fb = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($url);
        $tw = 'https://twitter.com/intent/tweet?text=' . urlencode($text);
        $tg = 'https://t.me/share/url?url=' . urlencode($url) . '&text=' . urlencode($text);
    @endphp
    @php
        $url = url()->current();
        $text = "Lihat campaign donasi ini:\n" . $author . "\n" . $url;

        $wa = 'https://wa.me/?text=' . urlencode($text);
        $fb = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($url);
        $tw = 'https://twitter.com/intent/tweet?text=' . urlencode($text);
        $tg = 'https://t.me/share/url?url=' . urlencode($url) . '&text=' . urlencode($text);
    @endphp
    <div class="relative">
        <button onclick="toggleShare()"
            class="w-full py-3 border-2 border-slate-100 hover:bg-slate-50 text-slate-700 font-bold rounded-2xl flex items-center justify-center gap-2">

            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316" />
            </svg>

            Bagikan
        </button>

        <div id="shareMenu"
            class="hidden absolute w-full mt-2 bg-white border border-slate-200 rounded-xl shadow-lg p-3 space-y-1 z-50">

            <!-- ITEM -->
            <a href="{{ $wa }}" target="_blank"
                class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-100 transition">

                <img src="{{ asset('assets/wa.png') }}" class="w-5 h-5 object-contain flex-shrink-0">

                <span class="text-sm leading-none">WhatsApp</span>
            </a>

            <a href="{{ $fb }}" target="_blank"
                class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-100 transition">

                <img src="{{ asset('assets/ig.png') }}" class="w-5 h-5 object-contain flex-shrink-0">

                <span class="text-sm leading-none">Instagram</span>
            </a>

            <a href="{{ $fb }}" target="_blank"
                class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-100 transition">

                <img src="{{ asset('assets/fb.png') }}" class="w-5 h-5 object-contain flex-shrink-0">

                <span class="text-sm leading-none">Facebook</span>
            </a>

            <a href="{{ $tw }}" target="_blank"
                class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-100 transition">

                <img src="{{ asset('assets/x.png') }}" class="w-5 h-5 object-contain flex-shrink-0">

                <span class="text-sm leading-none">Twitter</span>
            </a>

            <a href="{{ $tg }}" target="_blank"
                class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-100 transition">

                <img src="{{ asset('assets/tele.png') }}" class="w-5 h-5 object-contain flex-shrink-0">

                <span class="text-sm leading-none">Telegram</span>
            </a>

            <!-- COPY LINK -->
            <button onclick="copyLink()"
                class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-100 transition w-full text-left">

                <img src="{{ asset('assets/copylink.png') }}" class="w-5 h-5 object-contain flex-shrink-0">

                <span class="text-sm leading-none">Salin Link</span>
            </button>

        </div>
    </div>

    <hr class="my-6 border-slate-50">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center font-bold text-blue-600">AP
        </div>
        <div>
            <p class="text-xs text-slate-500 font-medium">Penyelenggara</p>
            <p class="text-sm font-bold text-slate-900">{{ $author }}</p>
        </div>
    </div>
</div>

<!-- script untuk share button -->
<script>
    function toggleShare() {
        document.getElementById('shareMenu').classList.toggle('hidden');
    }

    function copyLink() {
        navigator.clipboard.writeText(window.location.href);
        alert("Link berhasil disalin!");
    }
</script>
