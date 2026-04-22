<div>
    <div class="h-24 md:h-32"></div>
    <div class="max-w-2xl mx-auto">
        <div class="relative flex items-center justify-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800 text-center">Verifikasi Identitas</h1>
        </div>

        @if($profile && $profile->status_verifikasi == 'disetujui')
            <div class="bg-green-50 border border-green-200 rounded-xl p-6 mb-5 text-center">
                <i data-lucide="check-circle" class="w-12 h-12 text-green-500 mx-auto mb-3"></i>
                <h3 class="font-bold text-green-900 mb-1">Verifikasi Berhasil</h3>
                <p class="text-green-800/80 text-sm">Identitas Anda telah diverifikasi oleh tim kami. Anda sekarang dapat membuat penggalangan dana.</p>
                <div class="mt-4">
                    <a href="{{ route('fundraising.index') }}" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition inline-block">Mulai Galang Dana</a>
                </div>
            </div>
        @elseif($profile && $profile->status_verifikasi == 'menunggu' && $ktp_verified && $bank_verified)
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 mb-5 text-center">
                <i data-lucide="clock" class="w-12 h-12 text-amber-500 mx-auto mb-3"></i>
                <h3 class="font-bold text-amber-900 mb-1">Dalam Proses Review</h3>
                <p class="text-amber-800/80 text-sm">Data identitas Anda sedang ditinjau oleh tim kami. Proses ini membutuhkan waktu maksimal 1x24 jam.</p>
            </div>
        @elseif($profile && $profile->status_verifikasi == 'ditolak')
             <div class="bg-red-50 border border-red-200 rounded-xl p-6 mb-5 text-center">
                <i data-lucide="x-circle" class="w-12 h-12 text-red-500 mx-auto mb-3"></i>
                <h3 class="font-bold text-red-900 mb-1">Verifikasi Ditolak</h3>
                <p class="text-red-800/80 text-sm mb-2">Maaf, data identitas Anda belum memenuhi kriteria kami.</p>
                <div class="mt-2 mb-3">
                    <p class="text-red-900 text-sm font-semibold p-3 bg-red-100/70 border border-red-200 rounded-lg inline-block">Alasan penolakan: {{ $profile->alasan_penolakan }}</p>
                </div>
                <div class="mt-4">
                    <button type="button" onclick="showCustomAlert('Reset Formulir', 'Data KTP sebelumnya akan dihapus, formulir akan direset. Anda yakin?', 'wire:resetVerification', 'Ya, Reset')" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition inline-flex items-center gap-2">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i> Isi Ulang Form
                    </button>
                </div>
            </div>
        @else
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
        @endif

        @if(!$profile || empty($profile->status_verifikasi) || ($profile->status_verifikasi == 'menunggu' && (!$ktp_verified || !$bank_verified)))
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
            <div class="p-5 md:p-8 space-y-4">
                
                {{-- HP --}}
                <div class="border-b border-slate-100 pb-4">
                    <button 
                        wire:click="setStep('hp')" 
                        class="w-full flex items-center justify-between p-4 md:p-5 rounded-2xl border transition duration-200 {{ $step === 'hp' ? 'bg-blue-50 border-blue-100' : 'hover:bg-slate-50 border-transparent' }}"
                    >
                        <div class="flex items-center gap-3 md:gap-4">
                            <div class="w-10 h-10 md:w-11 md:h-11 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                                <i data-lucide="phone" class="w-5 h-5"></i>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-slate-800">Nomor Handphone</p>
                                @if($wa_verified)
                                    <p class="text-xs text-green-600 flex items-center gap-1 font-semibold">
                                        <i data-lucide="check-circle" class="w-3 h-3"></i> Terverifikasi
                                    </p>
                                @else
                                    <p class="text-xs text-red-500 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Belum Terverifikasi
                                    </p>
                                @endif
                            </div>
                        </div>
                        <i data-lucide="chevron-down" class="w-5 h-5 transition-transform duration-300 {{ $step === 'hp' ? 'rotate-180 text-blue-500' : 'text-slate-300' }}"></i>
                    </button>
                    
                    @if($step === 'hp' && !$wa_verified)
                        <div class="pt-4 space-y-4 px-2">
                            @if(!$wa_otp_sent)
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <input wire:model="no_wa" type="number" placeholder="Masukkan nomor WhatsApp ex: 08123..." class="flex-1 px-4 py-3 bg-slate-50 rounded-xl focus:ring-1 focus:ring-blue-500 outline-none">
                                    <button wire:click="sendWaOtp" wire:loading.attr="disabled" class="px-3 py-2 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition disabled:opacity-50 min-w-[120px]">
                                        <span wire:loading.remove wire:target="sendWaOtp">Kirim OTP</span>
                                        <span wire:loading wire:target="sendWaOtp">Memproses...</span>
                                    </button>
                                </div>
                                @error('no_wa') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            @else
                                <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 space-y-3">
                                    <p class="text-sm text-blue-700">Kode OTP telah dikirim melalui WhatsApp.</p>
                                    <input wire:model="wa_otp" type="number" placeholder="••••••" 
                                            class="w-full px-5 py-2 bg-slate-100 border-none rounded-xl text-center tracking-[1em] font-bold text-2xl text-slate-700 outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                                    @error('wa_otp') <span class="text-red-500 text-xs block text-center">{{ $message }}</span> @enderror
                                    <button wire:click="verifyWaOtp" class="w-full py-2 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition">
                                        Verifikasi
                                    </button>
                                    <p class="text-center text-xs text-slate-500">
                                        Tidak menerima kode? <button wire:click="sendWaOtp" class="text-blue-600 font-semibold hover:underline">Kirim ulang</button>
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Email --}}
                <div class="border-b border-slate-100 pb-4">
                    <button 
                        wire:click="setStep('email')" 
                        class="w-full flex items-center justify-between p-4 md:p-5 rounded-2xl border transition duration-200 {{ $step === 'email' ? 'bg-blue-50 border-blue-100' : 'hover:bg-slate-50 border-transparent' }}"
                    >
                        <div class="flex items-center gap-3 md:gap-4">
                            <div class="w-10 h-10 md:w-11 md:h-11 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-slate-800">Email Aktif</p>
                                @if($email_verified)
                                    <p class="text-xs text-green-600 flex items-center gap-1 font-semibold">
                                        <i data-lucide="check-circle" class="w-3 h-3"></i> Terverifikasi
                                    </p>
                                @else
                                    <p class="text-xs text-red-500 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Belum Terverifikasi
                                    </p>
                                @endif
                            </div>
                        </div>
                        <i data-lucide="chevron-down" class="w-5 h-5 transition-transform duration-300 {{ $step === 'email' ? 'rotate-180 text-blue-500' : 'text-slate-300' }}"></i>
                    </button>

                        @if (session()->has('error'))
    <div class="p-3 mb-2 bg-red-100 text-red-600 rounded-lg text-xs font-semibold">
        {{ session('error') }}
    </div>
@endif

                    @if($step === 'email' && !$email_verified)
                        <div class="pt-4 space-y-4 px-2">
                             @if(!$email_otp_sent)
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <input wire:model="email_campaigner" type="email" placeholder="Masukkan email aktif" class="flex-1 px-4 py-3 bg-slate-50 rounded-xl focus:ring-1 focus:ring-blue-500 outline-none">
                                    <button wire:click="sendEmailOtp" wire:loading.attr="disabled" class="px-3 py-2 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition disabled:opacity-50 min-w-[120px]">
                                        <span wire:loading.remove wire:target="sendEmailOtp">Kirim OTP</span>
                                        <span wire:loading wire:target="sendEmailOtp">Memproses...</span>
                                    </button>
                                </div>
                                @error('email_campaigner') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            @else
                                <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 space-y-3">
                                    <p class="text-sm text-blue-700">Kode OTP 6-digit telah dikirim melalui Email.</p>
                                    <input wire:model="email_otp" type="number" placeholder="••••••" 
                                            class="w-full px-5 py-2 bg-slate-100 border-none rounded-xl text-center tracking-[1em] font-bold text-2xl text-slate-700 outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                                    @error('email_otp') <span class="text-red-500 text-xs block text-center">{{ $message }}</span> @enderror
                                    <button wire:click="verifyEmailOtp" class="w-full py-2 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition">
                                        Verifikasi
                                    </button>
                                    <p class="text-center text-xs text-slate-500">
                                        Tidak menerima kode? <button wire:click="sendEmailOtp" class="text-blue-600 font-semibold hover:underline">Kirim ulang</button>
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- KTP --}}
                <div class="border-b border-slate-100 pb-4">
                    <button 
                        wire:click="setStep('ktp')" 
                        class="w-full flex items-center justify-between p-4 md:p-5 rounded-2xl border transition duration-200 {{ $step === 'ktp' ? 'bg-blue-50 border-blue-100' : 'hover:bg-slate-50 border-transparent' }}"
                    >
                        <div class="flex items-center gap-3 md:gap-4">
                            <div class="w-10 h-10 md:w-11 md:h-11 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                <i data-lucide="contact-2" class="w-5 h-5"></i>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-slate-800">Kartu Identitas (KTP)</p>
                                @if($ktp_verified)
                                    <p class="text-xs text-green-600 flex items-center gap-1 font-semibold">
                                        <i data-lucide="check-circle" class="w-3 h-3"></i> Tersimpan
                                    </p>
                                @else
                                    <p class="text-xs text-red-500 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Belum Dilengkapi
                                    </p>
                                @endif
                            </div>
                        </div>
                        <i data-lucide="chevron-down" class="w-5 h-5 transition-transform duration-300 {{ $step === 'ktp' ? 'rotate-180 text-blue-500' : 'text-slate-300' }}"></i>
                    </button>

                    @if($step === 'ktp')
                        <form wire:submit.prevent="saveKtp" class="pt-5 pb-2 space-y-5 px-2">
                             <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Nomor Induk Kependudukan (NIK)</label>
                                <input wire:model="nik" type="number" placeholder="16 Digit NIK" 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none focus:bg-white transition-all">
                                @error('nik') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-700 ml-1">Scan KTP</label>
                                    <div class="relative group">
                                        <input wire:model="foto_ktp" type="file" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center group-hover:border-blue-400 group-hover:bg-blue-50 transition-all bg-slate-50">
                                            @if($foto_ktp)
                                                <i data-lucide="check" class="w-8 h-8 text-green-500 mx-auto mb-2"></i>
                                                <p class="text-xs font-medium text-green-600">File terpilih</p>
                                            @else
                                                <i data-lucide="image" class="w-8 h-8 text-slate-400 mx-auto mb-2 group-hover:text-blue-500"></i>
                                                <p class="text-xs font-medium text-slate-500 group-hover:text-blue-600">Unggah Foto KTP</p>
                                            @endif
                                        </div>
                                    </div>
                                    @error('foto_ktp') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-700 ml-1">Selfie dengan KTP</label>
                                    <div class="relative group">
                                        <input wire:model="foto_selfie_ktp" type="file" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center group-hover:border-blue-400 group-hover:bg-blue-50 transition-all bg-slate-50">
                                            @if($foto_selfie_ktp)
                                                <i data-lucide="check" class="w-8 h-8 text-green-500 mx-auto mb-2"></i>
                                                <p class="text-xs font-medium text-green-600">File terpilih</p>
                                            @else
                                                <i data-lucide="user-square" class="w-8 h-8 text-slate-400 mx-auto mb-2 group-hover:text-blue-500"></i>
                                                <p class="text-xs font-medium text-slate-500 group-hover:text-blue-600">Unggah Foto Selfie</p>
                                            @endif
                                        </div>
                                    </div>
                                    @error('foto_selfie_ktp') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="bg-amber-50 rounded-xl p-3 border border-amber-100 flex gap-3">
                                <i data-lucide="info" class="w-5 h-5 text-amber-600 shrink-0"></i>
                                <p class="text-[11px] text-amber-800 leading-relaxed">
                                    Pastikan foto terlihat terang, tidak blur, dan data pada KTP terbaca dengan jelas oleh sistem.
                                </p>
                            </div>
                            <button type="submit" class="w-full py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                                Simpan Identitas
                            </button>
                        </form>
                    @endif
                </div>

                {{-- Bank --}}
                <div class="border-b border-slate-100 pb-4">
                    <button 
                         wire:click="setStep('bank')" 
                        class="w-full flex items-center justify-between p-4 md:p-5 rounded-2xl border transition duration-200 {{ $step === 'bank' ? 'bg-blue-50 border-blue-100' : 'hover:bg-slate-50 border-transparent' }}"
                    >
                        <div class="flex items-center gap-3 md:gap-4">
                            <div class="w-10 h-10 md:w-11 md:h-11 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                                <i data-lucide="landmark" class="w-5 h-5"></i>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-slate-800">Rekening Bank</p>
                                @if($bank_verified)
                                    <p class="text-xs text-green-600 flex items-center gap-1 font-semibold">
                                        <i data-lucide="check-circle" class="w-3 h-3"></i> Tersimpan
                                    </p>
                                @else
                                    <p class="text-xs text-red-500 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Belum Dilengkapi
                                    </p>
                                @endif
                            </div>
                        </div>
                        <i data-lucide="chevron-down" class="w-5 h-5 transition-transform duration-300 {{ $step === 'bank' ? 'rotate-180 text-blue-500' : 'text-slate-300' }}"></i>
                    </button>
                    @if($step === 'bank')
                        <form wire:submit.prevent="saveBank" class="pt-5 pb-2 space-y-5 px-2">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Nama Bank</label>
                                <select wire:model="nama_bank" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none focus:bg-white transition-all">
                                    <option value="">Pilih Bank</option>
                                    <option value="bca">Bank Central Asia (BCA)</option>
                                    <option value="mandiri">Bank Mandiri</option>
                                    <option value="bni">Bank Negara Indonesia (BNI)</option>
                                    <option value="bri">Bank Rakyat Indonesia (BRI)</option>
                                    <option value="bsi">Bank Syariah Indonesia (BSI)</option>
                                </select>
                                @error('nama_bank') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Nomor Rekening</label>
                                <input wire:model="nomor_rekening" type="number" placeholder="Contoh: 1234567890" 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none focus:bg-white transition-all">
                                @error('nomor_rekening') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-sm font-bold text-slate-700 ml-1">Nama Pemilik Rekening</label>
                                <input wire:model="nama_pemilik" type="text" placeholder="Sesuai nama di buku tabungan" 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none uppercase placeholder:capitalize focus:bg-white transition-all">
                                @error('nama_pemilik') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="bg-blue-50 rounded-2xl p-4 border border-blue-100 flex gap-3">
                                <i data-lucide="shield-check" class="w-5 h-5 text-blue-600 shrink-0"></i>
                                <p class="text-xs text-blue-800 leading-relaxed">
                                    Dana hasil penggalangan hanya dapat dicairkan ke rekening yang telah terverifikasi atas nama pemilik akun untuk menjaga keamanan donatur.
                                </p>
                            </div>
                            <button type="submit" class="w-full py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                                Simpan Rekening Bank
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endif
        
        <div class="mt-8 text-center text-slate-400 text-xs">
            Tim kami akan meninjau data Anda dalam waktu maksimal <span class="font-bold text-slate-500">1x24 jam</span>.
        </div>
    <x-alert-modal />
</div>

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
