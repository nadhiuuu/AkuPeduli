@extends('layouts.navbar')
@section('title', 'Kebijakan Privasi - AkuPeduli')

@section('content')
<main class="bg-gray-50 pt-28 pb-20 font-sans">
    <section>
        <div class="max-w-4xl mx-auto px-4">
            <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
                <h1 class="text-4xl sm:text-2xl md:text-3xl font-bold leading-tight mb-6">
                    Kebijakan Privasi
                </h1>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 md:p-6 space-y-10 text-slate-700 leading-relaxed">
                    <div class="mb-2 pb-2 border-b border-gray-100 text-justify">
                        <p class="mb-2">
                            Selamat datang di <strong>AkuPeduli</strong>. Kami sangat menghargai kepercayaan Anda sebagai Pengguna dan berkomitmen untuk melindungi data pribadi yang Anda berikan kepada kami. 
                        </p>
                        <p class="mb-2">
                            Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, mengungkapkan, dan melindungi informasi Anda saat menggunakan Platform AkuPeduli. Dengan menggunakan layanan kami, Anda dianggap menyetujui praktik yang dijelaskan dalam Kebijakan ini.
                        </p>
                    </div>

                    <div class="space-y-8">
                        <section class="space-y-4">
                            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-3">
                                <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                                1. Informasi yang Kami Kumpulkan
                            </h2>
                            <p class="text-sm md:text-base">Kami mengumpulkan informasi yang Anda berikan secara langsung kepada kami, termasuk namun tidak terbatas pada:</p>
                            <ul class="list-disc ml-6 space-y-2 text-sm md:text-base">
                                <li><strong>Data Registrasi:</strong> Nama lengkap, alamat email, nomor telepon, dan foto profil.</li>
                                <li><strong>Data Verifikasi:</strong> Kartu Identitas (KTP), dokumen medis, atau surat keterangan lainnya bagi Penggalang Dana (Campaigner).</li>
                                <li><strong>Data Donasi:</strong> Informasi transaksi donasi, jumlah donasi, dan metode pembayaran yang digunakan (kami tidak menyimpan data detail kartu kredit/rekening Anda secara langsung, transaksi diproses melalui payment gateway resmi).</li>
                            </ul>
                        </section>

                        <section class="space-y-4">
                            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-3">
                                <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                                2. Penggunaan Informasi Anda
                            </h2>
                            <p class="text-sm md:text-base">Informasi yang kami kumpulkan digunakan untuk:</p>
                            <ul class="list-disc ml-6 space-y-2 text-sm md:text-base">
                                <li>Memproses donasi Anda dan memberikan laporan penyaluran dana.</li>
                                <li>Memverifikasi identitas Penggalang Dana untuk mencegah penipuan.</li>
                                <li>Menghubungi Anda terkait pembaruan kampanye yang Anda bantu atau informasi penting lainnya dari AkuPeduli.</li>
                                <li>Meningkatkan layanan platform melalui analisis statistik penggunaan.</li>
                            </ul>
                        </section>

                        <section class="space-y-4">
                            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-3">
                                <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                                3. Pengungkapan Informasi kepada Pihak Ketiga
                            </h2>
                            <p class="text-sm md:text-base">Kami tidak akan menjual atau menyewakan informasi pribadi Anda kepada pihak lain. Namun, informasi dapat dibagikan dalam kondisi berikut:</p>
                            <ul class="list-disc ml-6 space-y-2 text-sm md:text-base">
                                <li><strong>Transparansi Kampanye:</strong> akan ditampilkan di halaman kampanye sebagai donatur.</li>
                                <li><strong>Penyelenggara Kampanye:</strong> Penggalang Dana dapat melihat nama dan nomor kontak donatur untuk kepentingan laporan pertanggungjawaban.</li>
                                <li><strong>Kewajiban Hukum:</strong> Jika diwajibkan oleh hukum atau permintaan resmi dari pihak berwenang (Kepolisian atau Pengadilan).</li>
                            </ul>
                        </section>

                        <section class="space-y-4">
                            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-3">
                                <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                                4. Keamanan Data
                            </h2>
                            <p class="text-sm md:text-base">
                                Kami menerapkan standar keamanan SSL (Secure Socket Layer) untuk melindungi pengiriman data Anda. Meskipun demikian, perlu dipahami bahwa tidak ada metode pengiriman data melalui internet atau penyimpanan elektronik yang 100% aman. Kami terus berupaya memperbarui sistem keamanan kami untuk melindungi data Anda.
                            </p>
                        </section>

                        <section class="space-y-4">
                            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-3">
                                <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                                5. Hak Anda
                            </h2>
                            <p class="text-sm md:text-base">
                                Anda memiliki hak untuk mengakses, memperbarui, atau meminta penghapusan informasi pribadi Anda di platform kami melalui pengaturan akun atau dengan menghubungi layanan pelanggan kami.
                            </p>
                        </section>

                        <div class="mt-2 p-4 bg-blue-50 rounded-xl border border-blue-100">
                            <h3 class="font-bold text-blue-900 mb-2">Punya pertanyaan mengenai privasi Anda?</h3>
                            <p class="text-sm text-blue-800">
                                Jika Anda memiliki pertanyaan atau kekhawatiran mengenai Kebijakan Privasi ini, silakan hubungi tim kami melalui email di <a href="mailto:sabiteam23@gmail.com" class="font-bold underline">sabiteam23@gmail.com</a> atau nomor telepon <a href="tel:+6281234567890" class="font-bold underline">0812 3456 7890</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@include('layouts.footer')
@endsection