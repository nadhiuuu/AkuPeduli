@extends('layouts.app')
@section('title', 'AkuPeduli! - Wujudkan Kepedulian Melalui Donasi')
@section('content')

@include('pages.home.sections.hero')
@include('pages.home.sections.campaign')

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

@include('components.footer')
@endsection
