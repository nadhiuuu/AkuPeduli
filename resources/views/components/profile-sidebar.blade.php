<aside class="w-full md:w-1/4">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <h2 class="font-bold text-slate-800 text-lg">Pengaturan</h2>
            <p class="text-xs text-slate-500">Kelola akun dan aktivitas Anda</p>
        </div>

        <nav class="p-2 space-y-1">
            <button @click="tab = 'profile'" 
                :class="tab === 'profile' ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50'" 
                class="flex items-center gap-3 w-full px-4 py-3 text-sm font-semibold rounded-xl transition-all group">
                <i data-lucide="user"
                    class="w-5 h-5 transition-colors"
                    :class="tab === 'profile' ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600'">
                </i>
                Informasi Profil
            </button>

            <button @click="tab = 'donations'" 
                :class="tab === 'donations' ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50'" 
                class="flex items-center gap-3 w-full px-4 py-3 text-sm font-semibold rounded-xl transition-all group">
                <i data-lucide="heart"
                    class="w-5 h-5 transition-colors"
                    :class="tab === 'donations' ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600'">
                </i>
                Donasi Saya
            </button>

            <button @click="tab = 'password'" 
                :class="tab === 'password' ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50'" 
                class="flex items-center gap-3 w-full px-4 py-3 text-sm font-semibold rounded-xl transition-all group">
                <i data-lucide="lock"
                    class="w-5 h-5 transition-colors"
                    :class="tab === 'password' ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600'">
                </i>
                Kata Sandi
            </button>

            <button @click="tab = 'sessions'" 
                :class="tab === 'sessions' ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50'" 
                class="flex items-center gap-3 w-full px-4 py-3 text-sm font-semibold rounded-xl transition-all group">
                <i data-lucide="monitor"
                    class="w-5 h-5 transition-colors"
                    :class="tab === 'sessions' ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600'">
                </i>
                Sesi Browser
            </button>
        </nav>
    </div>
</aside>