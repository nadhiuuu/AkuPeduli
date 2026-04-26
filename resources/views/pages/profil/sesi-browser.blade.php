<div x-show="tab === 'sessions'" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-cloak
    x-data="{ confirmLogout: false }">

    <div class="mb-2">
        <h3 class="text-xl font-bold text-slate-800">Sesi Browser</h3>
        <p class="text-sm text-slate-500">Kelola dan keluar dari sesi aktif Anda di browser dan perangkat lain.</p>
    </div>

    <div class="flex flex-col sm:flex-row items-center gap-6 p-4 bg-slate-50 rounded-xl border border-slate-100">
        <div class="w-full space-y-3">
            <div class="text-sm text-slate-600 leading-relaxed">
                Jika perlu, Anda dapat keluar dari semua sesi browser Anda di semua perangkat. Beberapa sesi terbaru
                Anda terdaftar di bawah; daftar ini mungkin tidak lengkap. Jika Anda merasa akun Anda telah
                dikompromikan, perbarui kata sandi Anda.
            </div>

            <div class="space-y-4">
                <div class="flex items-center gap-4 p-5 bg-blue-50/50 border border-blue-100 rounded-2xl">
                    <div class="text-blue-600 bg-white p-3 rounded-xl shadow-sm">
                        <i data-lucide="monitor" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="font-bold text-slate-800">Windows - Chrome</h4>
                            <span
                                class="px-2 py-0.5 bg-green-100 text-green-700 text-[10px] font-bold rounded-md uppercase">Perangkat
                                Ini</span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium">127.0.0.1, <span class="text-blue-600">Aktif
                                sekarang</span></p>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-5 bg-white border border-slate-100 rounded-2xl">
                    <div class="text-slate-400 bg-slate-50 p-3 rounded-xl">
                        <i data-lucide="smartphone" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-700 font-medium">iPhone - Safari</h4>
                        <p class="text-xs text-slate-500 font-medium">192.168.1.1, Sesi terakhir 2 jam yang lalu</p>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-3 justify-end">
                <button type="submit" 
                    @click="confirmLogout = true" class="px-10 py-3 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 active:scale-95 transition-all">
                    Keluar dari Sesi Browser Lain
                </button>
            </div>
        </div>

        <div x-show="confirmLogout"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-cloak>

            <div class="bg-white rounded-2xl p-6 max-w-md w-full shadow-2xl" @click.away="confirmLogout = false">
                <h3 class="text-lg font-bold text-slate-800 mb-2">Konfirmasi Keluar Sesi</h3>
                <p class="text-sm text-slate-600 mb-6">Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda
                    ingin keluar dari sesi browser Anda yang lain di semua perangkat Anda.</p>

                <input type="password"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none mb-6"
                    placeholder="Kata Sandi Anda">

                <div class="flex justify-end gap-3">
                    <button @click="confirmLogout = false"
                        class="px-5 py-2.5 text-sm font-bold text-slate-500 hover:bg-slate-50 rounded-lg transition-all">Batal</button>
                    <button
                        class="px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>
</div>