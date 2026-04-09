@extends('layouts.navbar')
@section('title', 'AkuPeduli! - Detail Campaign')

@section('content')
<main class="pt-32 pb-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-10">
            
            <div class="lg:w-2/3">
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100">
                    <img src="https://picsum.photos/seed/detail/1200/600" alt="Campaign Image" class="w-full h-[400px] object-cover">
                    
                    <div class="p-8">
                        <h1 class="text-3xl font-bold text-slate-900 mb-3">Bantuan Sembako untuk Lansia di Jember Selatan</h1>
                        <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed">
                            <p class="mb-4 text-justify">
                                Program ini bertujuan untuk meringankan beban ekonomi para lansia yang hidup sendirian di wilayah pelosok Jember. Banyak dari mereka yang tidak lagi mampu bekerja dan sangat bergantung pada bantuan sesama.
                                Donasi yang terkumpul akan disalurkan dalam bentuk paket sembako lengkap (beras, minyak, telur, dan kebutuhan pokok lainnya) serta bantuan biaya pemeriksaan kesehatan rutin.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:w-1/3">
                <x-campaign-sidebar />
            </div>

        </div>
    </div>
</main>

@include('layouts.footer')
@endsection