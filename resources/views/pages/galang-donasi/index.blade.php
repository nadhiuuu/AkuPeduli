@extends('layouts.navbar')
@section('title', 'Campaign Saya - AkuPeduli')

@section('content')
@php
    $hasCampaign = false;
    $isVerified = false;

    $campaigns = [
        [
            'title' => 'Peduli Korban Banjir Jember',
            'image' => 'https://picsum.photos/seed/flood/400/300',
            'collected' => 130000,
            'target' => 500000,
            'days_left' => 20,
            'status' => 'pending'
        ],
        [
            'title' => 'Bantu Adik Yatim Piatu di Surabaya',
            'image' => 'https://picsum.photos/seed/orphan/400/300',
            'collected' => 450000,
            'target' => 1000000,
            'days_left' => 15,
            'status' => 'active'
        ],
        [
            'title' => 'Dukung Pendidikan Anak Desa di Malang',
            'image' => 'https://picsum.photos/seed/education/400/300',
            'collected' => 0,
            'target' => 750000,
            'days_left' => 0,
            'status' => 'rejected'
        ]
    ];
@endphp

<main x-data="{ showModal: false, showVerifyModal: false, isVerified: {{ $isVerified ? 'true' : 'false' }} }"
    class="min-h-screen bg-slate-50 pt-30 md:pt-32 pb-20">
    <section class="pb-8 md:pb-12 px-4">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-2">Campaign Saya</h2>
            <p class="text-center text-gray-500">Lihat dan kelola campaign yang telah kamu buat untuk membantu mereka
                yang membutuhkan.</p>
        </div>
    </section>

    <section class="px-4">
        <div class="max-w-7xl mx-auto">
            @if(!$hasCampaign)
                <div class="flex flex-col items-center text-center">
                    <div class="w-32 md:w-48 mb-8">
                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" class="w-full opacity-60"
                            alt="No Campaign">
                    </div>
                    <p class="text-slate-400 text-sm mb-10 max-w-xs">Kamu belum memiliki campaign yang sedang berjalan saat
                        ini.</p>
                    <button
                        @click="isVerified ? window.location.href='{{ route('fundraising.create') }}' : showModal = true"
                        class="w-full md:w-auto px-10 py-4 bg-blue-600 text-white rounded-2xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 hover:-translate-y-1 transition-all duration-300">
                        Galang Dana Sekarang
                    </button>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    @foreach($campaigns as $item)
                        @php
                            $percentage = $item['target'] > 0 ? ($item['collected'] / $item['target']) * 100 : 0;
                        @endphp
                        <x-galang-donasi-card :title="$item['title']"
                            description="Bantuan untuk masyarakat yang membutuhkan secara transparan melalui AkuPeduli!."
                            :raised="$item['collected']" :goal="$item['target']" :percentage="$percentage"
                            :image="$item['image']" :donatur="rand(10, 200)" :days="$item['days_left']"
                            :status="$item['status']" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <x-persetujuan-modal :route="route('fundraising.agreement')" />
    <x-verifikasi-modal />
</main>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>

@include('layouts.footer')
@endsection