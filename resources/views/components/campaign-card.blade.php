<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <img src="{{ $image ?? 'https://via.placeholder.com/400x200' }}" alt="{{ $title ?? 'Campaign' }}" class="w-full h-48 object-cover">
    <div class="p-4">
        <h3 class="font-semibold text-lg mb-2">{{ $title ?? 'Title' }}</h3>
        <p class="text-sm text-gray-600 mb-4">{{ $description ?? 'Brief description of the campaign goes here.' }}</p>
        <div class="flex items-center justify-between">
            <span class="text-sm font-medium text-blue-600">{{ $raised ?? '0' }}/{{ $goal ?? '0' }}</span>
            <a href="#" class="text-sm text-white bg-blue-600 px-3 py-1 rounded">Donasi</a>
        </div>
    </div>
</div>