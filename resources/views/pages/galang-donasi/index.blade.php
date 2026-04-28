@extends('layouts.navbar')
@section('title', 'Campaign Saya - AkuPeduli')

@section('content')
@php
    use App\Models\Campaign;

    $isLoggedIn = Auth::check();
    $user = $isLoggedIn ? Auth::user() : null;
    $profile = $user ? \App\Models\CampaignerProfile::where('user_id', $user->id)->first() : null;
    $isVerified = $profile && $profile->status_verifikasi === 'disetujui';
    $statusVerifikasi = $profile ? $profile->status_verifikasi : null;
    $campaigns = $user ? \App\Models\Campaign::where('user_id', $user->id)->latest()->get() : collect();
    $hasCampaign = $campaigns->isNotEmpty();
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
                    <div class="flex flex-col sm:flex-row gap-4 items-center justify-center">
                        <button
                            @click="isVerified ? window.location.href='{{ \App\Filament\Admin\Resources\Campaigns\CampaignResource::getUrl('create') }}' : showModal = true"
                            class="w-full sm:w-auto px-10 py-4 bg-blue-600 text-white rounded-2xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 hover:-translate-y-1 transition-all duration-300">
                            Galang Dana Sekarang
                        </button>
                        
                        @if($statusVerifikasi == 'menunggu' || $statusVerifikasi == 'ditolak')
                        <a href="{{ route('fundraising.verification') }}"
                            class="w-full sm:w-auto px-10 py-4 bg-amber-100 text-amber-700 rounded-2xl font-bold shadow-lg shadow-amber-50 hover:bg-amber-200 hover:-translate-y-1 transition-all duration-300 text-center">
                            Cek Status Verifikasi
                        </a>
                        @endif
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    @foreach($campaigns as $item)
                        @php
                            $percentage = $item->target_amount > 0 ? ($item->current_amount / $item->target_amount) * 100 : 0;
                            $days_left = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($item->end_date), false);
                            $days_left = $days_left > 0 ? floor($days_left) : 0;
                        @endphp
                        <x-galang-donasi-card :title="$item->title"
                            :description="\Illuminate\Support\Str::limit(strip_tags($item->description), 80)"
                            :raised="$item->current_amount" :goal="$item->target_amount" :percentage="$percentage"
                            :image="asset('storage/' . $item->image)" :donatur="rand(10, 200)" :days="$days_left"
                            :status="$item->status"
                            :rejection-reason="$item->status === Campaign::STATUS_REJECTED ? $item->rejection_reason : null"
                            :detail-url="$item->status === Campaign::STATUS_ACTIVE ? route('donation.detail', $item->slug) : \App\Filament\Admin\Resources\Campaigns\CampaignResource::getUrl('edit', ['record' => $item])"
                            :edit-url="$item->status === Campaign::STATUS_REJECTED ? \App\Filament\Admin\Resources\Campaigns\CampaignResource::getUrl('edit', ['record' => $item]) : null" />
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
