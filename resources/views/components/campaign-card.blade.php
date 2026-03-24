<div class="bg-white rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition duration-300 overflow-hidden">

    <div class="relative">
        <img src="{{ $image ?? 'https://via.placeholder.com/400x200' }}" 
             class="w-full h-48 object-cover">
    </div>

    <div class="p-4 space-y-3">

        <h3 class="font-semibold text-base line-clamp-2">
            {{ $title ?? 'Judul Campaign Donasi' }}
        </h3>

        <p class="text-sm text-gray-500 line-clamp-2">
            {{ $description ?? 'Deskripsi singkat campaign untuk menarik perhatian donatur.' }}
        </p>

        <div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full"
                     style="width: {{ min($percentage ?? 50, 100) }}%">
                </div>
            </div>
        </div>

        <div class="flex justify-between text-sm">
            <span class="font-semibold text-blue-600">
                Rp {{ number_format($raised ?? 0, 0, ',', '.') }}
            </span>
            <span class="text-gray-500">
                dari Rp {{ number_format($goal ?? 0, 0, ',', '.') }}
            </span>
        </div>

        <div class="flex justify-between text-sm text-gray-400">
            <span>{{ rand(10,200) }} donatur</span>
            <span>{{ rand(1,30) }} hari lagi</span>
        </div>

        <div class="pt-2">
            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition">
                Donasi
            </button>
        </div>

    </div>
</div>