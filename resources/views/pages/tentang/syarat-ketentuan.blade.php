@extends('layouts.navbar')
@section('title', 'Syarat & Ketentuan - AkuPeduli')

@section('content')
<main class="bg-gray-50 pt-28 pb-20 font-sans">
    <section>
        <div class="max-w-4xl mx-auto px-4">
            <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
                <h1 class="text-4xl sm:text-2xl md:text-2xl font-bold leading-tight mb-6">
                    Syarat & Ketentuan Penggalangan Dana
                </h1>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 md:p-6 space-y-10 text-slate-700 leading-relaxed">  
                    <div class="mb-2 pb-2 border-b border-gray-100 text-justify">
                        <p class="mb-2">
                            Selamat datang di <strong>Platform AkuPeduli</strong>. Silakan membaca seluruh ketentuan pada Syarat dan Ketentuan ini dengan seksama sebelum menggunakan Platform AkuPeduli, karena berdampak kepada hak dan kewajiban Anda selaku Pengguna Platform ini.
                        </p>
                        <p class="mb-2">
                            Apabila Pengguna melakukan aktivitas seperti mengunjungi, mendaftar, dan/atau menggunakan Platform AkuPeduli ini, maka Pengguna menyatakan telah membaca, mengerti, memahami, dan menyetujui semua ketentuan, termasuk segala perubahan dan/atau penambahan ketentuan dari waktu ke waktu. Apabila Pengguna tidak menyetujui salah satu, sebagian, atau seluruh ketentuan ini, maka Pengguna tidak diperkenankan menggunakan layanan pada Platform AkuPeduli.
                        </p>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 text-blue-600 font-bold text-sm">A</span>
                            <h2 class="text-xl font-bold text-slate-800">Biaya Administrasi</h2>
                        </div>
                        <ul class="list-disc ml-8 space-y-2 text-sm md:text-base">
                            <li>Sebagai platform yang didedikasikan untuk penanganan musibah di Jember, AkuPeduli tidak mengenakan biaya administrasi (0%) untuk seluruh kampanye kategori Bencana Alam.</li>
                            <li>Donasi yang terkumpul akan disalurkan secara utuh 100% kepada penerima manfaat atau koordinator lapangan yang ditunjuk.</li>
                            <li>Biaya operasional dan pengembangan platform didanai secara mandiri melalui donasi sukarela dari mitra dan donatur yang secara khusus memilih untuk mendukung keberlangsungan sistem AkuPeduli.</li>
                        </ul>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 text-blue-600 font-bold text-sm">B</span>
                            <h2 class="text-xl font-bold text-slate-800">Verifikasi Kampanye Baru</h2>
                        </div>
                        <ul class="list-disc ml-8 space-y-2 text-sm md:text-base">
                            <li>Setiap kampanye yang baru dibuat akan melewati proses verifikasi oleh tim AkuPeduli dengan waktu maksimal 3x24 Jam.</li>
                            <li>Selama proses verifikasi berlangsung, kampanye tidak akan ditampilkan di halaman publik (berstatus nonaktif).</li>
                            <li>Tim verifikator akan menghubungi pemilik kampanye melalui nomor ponsel yang didaftarkan untuk proses pengumpulan data pendukung (seperti KTP, Foto Diri, Rekening Bank, dokumen medis, atau surat keterangan lainnya) serta melakukan wawancara/survei jika diperlukan.</li>
                            <li>Kampanye yang tidak memenuhi syarat verifikasi tidak akan diaktifkan.</li>
                            <li>Kampanye yang lolos verifikasi akan langsung ditayangkan sesuai dengan batas waktu penggalangan dana yang telah ditentukan.</li>
                        </ul>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 text-blue-600 font-bold text-sm">C</span>
                            <h2 class="text-xl font-bold text-slate-800">Kampanye Aktif</h2>
                        </div>
                        <ul class="list-disc ml-8 space-y-2 text-sm md:text-base mt-3">
                            <li>AkuPeduli berhak menutup atau menonaktifkan kampanye sewaktu-waktu jika ditemukan laporan penyalahgunaan, indikasi kampanye fiktif, atau pelanggaran hukum lainnya.</li>
                            <li>Jika terjadi penonaktifan, tim AkuPeduli akan menghubungi pemilik kampanye untuk menjelaskan alasan penutupan tersebut.</li>
                            <li>Dana yang sudah terkumpul pada kampanye yang ditutup secara sepihak akan dialokasikan ke kampanye lain yang sedang mendesak oleh tim AkuPeduli.</li>
                            <li>Perubahan data (editing) pada kampanye aktif dapat dilakukan jika terdapat kesalahan informasi, namun akan melalui proses verifikasi ulang.</li>
                            <li>Pemilik kampanye dapat mengajukan perpanjangan waktu penggalangan dana yang nantinya akan ditinjau kembali oleh tim AkuPeduli.</li>
                        </ul>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 text-blue-600 font-bold text-sm">D</span>
                            <h2 class="text-xl font-bold text-slate-800">Kampanye Berakhir</h2>
                        </div>
                        <ul class="list-disc ml-8 space-y-2 text-sm md:text-base mt-3">
                            <li>Kampanye yang telah melewati batas waktu yang ditentukan akan otomatis ditutup/dinonaktifkan dari halaman publik.</li>
                            <li>Kampanye yang sudah ditutup tidak dapat diaktifkan kembali dengan alasan apa pun.</li>
                        </ul>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 text-blue-600 font-bold text-sm">E</span>
                            <h2 class="text-xl font-bold text-slate-800">Pencairan Dana Kampanye</h2>
                        </div>
                        <ul class="list-disc ml-8 space-y-2 text-sm md:text-base mt-3">
                            <li>Pencairan dana tidak harus menunggu hingga masa kampanye berakhir.</li>
                            <li>Pencairan dapat dilakukan kapan saja selama kampanye telah mendapatkan donasi dalam jumlah tertentu sesuai batas minimum sistem.</li>
                            <li>Setiap pencairan dana wajib disertai dengan Update Berita di halaman kampanye agar publik dapat memantau transparansi penggunaan dana.</li>
                            <li>Proses transfer dana ke rekening pemilik kampanye dilakukan dalam waktu maksimal *3x24 Jam* hari kerja.</li>
                            <li>Pemilik kampanye wajib mengirimkan bukti dokumentasi penyerahan dana kepada penerima manfaat (orang/organisasi yang dibantu) melalui fitur yang tersedia atau WhatsApp resmi AkuPeduli.</li>
                        </ul>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 text-blue-600 font-bold text-sm">F</span>
                            <h2 class="text-xl font-bold text-slate-800">Lain-lain</h2>
                        </div>
                        <ul class="list-disc ml-8 space-y-2 text-sm md:text-base mt-3">
                            <li>Jika ditemukan indikasi penipuan atau tindak pidana, AkuPeduli berhak memblokir akun pengguna secara permanen dan melaporkan kasus tersebut kepada pihak kepolisian.</li>
                            <li>Semua data dan informasi pribadi pemilik kampanye dijamin kerahasiaannya sesuai dengan kebijakan privasi kami.</li>
                            <li>Jika ada pertanyaan lebih lanjut, silakan hubungi layanan pelanggan kami melalui WhatsApp di nomor: 0858-0727-8580</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@include('layouts.footer')
@endsection