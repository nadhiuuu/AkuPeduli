@extends('layouts.navbar')
@section('title', 'Pusat Bantuan & FAQ - AkuPeduli')

@section('content')
<main class="bg-gray-50 pt-28 pb-20 font-sans">
    <section>
        <div class="max-w-4xl mx-auto px-4">
            <div class="max-w-7xl mx-auto px-4 text-center relative z-100">
                <h1 class="text-4xl sm:text-2xl md:text-3xl font-bold leading-tight mb-6">
                    Pertanyaan yang Sering Diajukan (FAQ)
                </h1>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 md:p-6 space-y-10 text-slate-700 leading-relaxed">
                    <div class="space-y-12">
                        <div class="space-y-5">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 mb-2">Apa itu AkuPeduli?</h3>
                                <p>AkuPeduli adalah platform penggalangan dana dan donasi secara online (crowdfunding) yang dikhususkan untuk membantu penanganan bencana alam, bantuan medis, dan kemanusiaan di wilayah Kabupaten Jember dan sekitarnya.</p>
                            </div>
                            <hr class="border-gray-100">
                            
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 mb-2">Apakah AkuPeduli aman dan terpercaya?</h3>
                                <p>Sangat aman. Kami memverifikasi setiap identitas Penggalang Dana menggunakan KTP dan dokumen pendukung lainnya. Selain itu, setiap penyaluran dana wajib menyertakan laporan pertanggungjawaban yang dapat diakses oleh donatur.</p>
                            </div>
                            <hr class="border-gray-100">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 mb-2">Bagaimana cara berdonasi di AkuPeduli?</h3>
                                <p>Cukup pilih kampanye yang ingin Anda bantu, klik tombol <strong>"Donasi Sekarang"</strong>, masukkan nominal, dan pilih metode pembayaran (E-Wallet, Transfer Bank, atau QRIS). Pastikan Anda melakukan transfer sesuai dengan kode unik atau instruksi yang diberikan.</p>
                            </div>
                            <hr class="border-gray-100">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 mb-2">Berapa minimal donasi yang diperbolehkan?</h3>
                                <p>Anda dapat berdonasi mulai dari <strong>Rp1.000</strong>. Kami percaya bahwa kebaikan tidak diukur dari besar nominalnya, melainkan dari ketulusan dan konsistensi untuk saling membantu.</p>
                            </div>
                            <hr class="border-gray-100">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 mb-2">Siapa saja yang boleh menggalang dana?</h3>
                                <p>Setiap perorangan, komunitas, maupun lembaga resmi yang memiliki KTP dan dokumen pendukung terkait kasus yang digalang (seperti surat keterangan sakit atau foto bukti bencana di lapangan).</p>
                            </div>
                            <hr class="border-gray-100">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 mb-2">Berapa biaya administrasi platform?</h3>
                                <p>AkuPeduli mengenakan biaya administrasi sebesar <strong>3.5%</strong> untuk pengembangan sistem dan biaya operasional lapangan. Biaya ini dipotong dari total dana yang terkumpul, kecuali untuk kategori Bencana Alam yang darurat (0% biaya admin sesuai kebijakan tertentu).</p>
                            </div>
                            <hr class="border-gray-100">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 mb-2">Berapa lama proses verifikasi kampanye?</h3>
                                <p>Tim relawan kami akan memverifikasi data Anda dalam waktu maksimal <strong>1x24 jam</strong> pada hari kerja. Jika data tidak lengkap, tim kami akan menghubungi Anda melalui nomor yang terdaftar.</p>
                            </div>
                        </div>
                        <div class="mt-2 p-4 bg-blue-50 rounded-xl border border-blue-100">
                            <h3 class="font-bold text-blue-900 mb-2">Masih belum menemukan jawaban?</h3>
                            <p class="text-sm text-blue-800">
                                Jika Anda masih memiliki pertanyaan mengenai AkuPeduli, silakan hubungi tim kami melalui email di <a href="mailto:sabiteam23@gmail.com" class="font-bold underline">sabiteam23@gmail.com</a> atau nomor telepon <a href="tel:+6281234567890" class="font-bold underline">0812 3456 7890</a>.
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