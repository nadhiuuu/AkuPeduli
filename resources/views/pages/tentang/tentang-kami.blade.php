@extends('layouts.navbar')
@section('title', 'Tentang Kami - AkuPeduli')

@section('content')
<main class="bg-white">
    <section class="relative pt-32 pb-20 overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-[0.03] pointer-events-none">
            <svg width="100%" height="100%"><circle cx="10" cy="10" r="1.5" fill="#2563eb" /></svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl sm:text-5xl md:text-5xl font-bold leading-tight mb-2">
                Mengenal Lebih Dekat <span class="text-blue-600">AkuPeduli</span>
            </h1>
            <div class="w-24 h-2 bg-yellow-400 mx-auto mb-5 mt-5 rounded-full"></div>
            <p class="text-lg sm:text-xl text-gray-600 leading-relaxed max-w-4xl mx-auto text-center">
                AkuPeduli adalah wadah kepedulian khusus wilayah Jember yang hadir untuk memastikan bantuan tepat sasaran hingga ke pelosok desa. Kami lahir dari keinginan sederhana: memastikan tak ada satu pun kesulitan yang dihadapi sendirian.
            </p>
        </div>
    </section>

    <section class="pb-2">
        @include('pages.home.sections.statistics')
    </section>

    <section class="py-16">
        <div class="max-w-5xl mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="w-full lg:w-1/2">
                    <div class="relative p-4">
                        <div class="absolute inset-0 bg-blue-200 rounded-xl rotate-3 shadow-lg"></div>
                        <img src="{{ asset('assets/Background.jpg') }}" 
                             alt="Sosial Jember" 
                             class="relative z-10 rounded-xl w-full h-[350px] object-cover shadow-xl">
                    </div>
                </div>

                <div class="w-full lg:w-1/2 space-y-6">
                    <h2 class="text-3xl md:text-4xl font-bold leading-tight text-gray-900">
                        Mengapa Fokus Kami <br> Hanya di <span class="text-blue-600">Kabupaten Jember?</span>
                    </h2>
                    <p class="text-gray-500 text-lg text-justify leading-relaxed">
                        Kami percaya bahwa perubahan besar dimulai dari ketajaman data di lingkungan terdekat. AkuPeduli dirancang untuk memetakan kebutuhan bantuan secara presisi di Jember, mulai dari daerah perkotaan hingga pelosok desa. Dengan fokus lokal, kami memastikan bantuan lebih terarah dan sesuai kebutuhan nyata di lapangan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-15 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-8">
                <h2 class="text-4xl font-bold text-gray-900 mb-2">
                    Cara Kerja AkuPeduli
                </h2>
                <p class="text-gray-500 text-lg max-w-3xl mx-auto">
                    Proses sederhana, transparan, dan terpercaya untuk membantu korban bencana di Jember
                </p>
            </div>
            <div class="grid lg:grid-cols-2 gap-16 items-start">
                <div class="relative">
                    <div class="absolute left-4 top-0 bottom-0 w-[2px] bg-blue-100"></div>
                    @php
                        $steps = [
                            '01' => 'Ajukan campaign bantuan bencana di wilayah Jember.',
                            '02' => 'Tim AkuPeduli melakukan verifikasi data dan kelayakan.',
                            '03' => 'Campaign dipublikasikan setelah dinyatakan valid.',
                            '04' => 'Donatur menyalurkan bantuan melalui sistem yang aman.',
                            '05' => 'Dana disalurkan dan laporan ditampilkan secara transparan.'
                        ];
                    @endphp
                    <div class="space-y-4">
                        @foreach($steps as $num => $text)
                        <div class="relative flex items-start gap-6 group">
                            <div class="z-10 w-10 h-10 flex items-center justify-center rounded-full bg-blue-600 text-white font-bold shadow-md group-hover:scale-110 transition">
                                {{ $num }}
                            </div>
                            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 group-hover:shadow-md transition w-full">
                                <p class="text-gray-700 text-base leading-relaxed">
                                    {{ $text }}
                                </p>
                            </div>

                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-10 shadow-lg border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-100 rounded-full blur-3xl opacity-50"></div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                        <i data-lucide="shield-check" class="w-7 h-7 text-blue-600"></i>
                        Sistem Verifikasi
                    </h3>
                    <p class="text-gray-500 mb-8 leading-relaxed">
                        Setiap campaign melalui proses verifikasi ketat untuk memastikan keamanan, keakuratan, dan kepercayaan donatur.
                    </p>
                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <i data-lucide="check-circle" class="w-6 h-6 text-blue-600 flex-shrink-0"></i>
                            <p class="text-gray-700 font-medium">
                                Validasi kronologi dan bukti kejadian bencana
                            </p>
                        </div>
                        <div class="flex items-start gap-4">
                            <i data-lucide="check-circle" class="w-6 h-6 text-blue-600 flex-shrink-0"></i>
                            <p class="text-gray-700 font-medium">
                                Verifikasi identitas penggalang dan lokasi
                            </p>
                        </div>
                        <div class="flex items-start gap-4">
                            <i data-lucide="check-circle" class="w-6 h-6 text-blue-600 flex-shrink-0"></i>
                            <p class="text-gray-700 font-medium">
                                Evaluasi kebutuhan dan kelayakan anggaran
                            </p>
                        </div>
                    </div>
                    <div class="mt-10 pt-6 border-t border-gray-100">
                        <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">
                            Trust • Transparency • Impact
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-10">
        <div class="max-w-7xl mx-auto px-4">
            @include('pages.home.sections.reason')
        </div>
    </section>

    <section class="pt-2 pb-15 bg-white">
        <div class="max-w-5xl mx-auto px-4 text-center">
            <div class="bg-blue-50 rounded-3xl p-10 md:p-10 border border-blue-100 shadow-sm">
                <h3 class="text-2xl md:text-3xl font-bold text-blue-900 mb-3 italic">"Dari Jember untuk Jember. Bersama, kita bisa lebih kuat."</h3>
                <p class="text-gray-600 mb-8 max-w-2xl mx-auto">Mari bergabung dalam rantai kepedulian untuk membantu saudara kita yang membutuhkan bantuan darurat.</p>
                <a href="{{ route('donation.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-12 rounded-full shadow-lg transition-all transform hover:-translate-y-1 active:scale-95">
                    Mulai Berbagi Sekarang
                </a>
            </div>
        </div>
    </section>
</main>

@include('layouts.footer')
@endsection