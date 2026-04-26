<div x-show="tab === 'profile'" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-4"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-cloak>
    
    <div class="mb-8">
        <h3 class="text-xl font-bold text-slate-800">Informasi Profil</h3>
        <p class="text-sm text-slate-500">Perbarui informasi dasar dan alamat email akun Anda.</p>
    </div>

    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        <div class="flex flex-col sm:flex-row items-center gap-6 p-6 bg-slate-50 rounded-xl border border-slate-100">
            <div class="relative group">
                <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-md bg-white">
                    <img id="avatar-preview" 
                         src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=7F9CF5&background=EBF4FF" 
                         alt="Profile" 
                         class="w-full h-full object-cover">
                </div>
                <label for="avatar-input" class="absolute inset-0 flex items-center justify-center bg-black/40 text-white rounded-full opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity">
                    <i data-lucide="camera" class="w-6 h-6"></i>
                </label>
                <input type="file" id="avatar-input" class="hidden" accept="image/*">
            </div>
            
            <div class="text-center sm:text-left">
                <h4 class="font-bold text-slate-800">Foto Profil</h4>
                <p class="text-xs text-slate-500 mb-3">PNG, JPG atau GIF (Maks. 5MB)</p>
                <div class="flex gap-2">
                    <button type="button" class="px-5 py-2 bg-white border border-red-100 text-red-600 text-xs font-bold rounded-lg hover:bg-red-50 transition-colors shadow-xs">
                        Hapus Foto Profil
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 ml-1">Nama Lengkap</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                        <i data-lucide="user" class="w-5 h-5"></i>
                    </span>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" 
                        class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700 font-medium"
                        placeholder="Masukkan nama lengkap">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 ml-1">Alamat Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                    </span>
                    <input type="email" name="email" value="{{ auth()->user()->email }}" 
                        class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700 font-medium"
                        placeholder="nama@email.com">
                </div>
                @if(auth()->user()->email_verified_at)
                    <p class="text-[10px] text-green-600 flex items-center gap-1 ml-1 font-medium">
                        <i data-lucide="check-circle" class="w-3 h-3"></i>
                        Email terverifikasi
                    </p>
                @endif
            </div>
        </div>

        <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-3 justify-end">
            <button type="submit" class="px-10 py-3 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 active:scale-95 transition-all">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>