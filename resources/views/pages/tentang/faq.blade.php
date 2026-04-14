@extends('layouts.navbar')
@section('title', 'Pusat Bantuan & FAQ - AkuPeduli')

@section('content')
<main class="bg-slate-50 min-h-screen">

    <section class="relative pt-32 pb-10 overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-[0.03] pointer-events-none">
            <svg width="100%" height="100%">
                <circle cx="10" cy="10" r="1.5" fill="#2563eb" />
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl sm:text-2xl md:text-5xl font-bold leading-tight mb-2">
                Ada yang bisa kami bantu?
            </h1>
            <p class="text-lg sm:text-xl text-gray-600 leading-relaxed max-w-4xl mx-auto text-center">
                Cari jawaban tercepat seputar donasi dan bantuan bencana alam di Jember.
        </div>
    </section>

    <section class="py-12 -mt-10 md:-mt-14">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8">
                <aside class="hidden lg:block w-1/4">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sticky top-28">
                        <nav class="space-y-1">
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 px-3">Kategori
                            </h3>
                            <a href="#umum"
                                class="flex items-center gap-3 px-3 py-2.5 text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-all font-medium group">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-300 group-hover:bg-blue-500"></span> Umum
                            </a>
                            <a href="#donatur"
                                class="flex items-center gap-3 px-3 py-2.5 text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-all font-medium group">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-300 group-hover:bg-blue-500"></span>
                                Donatur
                            </a>
                            <a href="#penggalang"
                                class="flex items-center gap-3 px-3 py-2.5 text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-all font-medium group">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-300 group-hover:bg-blue-500"></span>
                                Penggalang Dana
                            </a>
                            <a href="#kendala"
                                class="flex items-center gap-3 px-3 py-2.5 text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-all font-medium group">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-300 group-hover:bg-blue-500"></span>
                                Kendala Teknis
                            </a>
                        </nav>
                    </div>
                </aside>

                <div class="w-full lg:w-3/4 space-y-12" x-data="{ active: null }">
                    <div id="umum" class="scroll-mt-28">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-blue-500 rounded-lg text-white">
                                <i data-lucide="info" class="w-5 h-5 text-white-500"></i>
                            </div>
                            <h2 class="text-xl font-bold text-slate-800">Umum</h2>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                                <button @click="active = (active === 1 ? null : 1)"
                                    class="w-full flex justify-between items-center p-5 text-left transition-hover hover:bg-slate-50">
                                    <span class="font-bold text-slate-700">Apa itu AkuPeduli?</span>
                                        <i data-lucide="chevron-down"
                                        class="w-5 h-5 text-slate-400 transform transition-transform"
                                        :class="active === 1 ? 'rotate-180' : ''"></i>
                                </button>
                                <div x-show="active === 1" x-collapse x-cloak
                                    class="px-5 pb-5 text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                                    AkuPeduli adalah platform donasi digital yang berfokus pada bantuan bencana alam di
                                    wilayah Jember, menghubungkan masyarakat yang membutuhkan dengan para donatur secara
                                    cepat dan transparan.
                                </div>
                            </div>
                            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                                <button @click="active = (active === 2 ? null : 2)"
                                    class="w-full flex justify-between items-center p-5 text-left transition-hover hover:bg-slate-50">
                                    <span class="font-bold text-slate-700">Apakah AkuPeduli aman?</span>
                                        <i data-lucide="chevron-down"
                                        class="w-5 h-5 text-slate-400 transform transition-transform"
                                        :class="active === 2 ? 'rotate-180' : ''"></i>
                                </button>
                                <div x-show="active === 2" x-collapse x-cloak
                                    class="px-5 pb-5 text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                                    Sangat aman. Setiap campaign wajib melalui proses verifikasi identitas (KTP) dan
                                    validasi data bencana oleh tim relawan kami sebelum dipublikasikan.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="donatur" class="scroll-mt-28">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-blue-500 rounded-lg text-white">
                                <i data-lucide="hand-heart" class="w-5 h-5 text-white"></i>
                            </div>
                            <h2 class="text-xl font-bold text-slate-800">Donatur</h2>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                                <button @click="active = (active === 3 ? null : 3)"
                                    class="w-full flex justify-between items-center p-5 text-left transition-hover hover:bg-slate-50">
                                    <span class="font-bold text-slate-700">Bagaimana cara berdonasi?</span>
                                        <i data-lucide="chevron-down"
                                        class="w-5 h-5 text-slate-400 transform transition-transform"
                                        :class="active === 3 ? 'rotate-180' : ''"></i>
                                </button>
                                <div x-show="active === 3" x-collapse x-cloak
                                    class="px-5 pb-5 text-slate-600 border-t border-slate-100 pt-4">
                                    Pilih campaign yang ingin dibantu, klik <span
                                        class="text-blue-600 font-bold">"Donasi Sekarang"</span>, masukkan nominal, lalu
                                    pilih metode pembayaran seperti E-wallet, Transfer Bank, atau QRIS.
                                </div>
                            </div>
                            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                                <button @click="active = (active === 4 ? null : 4)"
                                    class="w-full flex justify-between items-center p-5 text-left transition-hover hover:bg-slate-50">
                                    <span class="font-bold text-slate-700">Berapa minimal donasi?</span>
                                        <i data-lucide="chevron-down"
                                        class="w-5 h-5 text-slate-400 transform transition-transform"
                                        :class="active === 4 ? 'rotate-180' : ''"></i>
                                </button>
                                <div x-show="active === 4" x-collapse x-cloak
                                    class="px-5 pb-5 text-slate-600 border-t border-slate-100 pt-4">
                                    Donasi dapat dimulai dari <span class="font-bold text-slate-800">Rp1.000</span>.
                                    Kami percaya sekecil apapun kontribusi Anda sangatlah berarti bagi warga Jember yang
                                    terdampak.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="penggalang" class="scroll-mt-28">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-blue-500 rounded-lg text-white">
                                <i data-lucide="users" class="w-5 h-5"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-800">Penggalang Dana</h2>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                                <button @click="active = (active === 5 ? null : 5)"
                                    class="w-full flex justify-between items-center p-5 text-left transition-hover hover:bg-slate-50">
                                    <span class="font-bold text-slate-700">Siapa saja yang boleh membuat galang dana</span>
                                        <i data-lucide="chevron-down"
                                        class="w-5 h-5 text-slate-400 transform transition-transform"
                                        :class="active === 5 ? 'rotate-180' : ''"></i>
                                </button>
                                <div x-show="active === 5" x-collapse x-cloak
                                    class="px-5 pb-5 text-slate-600 border-t border-slate-100 pt-4">
                                    Siapa saja yang memiliki KTP dan dapat memverifikasi data bencana di Jember dapat
                                    membuat galang dana. Kami menyarankan untuk bekerja sama dengan relawan atau organisasi
                                    lokal untuk memastikan validitas dan efektivitas bantuan.
                                </div>
                            </div>
                            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                                <button @click="active = (active === 6 ? null : 6)"
                                    class="w-full flex justify-between items-center p-5 text-left transition-hover hover:bg-slate-50">
                                    <span class="font-bold text-slate-700">Berapa lama proses verifikasi kampanye?</span>
                                        <i data-lucide="chevron-down"
                                        class="w-5 h-5 text-slate-400 transform transition-transform"
                                        :class="active === 6 ? 'rotate-180' : ''"></i>
                                </button>
                                <div x-show="active === 6" x-collapse x-cloak
                                    class="px-5 pb-5 text-slate-600 border-t border-slate-100 pt-4">
                                    Proses verifikasi biasanya memakan waktu 1-3 hari kerja, tergantung pada kelengkapan
                                    data dan kebutuhan validasi lapangan. Kami berkomitmen untuk memastikan setiap kampanye
                                    yang dipublikasikan benar-benar valid dan siap membantu korban bencana di Jember.
                                </div>
                            </div>
                            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                                <button @click="active = (active === 7 ? null : 7)"
                                    class="w-full flex justify-between items-center p-5 text-left transition-hover hover:bg-slate-50">
                                    <span class="font-bold text-slate-700">Mengapa campaign saya ditolak?</span>
                                        <i data-lucide="chevron-down"
                                        class="w-5 h-5 text-slate-400 transform transition-transform"
                                        :class="active === 7 ? 'rotate-180' : ''"></i>
                                </button>
                                <div x-show="active === 7" x-collapse x-cloak
                                    class="px-5 pb-5 text-slate-600 border-t border-slate-100 pt-4">
                                    Campaign dapat ditolak jika data yang diajukan tidak lengkap, tidak valid, atau tidak
                                    sesuai dengan kriteria bantuan bencana di Jember. Pastikan untuk melengkapi semua informasi
                                    yang diperlukan dan bekerja sama dengan relawan lokal untuk meningkatkan peluang verifikasi
                                    berhasil.
                                </div>
                            </div>
                            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                                <button @click="active = (active === 8 ? null : 8)"
                                    class="w-full flex justify-between items-center p-5 text-left transition-hover hover:bg-slate-50">
                                    <span class="font-bold text-slate-700">Berapa biaya admin di AkuPeduli?</span>
                                        <i data-lucide="chevron-down"
                                        class="w-5 h-5 text-slate-400 transform transition-transform"
                                        :class="active === 8 ? 'rotate-180' : ''"></i>
                                </button>
                                <div x-show="active === 8" x-collapse x-cloak
                                    class="px-5 pb-5 text-slate-600 border-t border-slate-100 pt-4">
                                    Setiap campaign akan dipotong biaya administrasi sebear 3.5% dari jumlah dana yang terkumpul. 
                                    Biaya administrasi tersebut akan kami gunakan untuk operasional dan pengembangan platform AkuPeduli.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="kendala"
                        class="bg-blue-900 rounded-xl p-5 md:p-5 text-center text-white relative overflow-hidden shadow-2xl">
                        <div class="relative z-10">
                            <h2 class="text-2xl md:text-3xl font-bold mb-3">Masih butuh bantuan?</h2>
                            <p class="text-slate-400 mb-5 mx-auto">Tim support kami siap membantu kendala
                                teknis Anda setiap hari pukul 08:00 - 20:00 WIB.</p>
                            <div class="flex flex-col sm:flex-row justify-center gap-4">
                                <a href="https://wa.me/6285807278580"
                                    class="flex items-center justify-center gap-2 px-8 py-4 rounded-2xl font-semibold
                                        bg-green-500 hover:bg-green-600 text-white transition-all
                                        shadow-md hover:shadow-lg">
                                    <i data-lucide="message-circle" class="w-5 h-5"></i>
                                    WhatsApp Support
                                </a>
                                <a href="mailto:support@akupeduli.id"
                                    class="flex items-center justify-center gap-2 px-8 py-4 rounded-2xl font-semibold
                                        border border-gray-200 text-gray-700 bg-white
                                        hover:border-blue-600 hover:text-blue-600 hover:bg-blue-50
                                        transition-all">
                                    <i data-lucide="mail" class="w-5 h-5"></i>
                                    Email Support
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

@include('layouts.footer')
@endsection

@push('styles')
<style>
    [x-cloak] {
        display: none !important;
    }

    html {
        scroll-behavior: smooth;
    }
</style>
@endpush