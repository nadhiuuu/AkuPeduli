<div x-data="{ agreed: false }" x-show="showModal"
    class="fixed inset-0 z-[99] flex items-center justify-center p-4 overflow-y-auto" x-cloak>
    <div x-show="showModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" @click="showModal = false"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

    <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        class="relative bg-white w-full max-w-lg rounded-[2.5rem] p-8 md:p-12 shadow-2xl text-center">
        <h3 class="text-2xl font-bold text-slate-800 mb-4">Persetujuan Galang Dana</h3>
        <p class="text-slate-500 mb-5 leading-relaxed text-sm">
            Pastikan Anda telah memahami tanggung jawab dan ketentuan dalam penggalangan dana agar bantuan tersalurkan
            dengan tepat.
        </p>

        <label class="flex items-start gap-3 text-left mb-8 cursor-pointer group">
            <div class="relative flex items-center mt-1">
                <input type="checkbox" x-model="agreed"
                    class="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded border border-slate-300 checked:bg-blue-600 checked:border-blue-600">
                <svg class="absolute w-4 h-4 text-white p-0.5 peer-checked:block hidden"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            <span class="text-sm text-slate-600 leading-tight">
                Saya telah membaca dan menyetujui <a href="#" class="text-blue-600 underline font-semibold">Syarat dan
                    Ketentuan</a> yang berlaku untuk melakukan penggalangan dana.
            </span>
        </label>

        <button :disabled="!agreed"
            :class="agreed ? 'bg-blue-600 hover:bg-blue-700 shadow-blue-200' : 'bg-slate-200 text-slate-400 cursor-not-allowed'"
            class="w-full py-3 rounded-2xl font-bold text-white transition-all duration-300 shadow-lg" @click="
                if (isVerified) {
                    window.location.href = '{{ $route }}'
                } else {
                    showModal = false;
                    setTimeout(() => { showVerifyModal = true; }, 300);
                }
            ">
            Galang Dana Sekarang
        </button>

        <button @click="showModal = false"
            class="mt-4 text-slate-400 text-sm font-medium hover:text-slate-600 transition-colors">
            Batal
        </button>
    </div>
</div>