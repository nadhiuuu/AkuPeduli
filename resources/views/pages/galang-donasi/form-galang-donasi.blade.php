@extends('layouts.navbar')
@section('title', 'Campaign Saya - AkuPeduli!')

@section('content')

    <main x-data="{ 
            categoryOpen: false, 
            categorySelected: 'Pilih Kategori',
            targetOpen: false,
            targetSelected: 'Pilih Penerima',
            imagePreview: null
        }" class="min-h-screen bg-slate-50 pt-28 pb-20 px-4">

        <div class="max-w-2xl mx-auto">
            <div class="mb-5 flex flex-col items-center text-center gap-4">
                <div>
                    <h1 class="text-2xl md:text-2xl font-bold text-slate-800">Buat Campaign Baru</h1>
                    <p class="text-sm md:text-base text-slate-500 mt-1">
                        Lengkapi detail donasi dengan jujur dan transparan untuk memudahkan proses verifikasi admin.
                    </p>
                </div>
            </div>

            <form action="#" method="POST" class="space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <label class="block text-sm font-bold text-slate-700 mb-2 flex items-center gap-2">
                        <i data-lucide="image" class="w-4 h-4 text-blue-600"></i>
                        Foto Utama Campaign
                    </label>
                    <div class="relative group">
                        <input type="file" accept="image/*"
                            @change="const file = $event.target.files[0]; if(file) { const reader = new FileReader(); reader.onload = (e) => { imagePreview = e.target.result }; reader.readAsDataURL(file) }"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                        <div :class="imagePreview ? 'border-blue-400 bg-blue-50' : 'border-slate-200 bg-slate-50'"
                            class="border-2 border-dashed rounded-2xl p-8 text-center transition-all min-h-[220px] flex flex-col items-center justify-center mb-2">

                            <template x-if="!imagePreview">
                                <div class="space-y-2">
                                    <p class="text-sm font-bold text-slate-700">Unggah Foto Utama Campaign</p>
                                    <p class="text-xs text-slate-400 leading-relaxed">Format JPG, PNG (Maks. 5MB)</p>
                                </div>
                            </template>

                            <template x-if="imagePreview">
                                <div class="relative w-full">
                                    <img :src="imagePreview" class="rounded-xl w-full h-48 object-cover shadow-md">
                                    <div
                                        class="absolute inset-0 bg-black/40 rounded-xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <p class="text-white text-xs font-bold flex items-center gap-2">
                                            <i data-lucide="refresh-cw" class="w-4 h-4"></i> Ganti Foto
                                        </p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1 mt-5">Judul Campaign</label>
                        <input type="text" placeholder="Contoh: Bantuan Korban Banjir..."
                            class="w-full text-base flex-1 px-4 py-3 bg-slate-50 rounded-xl focus:ring-1 focus:ring-blue-500 outline-none">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1 mt-5">Lokasi</label>
                        <div x-data="{ 
                                open: false, 
                                selected: '', 
                                districts: [
                                    'Ajung', 'Ambulu', 'Arjasa', 'Balung', 'Bangsalsari', 
                                    'Gumukmas', 'Jelbuk', 'Jenggawah', 'Jombang', 'Kalisat', 
                                    'Kaliwates', 'Kencong', 'Ledokombo', 'Mayang', 'Mumbulsari', 
                                    'Panti', 'Patrang', 'Puger', 'Rambipuji', 'Semboro', 
                                    'Silo', 'Sukorambi', 'Sukowono', 'Sumberbaru', 'Sumberjambe', 
                                    'Sumberpucung', 'Sumbersari', 'Tanggul', 'Tempurejo', 'Umbulsari', 'Wuluhan'
                                ] 
                            }" class="relative">
                            <button type="button" @click="open = !open"
                                class="w-full text-base flex items-center justify-between px-4 py-3 bg-slate-50 rounded-xl focus:ring-1 focus:ring-blue-500 outline-none transition-all text-left">
                                <span :class="selected ? 'text-slate-800' : 'text-slate-400'"
                                    x-text="selected ? selected : 'Pilih Kecamatan'"></span>
                                <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 transition-transform"
                                    :class="open ? 'rotate-180' : ''"></i>
                            </button>
                            <input type="hidden" name="location" x-model="selected">
                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                class="absolute z-50 w-full mt-2 bg-white border border-slate-200 rounded-xl shadow-xl max-h-60 overflow-y-auto custom-scrollbar">

                                <div class="p-2">
                                    <template x-for="district in districts" :key="district">
                                        <div @click="selected = district; open = false"
                                            class="px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-600 hover:text-white rounded-lg cursor-pointer transition-colors">
                                            <span x-text="district"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 relative">
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1 mt-5">Untuk Siapa Galang Dana</label>
                        <div x-data="{ 
                                targetOpen: false, 
                                targetSelected: '', 
                                targets: ['Diri Sendiri', 'Teman atau Keluarga', 'Masyarakat'] 
                            }" class="relative">

                            <button type="button" @click="targetOpen = !targetOpen"
                                class="w-full text-base flex items-center justify-between px-4 py-3 bg-slate-50 rounded-xl focus:ring-1 focus:ring-blue-500 outline-none transition-all text-left">
                                <span :class="targetSelected ? 'text-slate-800' : 'text-slate-400'"
                                    x-text="targetSelected ? targetSelected : 'Pilih Penerima'"></span>
                                <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 transition-transform"
                                    :class="targetOpen ? 'rotate-180' : ''"></i>
                            </button>

                            <input type="hidden" name="target_recipient" x-model="targetSelected">

                            <div x-show="targetOpen" @click.away="targetOpen = false" x-cloak
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                class="absolute z-50 w-full mt-2 bg-white border border-slate-200 rounded-xl shadow-xl py-2 overflow-hidden">

                                <div class="p-2">
                                    <template x-for="item in targets" :key="item">
                                        <div @click="targetSelected = item; targetOpen = false"
                                            class="px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-600 hover:text-white rounded-lg cursor-pointer transition-colors">
                                            <span x-text="item"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1 mt-5">Deskripsi & Cerita</label>
                        <textarea rows="4" placeholder="Ceritakan detail kejadian dan kenapa mereka butuh bantuan..."
                            class="w-full text-base flex-1 px-4 py-3 bg-slate-50 rounded-xl focus:ring-1 focus:ring-blue-500 outline-none transition-all leading-relaxed"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1 mt-5">Target Dana</label>
                        <div class="relative group">
                            <div
                                class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                Rp</div>
                            <input type="number" placeholder="0"
                                class="w-full pl-12 pr-4 py-4 bg-slate-50 rounded-xl focus:ring-1 focus:ring-blue-500 focus:bg-white outline-none transition-all font-semibold text-base text-slate-800">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div x-data="{ 
                            selectedDate: '', 
                            daysLeft: 0,
                            init() {
                                const today = new Date().toISOString().split('T')[0];
                                this.$refs.dateInput.min = today;
                            },
                            calculateDays() {
                                if(!this.selectedDate) return;
                                const start = new Date();
                                start.setHours(0,0,0,0);
                                const end = new Date(this.selectedDate);
                                end.setHours(0,0,0,0);
                                
                                const diffTime = end - start;
                                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                                this.daysLeft = diffDays >= 0 ? diffDays : 0;
                            }
                        }">
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1 mt-5">Batas Waktu</label>
                                <div class="relative group">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors pointer-events-none">
                                        <i data-lucide="calendar" class="w-5 h-5"></i>
                                    </div>

                                    <input type="date" x-ref="dateInput" x-model="selectedDate" @change="calculateDays()"
                                        @click="$el.showPicker()"
                                        class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-transparent rounded-xl focus:ring-1 focus:ring-blue-500 focus:bg-white outline-none transition-all text-base text-slate-500 cursor-pointer">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1 mt-5">Lama Campaign Berjalan</label>
                                <div class="relative">
                                    <input type="text" 
                                        readonly 
                                        :value="selectedDate ? daysLeft + ' Hari' : '-'"
                                        placeholder="Pilih tanggal dulu..."
                                        class="w-full text-base flex-1 px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-slate-600 outline-none cursor-not-allowed">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4 pt-5">
                        <button type="submit"
                            class="w-full py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-200 flex items-center justify-center gap-2 group">
                            <span>Ajukan Penggalangan Dana</span>
                        </button>
                        <p class="text-xs text-center text-slate-400 leading-relaxed mt-2">
                            Data yang Anda kirim akan melalui proses moderasi admin selama 1x24 jam sebelum campaign
                            ditayangkan.
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <style>
        input[type="date"]::-webkit-inner-spin-button,
        input[type="date"]::-webkit-calendar-picker-indicator {
            opacity: 0;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            cursor: pointer;
        }
    </style>

@endsection