@extends('layouts.navbar')
@section('title', 'Verifikasi Identitas - AkuPeduli')

@section('content')
<main x-data="{ 
    step: null, 
    otpSent: false,
    loading: false,
    verify(type) {
        this.loading = true;
        setTimeout(() => {
            this.loading = false;
            this.otpSent = true;
        }, 1500);
    }
}" class="min-h-screen bg-slate-50 pb-20 px-4 antialiased">
    
    <div class="h-24 md:h-32"></div>
    <div class="max-w-2xl mx-auto">
        <div class="relative flex items-center justify-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800 text-center">Verifikasi Identitas</h1>
        </div>
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 mb-5 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-blue-200/20 rounded-full blur-2xl"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-2">
                    <div class="p-2 bg-blue-500 rounded-xl shadow-sm shadow-blue-200">
                        <i data-lucide="lock" class="w-5 h-5 text-white"></i>
                    </div>
                    <h3 class="font-bold text-blue-900 text-base tracking-tight">Data Identitas Terlindungi</h3>
                </div>
                <p class="text-blue-800/80 text-sm text-justify md:text-sm leading-relaxed">
                    Verifikasi identitas digunakan untuk memastikan identitas penggalang dana valid dan memenuhi syarat dan ketentuan penggalangan dana. Kami menjamin kerahasiaan data Anda sepenuhnya.
                </p>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
            <div class="p-5 md:p-8 space-y-4">
                <div class="border-b border-slate-100 pb-4">
                    <button 
                        @click="step = (step === 'hp' ? null : 'hp'); otpSent = false" 
                        :class="step === 'hp' ? 'bg-blue-50 border-blue-100' : 'hover:bg-slate-50 border-transparent'" 
                        class="w-full flex items-center justify-between p-4 md:p-5 rounded-2xl border transition duration-200"
                    >
                        <div class="flex items-center gap-3 md:gap-4">
                            <div class="w-10 h-10 md:w-11 md:h-11 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                                <i data-lucide="phone" class="w-5 h-5"></i>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-slate-800">Nomor Handphone</p>
                                <p class="text-xs text-red-500 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                    Belum Terverifikasi
                                </p>
                            </div>
                        </div>
                        <i 
                            data-lucide="chevron-down" 
                            :class="step === 'hp' ? 'rotate-180 text-blue-500' : 'text-slate-300'"
                            class="w-5 h-5 transition-transform duration-300"
                        ></i>
                    </button>
                    <div x-show="step === 'hp'" x-collapse x-cloak>
                        <div class="pt-4 space-y-4">
                            <div x-show="!otpSent" class="flex flex-col sm:flex-row gap-2">
                                <input type="number" placeholder="Masukkan nomor WhatsApp" class="flex-1 px-4 py-3 bg-slate-50 rounded-xl focus:ring-1 focus:ring-blue-500 outline-none">
                                <button @click="verify('hp')" class="px-3 py-2 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition">
                                    <span x-text="loading ? 'Memproses...' : 'Kirim OTP'"></span>
                                </button>
                            </div>
                            <div x-show="otpSent" class="bg-blue-50 p-4 rounded-xl border border-blue-100 space-y-3">
                                <p class="text-sm text-blue-700">Kode OTP telah dikirim.</p>
                                <input type="number" placeholder="••••••" 
                                        class="w-full px-5 py-2 bg-slate-100 border-none rounded-xl text-center tracking-[1em] font-bold text-2xl text-slate-700 outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 placeholder:text-slate-400 placeholder:opacity-50">
                                <button class="w-full py-2 bg-blue-600 text-white font-semibold rounded-xl">
                                    Verifikasi
                                </button>
                                <p class="text-center text-xs text-slate-400">
                                    Tidak menerima kode? <button class="text-blue-600 font-semibold hover:underline">Kirim ulang</button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-b border-slate-100 pb-4">
                    <button 
                        @click="step = (step === 'email' ? null : 'email')" 
                        :class="step === 'email' ? 'bg-blue-50 border-blue-100' : 'hover:bg-slate-50 border-transparent'" 
                        class="w-full flex items-center justify-between p-4 md:p-5 rounded-2xl border transition duration-200"
                    >
                        <div class="flex items-center gap-3 md:gap-4">
                            <div class="w-10 h-10 md:w-11 md:h-11 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-slate-800">Email Aktif</p>
                                <p class="text-xs text-red-500 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                    Belum Terverifikasi
                                </p>
                            </div>
                        </div>
                        <i 
                            data-lucide="chevron-down" 
                            :class="step === 'email' ? 'rotate-180 text-blue-500' : 'text-slate-300'"
                            class="w-5 h-5 transition-transform duration-300"
                        ></i>
                    </button>

                    <div x-show="step === 'email'" x-collapse x-cloak>
                        <div class="pt-4 space-y-4">
                            <div x-show="!otpSent" class="space-y-3">
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <input type="email" placeholder="Masukkan email aktif" class="flex-1 px-4 py-3 bg-slate-50 rounded-xl focus:ring-1 focus:ring-blue-500 outline-none">
                                    <button @click="verify('email')" class="px-3 py-2 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition">
                                        <span x-text="loading ? 'Memproses...' : 'Kirim Link'"></span>
                                    </button>
                                </div>
                            </div>

                            <div x-show="otpSent" x-transition class="bg-blue-50 p-6 rounded-2xl border border-blue-100 text-center space-y-4">
                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto shadow-sm">
                                    <i data-lucide="send" class="w-8 h-8 text-blue-500"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-blue-900">Cek Email Kamu</h4>
                                    <p class="text-sm text-blue-700/80 leading-relaxed">
                                        Link konfirmasi telah dikirim. Silakan klik tombol <span class="font-bold">Konfirmasi</span> pada email tersebut untuk memverifikasi akun.
                                    </p>
                                </div>
                                
                                <div class="pt-2 border-t border-blue-200/50">
                                    <p class="text-xs text-slate-500 mb-2">Tidak menerima email?</p>
                                    <button @click="otpSent = false" class="text-sm text-blue-600 font-bold hover:underline">
                                        Kirim ulang link
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-b border-slate-100 pb-4">
                    <button 
                        @click="step = (step === 'ktp' ? null : 'ktp')" 
                        :class="step === 'ktp' ? 'bg-blue-50 border-blue-100' : 'hover:bg-slate-50 border-transparent'" 
                        class="w-full flex items-center justify-between p-4 md:p-5 rounded-2xl border transition duration-200"
                    >
                        <div class="flex items-center gap-3 md:gap-4">
                            <div class="w-10 h-10 md:w-11 md:h-11 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                <i data-lucide="contact-2" class="w-5 h-5"></i>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-slate-800">Kartu Identitas (KTP)</p>
                                <p class="text-xs text-red-500 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                    Belum Terverifikasi
                                </p>
                            </div>
                        </div>
                        <i 
                            data-lucide="chevron-down" 
                            :class="step === 'ktp' ? 'rotate-180 text-blue-500' : 'text-slate-300'"
                            class="w-5 h-5 transition-transform duration-300"
                        ></i>
                    </button>

                    <div x-show="step === 'ktp'" x-collapse x-cloak>
                        <div class="pt-5 pb-2 space-y-5">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-700 ml-1">Scan KTP</label>
                                    <div class="relative group">
                                        <input type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center group-hover:border-blue-400 group-hover:bg-blue-50 transition-all">
                                            <i data-lucide="image" class="w-8 h-8 text-slate-400 mx-auto mb-2 group-hover:text-blue-500"></i>
                                            <p class="text-xs font-medium text-slate-500 group-hover:text-blue-600">Unggah Foto KTP</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-700 ml-1">Selfie dengan KTP</label>
                                    <div class="relative group">
                                        <input type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center group-hover:border-blue-400 group-hover:bg-blue-50 transition-all">
                                            <i data-lucide="user-square" class="w-8 h-8 text-slate-400 mx-auto mb-2 group-hover:text-blue-500"></i>
                                            <p class="text-xs font-medium text-slate-500 group-hover:text-blue-600">Unggah Foto Selfie</p>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="bg-amber-50 rounded-xl p-3 border border-amber-100 flex gap-3">
                                <i data-lucide="info" class="w-5 h-5 text-amber-600 shrink-0"></i>
                                <p class="text-[11px] text-amber-800 leading-relaxed">
                                    Pastikan foto terlihat terang, tidak blur, dan data pada KTP terbaca dengan jelas oleh sistem.
                                </p>
                            </div>
                            <button class="w-full py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                                Simpan Identitas
                            </button>
                        </div>
                    </div>
                </div>
                <div class="border-b border-slate-100 pb-4">
                    <button 
                        @click="step = (step === 'bank' ? null : 'bank')" 
                        :class="step === 'bank' ? 'bg-blue-50 border-blue-100' : 'hover:bg-slate-50 border-transparent'" 
                        class="w-full flex items-center justify-between p-4 md:p-5 rounded-2xl border transition duration-200"
                    >
                        <div class="flex items-center gap-3 md:gap-4">
                            <div class="w-10 h-10 md:w-11 md:h-11 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                                <i data-lucide="landmark" class="w-5 h-5"></i>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-slate-800">Rekening Bank</p>
                                <p class="text-xs text-red-500 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                    Belum Terverifikasi
                                </p>
                            </div>
                        </div>
                        <i 
                            data-lucide="chevron-down" 
                            :class="step === 'bank' ? 'rotate-180 text-blue-500' : 'text-slate-300'"
                            class="w-5 h-5 transition-transform duration-300"
                        ></i>
                    </button>
                    <div x-show="step === 'bank'" x-collapse x-cloak>
                        <div class="pt-5 pb-2 space-y-5 px-1 ">
                            <div class="space-y-2" x-data="{ openBank: false, selected: 'Pilih Bank', selectedValue: '' }">
                                <label class="text-sm font-bold text-slate-700 ml-1">Nama Bank</label>
                                <div class="relative">
                                    <button 
                                        @click="openBank = !openBank" 
                                        type="button"
                                        :class="openBank ? 'ring-2 ring-blue-500 border-transparent bg-white shadow-sm' : 'border-slate-200 bg-slate-50'"
                                        class="w-full flex items-center justify-between px-4 py-3.5 border rounded-xl transition-all duration-300 outline-none"
                                    >
                                        <span :class="selectedValue ? 'text-slate-800 font-semibold' : 'text-slate-400'" x-text="selected"></span>
                                        <i 
                                            data-lucide="chevron-down"
                                            :class="openBank ? 'rotate-180 text-blue-500' : 'text-slate-300'"
                                            class="w-5 h-5 transition-transform duration-300"
                                        ></i>
                                    </button>
                                    <div 
                                        x-show="openBank" 
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-150"
                                        @click.away="openBank = false"
                                        class="absolute z-[60] w-full mt-2 bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden"
                                        style="display: none;"
                                    >
                                        <div class="max-h-60 overflow-y-auto py-2 custom-scrollbar">
                                            <template x-for="bank in [
                                                {id: 'bca', name: 'Bank Central Asia (BCA)'},
                                                {id: 'mandiri', name: 'Bank Mandiri'},
                                                {id: 'bni', name: 'Bank Negara Indonesia (BNI)'},
                                                {id: 'bri', name: 'Bank Rakyat Indonesia (BRI)'},
                                                {id: 'bsi', name: 'Bank Syariah Indonesia (BSI)'}
                                            ]">
                                                <div 
                                                    @click="selected = bank.name; selectedValue = bank.id; openBank = false"
                                                    class="px-4 py-3 text-sm font-medium text-slate-700 hover:bg-blue-600 hover:text-white cursor-pointer transition-colors flex items-center justify-between group"
                                                >
                                                    <span x-text="bank.name"></span>
                                                    <i data-lucide="check" x-show="selectedValue === bank.id" class="w-4 h-4 text-white"></i>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="bank_name" :value="selectedValue">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Nomor Rekening</label>
                                <input type="number" placeholder="Contoh: 1234567890" 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none focus:bg-white transition-all">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-sm font-bold text-slate-700 ml-1">Nama Pemilik Rekening</label>
                                <input type="text" placeholder="Sesuai nama di buku tabungan" 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none uppercase placeholder:capitalize focus:bg-white transition-all">
                            </div>
                            <div class="bg-blue-50 rounded-2xl p-4 border border-blue-100 flex gap-3">
                                <i data-lucide="shield-check" class="w-5 h-5 text-blue-600 shrink-0"></i>
                                <p class="text-xs text-blue-800 leading-relaxed">
                                    Dana hasil penggalangan hanya dapat dicairkan ke rekening yang telah terverifikasi atas nama pemilik akun untuk menjaga keamanan donatur.
                                </p>
                            </div>
                            <button class="w-full py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                                Simpan Rekening Bank
                            </button>
                        </div>
                    </div>
                </div>
                <p class="text-center text-slate-400 text-xs mt-10">
                    Tim kami akan meninjau data Anda dalam waktu maksimal <span class="font-bold text-slate-500">1x24 jam</span>.
                </p>
            </div>
        </div>
    </div>
</main>

<style>
    [x-cloak] { display: none !important; }
    html { scroll-behavior: smooth; }

    input:focus, select:focus {
        border-color: #3b82f6 !important;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>

@endsection