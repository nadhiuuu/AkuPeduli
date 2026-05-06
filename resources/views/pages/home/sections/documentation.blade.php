<main class="bg-gray-50 relative z-10 -mt-20 pt-20 pb-24">
    <section>
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-14">
                <h2 class="text-3xl md:text-4xl font-bold mb-3">
                    Dokumentasi Penyerahan Donasi
                </h2>
                <p class="text-gray-500 max-w-2xl mx-auto">
                    Dokumentasi ini menunjukkan dampak nyata dari setiap donasi yang Anda berikan.
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">

                @forelse ($documentations as $doc)
                    <a href="{{ route('documentation.detail', $doc->slug) }}"
                        class="block bg-white rounded-2xl shadow-sm hover:shadow-md transition overflow-hidden">

                        <img src="{{ asset('storage/' . $doc->bukti_foto) }}" class="w-full h-48 object-cover">

                        <div class="p-4">
                            <h3 class="font-bold text-slate-800">
                                {{ $doc->campaign->title }}
                            </h3>

                            <p class="text-sm text-slate-500 mt-1">
                                {{ \Illuminate\Support\Str::limit(strip_tags($doc->deskripsi), 80) }}
                            </p>

                            <div class="flex items-center gap-2 mt-4 pt-3 border-t border-slate-200">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($doc->campaign->user->name ?? 'Admin') }}"
                                    class="w-8 h-8 rounded-full object-cover">

                                <div class="leading-tight">
                                    <p class="text-xs font-semibold text-slate-700">
                                        {{ $doc->campaign->user->name ?? 'Admin' }}
                                    </p>

                                    <p class="text-[11px] text-slate-400">
                                        {{ $doc->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>

                @empty
                    <!-- 🔥 EMPTY STATE -->
                    <div class="col-span-full text-center py-20">
                        <h3 class="text-xl font-bold text-slate-600 mb-2">
                            Belum Ada Dokumentasi saat ini.
                        </h3>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</main>
