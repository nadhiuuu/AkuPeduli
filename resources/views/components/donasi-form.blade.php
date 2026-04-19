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
        
        <p class="text-sm text-slate-400 mb-3 ml-1 italic">Atau masukkan nominal lainnya</p>
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
            <input type="text" value="{{ auth()->user()->name ?? '' }}" readonly
                class="w-full px-6 py-4 bg-slate-100 border border-slate-200/50 rounded-xl outline-none text-sm font-semibold text-slate-500 cursor-not-allowed shadow-sm shadow-slate-100/50">
            
            <input type="email" value="{{ auth()->user()->email ?? '' }}" readonly
                class="w-full px-6 py-4 bg-slate-100 border border-slate-200/50 rounded-xl outline-none text-sm font-semibold text-slate-500 cursor-not-allowed shadow-sm shadow-slate-100/50">
            
            <label class="flex items-center gap-3 cursor-pointer mt-2 group">
                <input type="checkbox" name="is_anonymous" value="1" 
                    class="w-5 h-5 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer transition-all">
                <span class="text-sm font-medium text-slate-600 group-hover:text-blue-600 transition-colors">
                    Sembunyikan nama saya (Donasi sebagai Anonim)
                </span>
            </label>
        </div>
    </div>
</div>