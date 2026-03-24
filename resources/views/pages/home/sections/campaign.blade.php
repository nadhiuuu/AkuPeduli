<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

@php
    $campaigns = [];

    for($i=1; $i<=6; $i++){
        $raised = rand(1000000,5000000);
        $goal = 10000000;

        $campaigns[] = [
            'title' => "Campaign Jember #".$i,
            'description' => "Bantuan untuk masyarakat Jember yang membutuhkan.",
            'raised' => $raised,
            'goal' => $goal,
            'percentage' => ($raised / $goal) * 100,
            'image' => "https://i.pravatar.cc/400?img=".$i
        ];
    }
@endphp

<main class="pt-24">
    <section class="pb-20">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-2">
                Peta Kebutuhan Bantuan - Jember
            </h2>
            <p class="text-center text-gray-500 mb-6">
                Pilih lokasi untuk melihat campaign yang membutuhkan bantuan
            </p>
            <div id="map" class="w-full h-[350px] md:h-[450px] rounded-2xl shadow relative z-0"></div>
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
                @foreach($campaigns as $item)
                    <x-campaign-card 
                        :title="$item['title']"
                        :description="$item['description']"
                        :raised="$item['raised']"
                        :goal="$item['goal']"
                        :percentage="$item['percentage']"
                        :image="$item['image']"
                    />
                @endforeach
            </div>
        </div>
    </section>
</main>

<script>
    const map = L.map('map').setView([-8.1724, 113.7003], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    map.scrollWheelZoom.disable();

    const locations = [
        { lat: -8.1724, lng: 113.7003, title: "Kota Jember - Banjir", progress: "70%" },
        { lat: -8.2000, lng: 113.6500, title: "Ajung - Kesehatan", progress: "50%" },
        { lat: -8.1500, lng: 113.7200, title: "Patrang - Pendidikan", progress: "40%" },
        { lat: -8.2300, lng: 113.6800, title: "Rambipuji - Sosial", progress: "65%" }
    ];

    locations.forEach(loc => {
        L.marker([loc.lat, loc.lng])
            .addTo(map)
            .bindPopup(`
                <div class="text-sm">
                    <b>${loc.title}</b><br>
                    <span class="text-gray-500">Progress: ${loc.progress}</span><br>
                    <button class="mt-2 bg-blue-600 text-white px-3 py-1 rounded">
                        Donasi
                    </button>
                </div>
            `);
    });
</script>