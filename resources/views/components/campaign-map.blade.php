<div>
    <div id="map" class="w-full h-[350px] md:h-[450px] rounded-2xl shadow relative z-0"></div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const map = L.map('map').setView([-8.1724, 113.7003], 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        map.scrollWheelZoom.disable();

        const campaigns = @json($campaigns);

        campaigns.forEach(item => {
            if(item.lat && item.lng){
                L.marker([item.lat, item.lng])
                    .addTo(map)
                    .bindPopup(`
                        <div class="text-sm">
                            <b>${item.title}</b><br>
                            <span class="text-gray-500">
                                Terkumpul: Rp ${item.raised.toLocaleString()}
                            </span><br>
                            <button class="mt-2 bg-blue-600 text-white px-3 py-1 rounded">
                                Donasi
                            </button>
                        </div>
                    `);
            }
        });
    });
</script>