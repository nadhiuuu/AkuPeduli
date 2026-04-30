@extends('layouts.navbar')
@section('title', 'Daftar Campaign Donasi di Jember - AkuPeduli')
@section('content')

<main class="pt-30" x-data="{ activeCategory: 'Semua' }">
    
    <section class="pb-20">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-2">
                Peta Kebutuhan Bantuan - Jember
            </h2>
            <p class="text-center text-gray-500 mb-6">
                Pilih lokasi untuk melihat campaign yang membutuhkan bantuan
            </p>
            <x-campaign-map :campaigns="$mapCampaigns" :regions="$mapRegions" />
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
                    // Menggabungkan tombol "Semua" dengan daftar kategori dari database
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
                    <div class="campaign-item h-full" data-category="{{ $item['category'] }}" 
                        x-show="activeCategory === 'Semua' || activeCategory === '{{ $item['category'] }}'"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100" 
                        class="h-full">
                        
                        <x-campaign-card
                            :slug="$item['slug']" 
                            :title="$item['title']" 
                            :description="$item['description']" 
                            :category="$item['category']"
                            :raised="$item['raised']"
                            :goal="$item['goal']" 
                            :percentage="$item['percentage']" 
                            :image="$item['image']" 
                            :donors="$item['donors_count']"
                            :daysLeft="$item['days_left']"
                        />
                    </div>
                @endforeach
            </div>

            <div x-cloak 
                 x-show="activeCategory !== 'Semua' && !Array.from(document.querySelectorAll('.campaign-item')).some(el => el.dataset.category === activeCategory)"
                 class="text-center py-12">
                <p class="text-slate-400 font-medium text-lg">Belum ada campaign untuk kategori ini.</p>
            </div>
        </div>
    </section>

</main>

@include('layouts.footer')
@endsection
