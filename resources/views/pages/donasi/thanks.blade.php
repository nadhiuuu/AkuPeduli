@extends('layouts.navbar')
@section('title', 'Terima Kasih - AkuPeduli')

@section('content')
<main class="bg-slate-50 min-h-screen pt-32 pb-20 font-sans flex items-center justify-center">
    <div class="max-w-md w-full mx-auto px-4">
        <div class="bg-white rounded-3xl p-8 md:p-10 text-center shadow-xl shadow-slate-200/50 border border-slate-100">

            <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-4">Terima Kasih!</h2>
            <p class="text-slate-500 mb-8 leading-relaxed">
                Pembayaran donasi Anda sedang kami proses. Semoga kebaikan Anda dibalas berlipat ganda dan bermanfaat bagi yang membutuhkan.
            </p>

            <div class="space-y-3">
                <a href="{{ route('home') }}" class="block w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-200 active:scale-[0.98]">
                    Kembali ke Beranda
                </a>
                <a href="{{ route('donation.index') }}" class="block w-full py-3.5 bg-slate-50 hover:bg-slate-100 text-slate-600 font-bold rounded-xl transition-all border border-slate-200 active:scale-[0.98]">
                    Jelajahi Campaign Lain
                </a>
            </div>
            
        </div>
    </div>
</main>

@include('layouts.footer')
@endsection