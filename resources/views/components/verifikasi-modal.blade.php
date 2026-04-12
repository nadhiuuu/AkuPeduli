<div 
    x-show="showVerifyModal" 
    x-cloak
    class="fixed inset-0 z-[100] flex items-center justify-center p-4"
>
    <div 
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
        @click="showVerifyModal = false"
    ></div>

    <div 
        x-show="showVerifyModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        class="relative bg-white w-full max-w-md rounded-xl p-8 shadow-2xl"
    >
        <h3 class="text-xl font-bold text-slate-900 mb-2">Identitas Belum Terverifikasi</h3>
        <p class="text-slate-500 text-sm mb-3">Segera verifikasi identitas kamu untuk dapat membuat galang dana.</p>

        <div class="bg-red-200 rounded-xl p-4 mb-8 text-red-900 shadow-lg">
            <h4 class="font-bold mb-2">Data yang perlu dilengkapi :</h4>
            <ul class="space-y-2 text-sm">
                <li class="flex items-center gap-1">
                    <span class="w-1.5 h-1.5 bg-red-900 rounded-full"></span> Nomor Handphone
                </li>
                <li class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-red-900 rounded-full"></span> Email
                </li>
                <li class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-red-900 rounded-full"></span> Kartu Tanda Penduduk
                </li>
                <li class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-red-900 rounded-full"></span> Nomor rekening bank
                </li>
            </ul>
        </div>

        <div class="flex justify-end items-center gap-6 font-bold">
            <button 
                @click="showVerifyModal = false"
                class="text-gray-400 hover:text-gray-600 transition"
            >
                Tutup
            </button>
            <a href="{{ route('fundraising.verification') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md shadow-blue-100">
                Verifikasi Sekarang
            </a>
        </div>
    </div>
</div>