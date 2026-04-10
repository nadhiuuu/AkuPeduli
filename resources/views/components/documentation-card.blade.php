<div class="bg-white rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition duration-300 overflow-hidden flex flex-col h-full group">

    <a href="{{ route('dokumentasi.detail-dokumentasi') }}" class="relative block overflow-hidden">
        <img src="{{ $image ?? 'https://via.placeholder.com/400x250' }}" 
             class="w-full h-56 object-cover group-hover:scale-105 transition duration-500">
    </a>

    <div class="p-5 flex flex-col flex-grow">

        <h3 class="font-semibold text-base leading-snug line-clamp-2 text-gray-800 mb-2">
            <a href="{{ route('dokumentasi.detail-dokumentasi') }}" class="hover:text-blue-600 transition">
                {{ $title ?? 'Judul Dokumentasi' }}
            </a>
        </h3>

        <p class="text-sm text-gray-500 line-clamp-2 mb-4">
            {{ $description ?? 'Deskripsi dokumentasi singkat...' }}
        </p>

        <div class="mt-auto flex items-center justify-between border-t border-gray-300 pt-3">
            <div class="flex items-center gap-3">
                <img src="{{ $avatar ?? 'https://i.pravatar.cc/150' }}"
                     class="w-8 h-8 rounded-full object-cover">
                <div>
                    <p class="text-xs font-semibold text-gray-800">
                        {{ $author ?? 'Admin' }}
                    </p>
                    <p class="text-xs text-gray-400">
                        {{ $time ?? 'Baru saja' }}
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>