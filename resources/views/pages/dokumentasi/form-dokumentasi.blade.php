@extends('layouts.navbar')
@section('title', 'Buat Dokumentasi - AkuPeduli!')

@section('content')

<main x-data="{ 
    imagePreview: null,
    fileName: '',
    isUploading: false
}" class="min-h-screen bg-slate-50 pt-28 pb-20 px-4">

    <div class="max-w-2xl mx-auto">
        <div class="mb-5 flex flex-col items-center text-center gap-4">
            <div>
                <h1 class="text-2xl md:text-2xl font-bold text-slate-800">Update Berita & Penyaluran</h1>
                <p class="text-base text-slate-500">Bagikan kabar terbaru mengenai penggunaan dana donasi kepada para donatur.</p>
            </div>
        </div>

        <form action="#" method="POST" class="space-y-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <label class="block text-sm font-bold text-slate-700 mb-2 flex items-center gap-2">
                    <i data-lucide="camera" class="w-4 h-4 text-blue-600"></i>
                    Foto Kegiatan Penyaluran
                </label>
                
                <div class="relative group">
                    <input type="file" accept="image/*" 
                        @change="const file = $event.target.files[0]; if(file) { const reader = new FileReader(); reader.onload = (e) => { imagePreview = e.target.result }; reader.readAsDataURL(file) }"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    
                    <div :class="imagePreview ? 'border-blue-400 bg-blue-50' : 'border-slate-200 bg-slate-50'" 
                        class="border-2 border-dashed rounded-2xl p-6 text-center transition-all min-h-[200px] flex flex-col items-center justify-center">
                        
                        <template x-if="!imagePreview">
                            <div class="space-y-1">
                                <p class="text-sm font-bold text-slate-700">Unggah Foto Dokumentasi</p>
                                <p class="text-xs text-slate-400">Pastikan foto jelas dan asli</p>
                            </div>
                        </template>

                        <template x-if="imagePreview">
                            <img :src="imagePreview" class="rounded-xl w-full h-44 object-cover">
                        </template>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1 mt-5">Judul Laporan / Berita</label>
                    <input type="text" placeholder="Contoh: Penyaluran Paket Sembako Tahap I" 
                        class="w-full text-base flex-1 px-4 py-3 bg-slate-50 rounded-xl focus:ring-1 focus:ring-blue-500 outline-none">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1 mt-5">Isi Berita Lengkap</label>
                    <textarea rows="6" placeholder="Ceritakan detail proses penyaluran bantuan..." 
                        class="w-full text-base flex-1 px-4 py-3 bg-slate-50 rounded-xl focus:ring-1 focus:ring-blue-500 outline-none transition-all leading-relaxed"></textarea>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1 mt-5">Kutipan Penerima Manfaat</label>
                    <div class="relative">
                        <i data-lucide="quote" class="absolute left-4 top-4 w-4 h-4 text-slate-300"></i>
                        <textarea rows="2" placeholder="Contoh: 'Terima kasih donatur, bantuan ini sangat berarti...'" 
                            class="w-full pl-12 pr-4 py-3 bg-slate-50 rounded-xl italic focus:ring-1 focus:ring-blue-500 outline-none transition-all leading-relaxed"></textarea>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1 mt-5">Lampiran Transparansi (PDF)</label>
                    <div class="flex items-center gap-4 p-4 bg-slate-50 border border-slate-200 rounded-xl">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm text-red-500">
                            <i data-lucide="file-text" class="w-6 h-6"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-slate-700" x-text="fileName ? fileName : 'Belum ada file dipilih'"></p>
                            <p class="text-[10px] text-slate-400">Format PDF (Maks. 30MB)</p>
                        </div>
                        <label class="cursor-pointer bg-white px-4 py-2 border border-slate-200 rounded-lg text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                            Pilih File
                            <input type="file" accept=".pdf" class="hidden" @change="fileName = $event.target.files[0].name">
                        </label>
                    </div>
                </div>

                <div class="pt-5">
                    <button type="submit" class="w-full py-3 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 transition shadow-lg shadow-blue-200 flex items-center justify-center gap-2 group">
                        <span>Update Dokumentasi</span>
                    </button>
                    <p class="text-xs text-center text-slate-400 mt-4 leading-relaxed">
                        Update yang Anda kirim akan langsung muncul di halaman Dokumentasi dan memberi notifikasi kepada para donatur.
                    </p>
                </div>
        </form>
    </div>
</main>
@endsection