<div class="bg-white rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition duration-300 overflow-hidden flex flex-col h-full group">
    <a href="{{ route('donation.detail') }}" class="relative block overflow-hidden">
        <div class="absolute top-3 left-3 z-10">
            <span class="bg-blue-600/90 backdrop-blur-sm text-white text-[10px] font-bold px-2.5 py-1 rounded-lg uppercase tracking-wider shadow-sm">
                {{ $category ?? 'Bencana Alam' }}
            </span>
        </div>
        
        <img src="{{ $image ?? 'https://via.placeholder.com/400x200' }}" 
             class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
    </a>

    <div class="p-4 flex flex-col flex-grow space-y-3">
        <h3 class="font-semibold text-base line-clamp-2 leading-snug">
            <a href="{{ route('donation.detail') }}" class="hover:text-blue-600 transition-colors">
                {{ $title ?? 'Judul Campaign Donasi' }}
            </a>
        </h3>
        <p class="text-sm text-gray-500 line-clamp-2">
            {{ $description ?? 'Deskripsi singkat campaign untuk menarik perhatian donatur.' }}
        </p>
        <div class="mt-auto">
            <div class="w-full bg-gray-200 rounded-full h-1.5 mb-2">
                <div class="bg-blue-600 h-1.5 rounded-full transition-all duration-500"
                     style="width: {{ min($percentage ?? 0, 100) }}%">
                </div>
            </div>
        </div>
        <div class="flex justify-between text-xs md:text-sm">
            <div class="flex flex-col">
                <span class="text-gray-400 text-[12px] uppercase font-bold tracking-wider">Terkumpul</span>
                <span class="font-bold text-blue-600">
                    Rp {{ number_format($raised ?? 0, 0, ',', '.') }}
                </span>
            </div>
            <div class="flex flex-col text-right">
                <span class="text-gray-400 text-[12px] uppercase font-bold tracking-wider">Target</span>
                <span class="text-gray-600 font-medium">
                    Rp {{ number_format($goal ?? 0, 0, ',', '.') }}
                </span>
            </div>
        </div>
        <div class="flex justify-between items-center pt-2 border-t border-gray-50 text-[14px] text-gray-400">
            <span class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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