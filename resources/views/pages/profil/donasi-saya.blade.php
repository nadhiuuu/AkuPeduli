<div x-show="tab === 'donations'" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>

    <div class="mb-8">
        <h3 class="text-xl font-bold text-slate-800">Riwayat Donasi</h3>
        <p class="text-sm text-slate-500">Terima kasih atas kebaikan Anda. Berikut adalah ringkasan kontribusi Anda.</p>
    </div>

    <x-donasi-saya-card />

    <div class="space-y-4">
        <h4 class="font-bold text-slate-800 ml-1">Transaksi Terakhir</h4>
        <div class="bg-white border border-slate-100 rounded-xl overflow-hidden shadow-sm">
            <x-transaksi-saya-table />
        </div>

    </div>
</div>