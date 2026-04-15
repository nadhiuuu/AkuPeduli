<div class="space-y-3">
    <div class="bg-white p-5 md:p-8 rounded-xl border border-slate-100 shadow-sm">
        <label class="block text-base font-bold text-slate-700 mb-5">Pilih Nominal Donasi (Rp)</label>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
            @foreach(['1000', '5000', '10000', '20000', '50000', '100000', '200000', '500000'] as $val)
                <button type="button" 
                    class="btn-nominal py-3 px-1 border-1 border-slate-50 rounded-2xl text-xs font-bold text-slate-700 hover:border-blue-600 hover:text-blue-600 hover:bg-blue-50 transition-all active:scale-95"
                    data-nominal="{{ $val }}">
                    Rp {{ number_format($val, 0, ',', '.') }}
                </button>
            @endforeach
        </div>
        
        <p class="text-[11px] text-slate-400 mb-3 ml-1 italic">Atau masukkan nominal lainnya (Min. Rp 10.000)</p>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                <span class="text-slate-400 font-bold text-lg">Rp</span>
            </div>
            <input type="text" id="input-nominal" name="amount" 
                class="block w-full pl-14 pr-4 py-4 bg-white border border-slate-200/50 rounded-xl focus:ring-2 focus:ring-blue-600/20 focus:border-blue-500 focus:outline-none font-bold text-xl text-slate-700 placeholder-slate-300 transition-all shadow-sm shadow-slate-100/50" 
                placeholder="0">
        </div>
    </div>

    <div class="bg-white p-5 md:p-8 rounded-xl border border-slate-100 shadow-sm space-y-5">
        <h4 class="text-base font-bold text-slate-700">Data Diri Anda</h4>
        <div class="space-y-4">
            <input type="text" placeholder="Nama Lengkap" 
                class="w-full px-6 py-4 bg-white border border-slate-200/50 rounded-xl outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-500 text-sm font-medium text-slate-700 placeholder-slate-300 transition-all shadow-sm shadow-slate-100/50">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="email" placeholder="Email" 
                    class="w-full px-6 py-4 bg-white border border-slate-200/50 rounded-xl outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-500 text-sm font-medium text-slate-700 placeholder-slate-300 transition-all shadow-sm shadow-slate-100/50">
                
                <input type="tel" placeholder="Nomor WhatsApp" 
                    class="w-full px-6 py-4 bg-white border border-slate-200/50 rounded-xl outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-500 text-sm font-medium text-slate-700 placeholder-slate-300 transition-all shadow-sm shadow-slate-100/50">
            </div>
        </div>
    </div>

    <div class="bg-white px-8 py-5 rounded-xl border border-slate-100 shadow-sm flex items-center justify-between group cursor-pointer hover:bg-slate-50 transition-all">
        <div class="flex items-center gap-3">
            <span class="text-base font-bold text-slate-700">Pilih Metode Pembayaran</span>
        </div>
        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" class="h-5 group-hover:opacity-100 transition-all">
    </div>
</div>