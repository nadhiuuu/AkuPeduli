@extends('layouts.navbar')
@section('title', 'Daftar Campaign Donasi di Jember - AkuPeduli')
@section('content')

@php
    $catList = [
        'Banjir', 'Tanah Longsor', 'Angin Kencang/Puting Beliung', 
        'Gempa Bumi', 'Tsunami', 'Gunung Meletus'
    ];

    $campaigns = [];
    $locations = [
        [-8.1724, 113.7003], [-8.2000, 113.6500], [-8.1500, 113.7200], [-8.1844, 113.6675],
        [-8.1234, 113.7123], [-8.2150, 113.6300], [-8.1600, 113.7500], [-8.2300, 113.6800],
        [-8.1900, 113.7300], [-8.1400, 113.6900]
    ];

    for ($i = 0; $i < 10; $i++) {
        $raised = rand(1000000, 5000000);
        $goal = 10000000;
        $randomCategory = $catList[array_rand($catList)];

        $campaigns[] = [
            'title' => "Campaign Jember #" . ($i + 1),
            'description' => "Bantuan untuk masyarakat Jember yang membutuhkan.",
            'category' => $randomCategory,
            'raised' => $raised,
            'goal' => $goal,
            'percentage' => ($raised / $goal) * 100,
            'image' => "https://i.pravatar.cc/400?img=" . $i,
            'lat' => $locations[$i][0],
            'lng' => $locations[$i][1],
        ];
    }
@endphp

<main class="pt-30" x-data="{ activeCategory: 'Semua' }">
    
    <section class="pb-20">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-2">
                Peta Kebutuhan Bantuan - Jember
            </h2>
            <p class="text-center text-gray-500 mb-6">
                Pilih lokasi untuk melihat campaign yang membutuhkan bantuan
            </p>
            <x-campaign-map :campaigns="$campaigns" />
        </div>
    </section>

    <section class="pb-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-2">
                Semua Campaign
            </h2>
            <p class="text-center text-gray-500 mb-6">
                Sedikit kebaikan dari kita adalah harapan besar bagi mereka yang membutuhkan. Ayo berdonasi sekarang!
            </p>
            
            <div class="flex flex-wrap justify-center gap-2 md:gap-3 mb-10">
                @php
                    $categories = array_merge(['Semua'], $catList);
                @endphp

                @foreach($categories as $cat)
                    <button 
                        @click="activeCategory = '{{ $cat }}'" 
                        :class="activeCategory === '{{ $cat }}' 
                                ? 'bg-blue-600 text-white shadow-md shadow-blue-200 border-blue-600' 
                                : 'bg-white text-slate-600 border-slate-200 hover:border-blue-400 hover:text-blue-600'"
                        class="px-5 py-2 rounded-full text-xs md:text-sm font-semibold transition-all border outline-none">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($campaigns as $item)
                    <div x-show="activeCategory === 'Semua' || activeCategory === '{{ $item['category'] }}'"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100" 
                        class="h-full">
                        
                        <x-campaign-card 
                            :title="$item['title']" 
                            :description="$item['description']" 
                            :category="$item['category']"
                            :raised="$item['raised']"
                            :goal="$item['goal']" 
                            :percentage="$item['percentage']" 
                            :image="$item['image']" 
                        />
                    </div>
                @endforeach
            </div>

            <div x-cloak x-show="activeCategory !== 'Semua' && !Array.from($el.parentElement.querySelectorAll('.grid > div')).some(el => el.style.display !== 'none')"
                class="text-center py-12">
                <p class="text-slate-400 font-medium">Belum ada campaign untuk kategori ini.</p>
            </div>
        </div>
    </section>

</main>

@include('layouts.footer')
@endsection