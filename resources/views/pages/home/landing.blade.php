@extends('layouts.app')
@section('title', 'AkuPeduli! - Wujudkan Kepedulian Melalui Donasi')
@section('content')

<!-- Hero Section -->
<section class="relative text-white overflow-hidden min-h-screen flex items-start md:items-center pt-15">
    <div class="absolute inset-0">
        <img src="{{ asset('assets/Background.jpg') }}" 
             class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-b md:bg-gradient-to-r from-blue-900/90 via-blue-800/70 to-transparent"></div>
    </div>
    <div class="relative w-full max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 pt-32 pb-10 md:py-0">   
        <div class="max-w-2xl"> 
            <h1 class="text-4xl sm:text-5xl md:text-5xl font-bold leading-tight mb-2">
                Wujudkan kepedulian bersama <span class="text-yellow-400">AkuPeduli!</span>
            </h1>
            <p class="text-lg sm:text-xl text-blue-100 mb-6 leading-relaxed">
                Bersama kita bisa membantu lebih banyak orang. Temukan campaign terpercaya dan salurkan kebaikanmu dengan mudah dan transparan.
            </p>
            <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl p-2 sm:p-3 mb-8">
                <form action="#" class="flex flex-row items-center">
                    <input type="text" 
                           placeholder="Cari campaign..." 
                           class="flex-1 py-3 px-4 bg-transparent text-slate-800 focus:outline-none text-sm sm:text-base w-full"/>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold transition-all shrink-0">
                        Cari
                    </button>
                </form>
            </div>

            <a href="#" class="inline-block px-10 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg hover:shadow-blue-500/50 transition-all transform hover:-translate-y-1">
                Donasi Sekarang
            </a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-semibold text-center mb-8">Kategori Populer</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
            @foreach(['Kesehatan','Pendidikan','Bencana','Komunitas'] as $cat)
                <div class="bg-white rounded-lg shadow p-6 text-center hover:shadow-lg transition">
                    <div class="h-16 flex items-center justify-center mb-4 bg-blue-100 rounded-full">
                        <!-- icon placeholder -->
                        <span class="text-blue-600 font-bold text-xl">{{ strtoupper(substr($cat,0,1)) }}</span>
                    </div>
                    <span class="font-medium">{{ $cat }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Campaigns -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-semibold text-center mb-8">Campaign Unggulan</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @for($i=0; $i<6; $i++)
                @php
                    $title = "Campaign #".($i+1);
                    $desc = "Deskripsi singkat campaign";
                    $raised = rand(10,90)."%";
                    $goal = "100%";
                @endphp
                <x-campaign-card :title="$title" :description="$desc" :raised="$raised" :goal="$goal" />
            @endfor
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-16 bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-2xl font-semibold mb-8">Cara Kerja</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
            <div>
                <div class="h-20 w-20 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <!-- icon -->
                    <span class="text-blue-600 text-2xl">1</span>
                </div>
                <h3 class="font-medium mb-2">Pilih Campaign</h3>
                <p class="text-gray-600 text-sm">Telusuri dan pilih campaign yang ingin Anda bantu.</p>
            </div>
            <div>
                <div class="h-20 w-20 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <span class="text-blue-600 text-2xl">2</span>
                </div>
                <h3 class="font-medium mb-2">Donasi</h3>
                <p class="text-gray-600 text-sm">Lakukan donasi melalui metode yang tersedia.</p>
            </div>
            <div>
                <div class="h-20 w-20 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <span class="text-blue-600 text-2xl">3</span>
                </div>
                <h3 class="font-medium mb-2">Pantau Perkembangan</h3>
                <p class="text-gray-600 text-sm">Lihat laporan dan update dari campaign.</p>
            </div>
        </div>
    </div>
</section>

<!-- Statistics -->
<section class="py-16">
    <div class="max-w-5xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
        <div>
            <h3 class="text-3xl font-bold">1K+</h3>
            <p class="text-gray-600">Campaign Tercatat</p>
        </div>
        <div>
            <h3 class="text-3xl font-bold">500K+</h3>
            <p class="text-gray-600">Donatur Terdaftar</p>
        </div>
        <div>
            <h3 class="text-3xl font-bold">Rp 10M+</h3>
            <p class="text-gray-600">Donasi Terkumpul</p>
        </div>
    </div>
</section>

@endsection
