@extends('layouts.navbar')
@section('title', 'Hubungi Kami - AkuPeduli')

@section('content')
<main class="bg-gray-50 pt-28 pb-15 font-sans">
    <section>
        <div class="max-w-4xl mx-auto px-4">
            <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
                <h1 class="text-4xl sm:text-2xl md:text-3xl font-bold leading-tight mb-2">
                    Ada yang ingin ditanyakan?
                </h1>
                <p class="text-center text-gray-500 mb-6">
                    Kirimkan pesan Anda melalui formulir di bawah ini. Tim kami akan segera merespons melalui email.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-5">
                    
                    <div class="lg:col-span-2 bg-slate-900 p-8 md:p-12 text-white">
                        <h2 class="text-2xl font-bold mb-6">Informasi Kontak</h2>
                        <p class="text-slate-400 mb-10 text-sm leading-relaxed">
                            Jangan ragu untuk menghubungi kami melalui saluran komunikasi berikut:
                        </p>

                        <div class="space-y-8">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center text-blue-400">
                                    <i data-lucide="mail" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">Email Resmi</p>
                                    <p class="text-sm font-medium">sabiteam23@gmail.com</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center text-green-400">
                                    <i data-lucide="message-circle" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">WhatsApp</p>
                                    <p class="text-sm font-medium">0812 3456 7890</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center text-orange-400 mt-1">
                                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">Lokasi</p>
                                    <p class="text-sm font-medium leading-relaxed text-slate-200">
                                        Jl. Mastrip, Krajan Timur, <br>Sumbersari, Jember.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-3 p-8 md:p-8">
                        <form action="#" method="POST" class="space-y-5">
                            @csrf
                            
                            <div class="space-y-2">
                                <label for="name" class="text-sm font-bold text-slate-700">Nama Lengkap</label>
                                <input type="text" id="name" name="name" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder:text-gray-400"
                                    placeholder="Contoh: Budi Santoso">
                            </div>

                            <div class="space-y-2">
                                <label for="email" class="text-sm font-bold text-slate-700">Alamat Email</label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder:text-gray-400"
                                    placeholder="email@anda.com">
                            </div>

                            <div class="space-y-2">
                                <label for="telephone" class="text-sm font-bold text-slate-700">Nomor Telepon</label>
                                <input type="tel" id="telephone" name="telephone" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder:text-gray-400"
                                    placeholder="Contoh: 08123456789">
                            </div>

                            <div class="space-y-2">
                                <label for="message" class="text-sm font-bold text-slate-700">Pesan</label>
                                <textarea id="message" name="message" rows="4" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder:text-gray-400"
                                    placeholder="Apa yang bisa kami bantu?"></textarea>
                            </div>

                            <a href="#" class="w-full flex items-center justify-center gap-2 px-10 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all active:scale-[0.98] shadow-lg shadow-blue-100">
                                <i data-lucide="send" class="w-5 h-5"></i>
                                <span>Donasi Sekarang</span>
                            </a>
                        </form>
                    </div>

                </div>
            </div>

            <p class="text-center mt-10 text-slate-400 text-sm">
                &copy; 2026 AkuPeduli Jember. Melayani dengan hati.
            </p>
        </div>
    </section>
</main>
@include('layouts.footer')
@endsection