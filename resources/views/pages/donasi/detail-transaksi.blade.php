@extends('layouts.navbar')
@section('title', 'Berdonasi - AkuPeduli')

@section('content')
<main class="bg-gray-50 pt-28 pb-20 font-sans">
    <section>
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-6">
                <h2 class="text-2xl md:text-3xl font-bold mb-2 text-slate-800">
                    Detail Transaksi Donasi Anda
                </h2>
                <p class="text-slate-500 text-sm md:text-base px-4">Silakan periksa kembali rincian donasi Anda sebelum membayar.</p>
            </div>

            <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-5 md:p-5">
                    <div class="space-y-4 md:space-y-4">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-1 sm:gap-1 border-b sm:border-0 pb-3 sm:pb-0">
                            <span class="text-gray-500 font-medium text-sm md:text-base">Tanggal</span>
                            <span class="text-gray-900 font-semibold text-left text-sm md:text-base">17 Apr 2026</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-1 sm:gap-1 border-b sm:border-0 pb-3 sm:pb-0">
                            <span class="text-gray-500 font-medium text-sm md:text-base">Judul Campaign</span>
                            <span class="text-gray-900 font-semibold text-left text-sm md:text-base">Banjir Bandang</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-1 sm:gap-1 border-b sm:border-0 pb-3 sm:pb-0">
                            <span class="text-gray-500 font-medium text-sm md:text-base">Nama Donatur</span>
                            <span class="text-gray-900 font-semibold text-left text-sm md:text-base">nadhiy</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-1 sm:gap-1 border-b sm:border-0 pb-3 sm:pb-0">
                            <span class="text-gray-500 font-medium text-sm md:text-base">Email</span>
                            <span class="text-gray-900 font-semibold text-left text-sm md:text-base break-all">e41230618@student.polije.ac.id</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-1 sm:gap-1 border-b sm:border-0 pb-3 sm:pb-0">
                            <span class="text-gray-500 font-medium text-sm md:text-base">No. WhatsApp</span>
                            <span class="text-gray-900 font-semibold text-left text-sm md:text-base">083878979832</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-1 sm:gap-1 border-b sm:border-0 pb-3 sm:pb-0">
                            <span class="text-gray-500 font-medium text-sm md:text-base">Nominal</span>
                            <span class="text-gray-900 font-bold text-left text-lg text-blue-600">Rp 1.000</span>
                        </div>
                    </div>

                    <div class="mt-8 md:mt-10">
                        <a href="#" class="w-full py-3 bg-[#3b82f6] hover:bg-blue-600 text-white font-bold rounded-xl shadow-md transition-all active:scale-[0.98] flex items-center justify-center text-lg">
                            Bayar Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@include('layouts.footer')
@endsection