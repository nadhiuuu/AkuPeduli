<main class="pt-24">
    <section class="pb-20">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-2">
                Peta Kebutuhan Bantuan - Jember
            </h2>
            <p class="text-center text-gray-500 mb-6">
                Pilih lokasi untuk melihat campaign yang membutuhkan bantuan
            </p>
            <x-campaign-map :campaigns="$campaigns" />
        </div>
    </section>
    <section class="pb-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4">

            <h2 class="text-2xl md:text-3xl font-bold text-center mb-2">
                Campaign Unggulan
            </h2>

            <p class="text-center text-gray-500 mb-6">
                Sedikit kebaikan dari kita adalah harapan besar bagi mereka yang membutuhkan. Ayo berdonasi sekarang!
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($campaigns as $item)
                    <x-campaign-card :slug="$item['slug']" :category="$item['category']" :title="$item['title']" :description="$item['description']"
                        :raised="$item['raised']" :goal="$item['goal']" :percentage="$item['percentage']" :image="$item['image']" :donors="$item['donors_count']"
                        :days_left="$item['days_left']" />
                @endforeach
            </div>

            <div class="pt-6 text-center">
                <a href="{{ route('donation.index') }}"
                    class="inline-block px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    Lihat Semua Campaign
                </a>
            </div>
        </div>
    </section>

</main>
