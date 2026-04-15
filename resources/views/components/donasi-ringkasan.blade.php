@props(['campaign', 'percentage', 'daysLeft'])

<div class="mb-3">
    <h2 class="text-2xl font-bold text-center text-slate-900 mb-3 font-primary">Kamu Akan Berdonasi</h2> 
    
    <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm flex flex-col md:flex-row gap-5 items-center">
        <img src="{{ asset('storage/' . $campaign->image) }}" class="w-full md:w-40 h-28 object-cover rounded-xl shadow-sm">
        
        <div class="flex-1 w-full">
            <h3 class="font-bold text-base text-slate-900 leading-tight mb-2">{{ $campaign->title }}</h3>
            
            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                <div class="bg-blue-600 h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
            </div>
            
            <div class="flex justify-between mt-3">
                <div class="text-left">
                    <p class="text-[10px] text-slate-400 uppercase font-bold">Terkumpul</p>
                    <p class="text-sm font-bold text-blue-600">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] text-slate-400 uppercase font-bold">Sisa Hari</p>
                    <p class="text-sm font-bold text-slate-800">{{ $daysLeft }} Hari</p>
                </div>
            </div>
        </div>
    </div>
</div>