<div x-show="tab === 'password'" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-4"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-cloak
     x-data="{ showCurrent: false, showNew: false, showConfirm: false }"
     x-init="$nextTick(() => lucide.createIcons())">
    
    <div class="mb-8">
        <h3 class="text-xl font-bold text-slate-800">Perbarui Kata Sandi</h3>
        <p class="text-sm text-slate-500">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk keamanan.</p>
    </div>

    <form action="#" method="POST" class="space-y-6 w-full">
        @csrf
        @method('PUT')

        <div class="space-y-2">
            <label class="text-sm font-bold text-slate-700 ml-1">
                Kata Sandi Saat Ini <span class="text-red-500">*</span>
            </label>
            <div class="relative group">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-500 transition-colors">
                    <i data-lucide="key-round" class="w-5 h-5"></i>
                </span>

                <input :type="showCurrent ? 'text' : 'password'" name="current_password" required
                    class="w-full pl-11 pr-12 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700"
                    placeholder="••••••••">

                <button type="button"
                        @click="showCurrent = !showCurrent; $nextTick(() => lucide.createIcons())"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                    <i :data-lucide="showCurrent ? 'eye-off' : 'eye'" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 ml-1">
                    Kata Sandi Baru <span class="text-red-500">*</span>
                </label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-500 transition-colors">
                        <i data-lucide="lock" class="w-5 h-5"></i>
                    </span>

                    <input :type="showNew ? 'text' : 'password'" name="password" required
                        class="w-full pl-11 pr-12 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700"
                        placeholder="••••••••">

                    <button type="button"
                            @click="showNew = !showNew; $nextTick(() => lucide.createIcons())"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                        <i :data-lucide="showNew ? 'eye-off' : 'eye'" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 ml-1">
                    Konfirmasi Kata Sandi <span class="text-red-500">*</span>
                </label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-500 transition-colors">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </span>

                    <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required
                        class="w-full pl-11 pr-12 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700"
                        placeholder="••••••••">

                    <button type="button"
                            @click="showConfirm = !showConfirm; $nextTick(() => lucide.createIcons())"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                        <i :data-lucide="showConfirm ? 'eye-off' : 'eye'" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-3 justify-end">
            <button type="submit" class="px-10 py-3 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 active:scale-95 transition-all">
                Perbarui Kata Sandi
            </button>
        </div>
    </form>
</div>