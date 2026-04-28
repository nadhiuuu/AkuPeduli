@props(['totalDonasi', 'frekuensi'])

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">

    <!-- TOTAL DONASI -->
    <div class="p-4 bg-blue-600 rounded-xl shadow-sm text-white relative overflow-hidden">
        <div class="relative z-10">
            <p class="text-sm font-medium opacity-80">Total Donasi</p>
            <h4 class="text-2xl font-bold mt-1">
                Rp {{ number_format($totalDonasi ?? 0, 0, ',', '.') }}
            </h4>
        </div>
        <i data-lucide="heart" class="absolute -right-4 -bottom-4 w-24 h-24 opacity-10"></i>
    </div>

    <!-- FREKUENSI -->
    <div class="p-4 bg-slate-800 rounded-xl shadow-sm text-white relative overflow-hidden">
        <div class="relative z-10">
            <p class="text-sm font-medium opacity-80">Frekuensi Donasi</p>
            <h4 class="text-2xl font-bold mt-1">
                {{ $frekuensi }} Kali
            </h4>
        </div>
        <i data-lucide="heart-handshake" class="absolute -right-4 -bottom-4 w-24 h-24 opacity-10"></i>
    </div>

</div>
