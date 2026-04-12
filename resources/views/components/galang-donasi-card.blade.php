<div class="bg-white rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition duration-300 overflow-hidden flex flex-col h-full border border-slate-200/50">
    <div class="relative block overflow-hidden">
        <a href="{{ route('donation.detail') }}">
            <img src="{{ $image ?? 'https://via.placeholder.com/400x200' }}" 
                 class="w-full h-48 object-cover hover:scale-105 transition duration-500">
        </a>

        <div class="absolute top-4 left-4 pointer-events-none">
            @if(($status ?? 'pending') == 'pending')
                <span class="bg-amber-50 text-amber-600 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider border border-amber-100 shadow-sm">
                    Belum Terverifikasi
                </span>
            @elseif($status == 'active')
                <span class="bg-emerald-50 text-emerald-600 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider border border-emerald-100 shadow-sm">
                    Terverifikasi
                </span>
            @elseif($status == 'rejected')
                <span class="bg-red-50 text-red-600 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider border border-red-100 shadow-sm">
                    Tidak Terverifikasi
                </span>
            @endif
        </div>

        <div x-data="{ open: false }" class="absolute top-3 right-3 z-50">
            <button @click.stop="open = !open" 
                    @click.outside="open = false"
                    type="button"
                    class="p-2 rounded-full bg-black/40 hover:bg-black/60 text-white transition shadow-md flex items-center justify-center focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                </svg>
            </button>

            <div x-show="open" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 py-2">
                <a href="{{ route('donation.detail') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                    Lihat Campaign
                </a>
                <a href="{{ route('documentation.create') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                    Update Berita
                </a>
                <a href="#" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                    Pencairan Dana
                </a>
            </div>
        </div>
    </div>

    <div class="p-4 flex flex-col flex-grow space-y-3">
        <h3 class="font-semibold text-base line-clamp-2 leading-snug">
            <a href="{{ route('donation.detail') }}" class="hover:text-blue-600 transition-colors">
                {{ $title ?? 'Judul Campaign Donasi' }}
            </a>
        </h3>
        
        <p class="text-sm text-slate-500 line-clamp-2">
            {{ $description ?? 'Deskripsi singkat campaign untuk menarik perhatian donatur.' }}
        </p>

        <div class="mt-auto">
            <div class="w-full bg-slate-200 rounded-full h-1.5 mb-2">
                <div class="bg-blue-600 h-1.5 rounded-full transition-all duration-500"
                     style="width: {{ min($percentage ?? 0, 100) }}%">
                </div>
            </div>
        </div>

        <div class="flex justify-between text-xs md:text-sm">
            <div class="flex flex-col">
                <span class="text-gray-400 text-[12px] uppercase font-bold tracking-widest">Terkumpul</span>
                <span class="font-bold text-blue-600">
                    Rp {{ number_format($raised ?? 0, 0, ',', '.') }}
                </span>
            </div>
            <div class="flex flex-col text-right">
                <span class="text-slate-400 text-[12px] uppercase font-bold tracking-wider">Target</span>
                <span class="text-slate-600 font-medium">
                    Rp {{ number_format($goal ?? 0, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <div class="flex justify-between items-center pt-2 border-t border-slate-50 text-[14px] text-gray-400">
            <span class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                {{ rand(10,200) }} Donatur
            </span>
            <span class="bg-gray-100 px-2 py-0.5 rounded text-gray-500 italic">
                {{ rand(1,30) }} hari lagi
            </span>
        </div>
    </div>
</div>