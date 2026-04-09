<div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 sticky top-28">
    <h3 class="text-lg font-bold text-slate-900 mb-4">Donasi Terkumpul</h3>
    <div class="flex items-end gap-2 mb-1">
        <span class="text-2xl font-bold text-blue-600">Rp 4.500.000</span>
        <span class="text-slate-400 text-sm mb-1">dari Rp 10.000.000</span>
    </div>
    <div class="w-full bg-slate-100 h-3 rounded-full mb-6 overflow-hidden">
        <div class="bg-blue-600 h-full rounded-full" style="width: 45%"></div>
    </div>
    <div class="grid grid-cols-2 gap-4 mb-8">
        <div class="text-center p-3 bg-slate-50 rounded-2xl">
            <p class="text-slate-500 text-xs uppercase font-bold tracking-wider">Donatur</p>
            <p class="text-slate-900 font-bold text-lg">124</p>
        </div>
        <div class="text-center p-3 bg-slate-50 rounded-2xl">
            <p class="text-slate-500 text-xs uppercase font-bold tracking-wider">Hari Lagi</p>
            <p class="text-slate-900 font-bold text-lg">12</p>
        </div>
    </div>
    <a href="{{ route('donasi.berdonasi') }}" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg shadow-blue-100 transition-all active:scale-95 mb-4 inline-block text-center">
        Donasi Sekarang
    </a>
    <button class="w-full py-3 border-2 border-slate-100 hover:bg-slate-50 text-slate-700 font-bold rounded-2xl transition-all flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
        </svg>
        Bagikan
    </button>
    <hr class="my-6 border-slate-50">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center font-bold text-blue-600">AP</div>
        <div>
            <p class="text-xs text-slate-500 font-medium">Penyelenggara</p>
            <p class="text-sm font-bold text-slate-900">Admin AkuPeduli!</p>
        </div>
    </div>
</div>