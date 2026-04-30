@props([
    'campaigns' => [],
    'regions' => [],
])

<div>
    <div id="map" class="w-full h-[350px] md:h-[450px] rounded-2xl shadow relative z-0"></div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const mapElement = document.getElementById('map');

        if (! mapElement || mapElement.dataset.initialized === 'true') {
            return;
        }

        mapElement.dataset.initialized = 'true';

        const map = L.map('map').setView([-8.1724, 113.7003], 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        map.scrollWheelZoom.disable();

        const campaigns = @json($campaigns);
        const regions = @json($regions);
        const regionColors = new Map(Object.entries(regions));

        const normalize = (value) => String(value ?? '')
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, ' ')
            .trim();

        const featureDistrictName = (feature) => {
            const props = feature?.properties ?? {};

            return props.kecamatan
                || props.Kecamatan
                || props.nm_kecamatan
                || props.NM_KECAMATAN
                || props.NAME_3
                || props.name
                || props.NAMOBJ
                || '';
        };

        const renderCampaignMarkers = () => {
            campaigns.forEach(item => {
                if (! item.lat || ! item.lng) {
                    return;
                }

                L.circleMarker([item.lat, item.lng], {
                    radius: 8,
                    color: item.severity_color,
                    fillColor: item.severity_color,
                    fillOpacity: 0.8,
                    weight: 2,
                })
                    .addTo(map)
                    .bindPopup(`
                        <div class="text-sm">
                            <b>${item.title}</b><br>
                            <span>${item.kecamatan ?? '-'}${item.desa ? ' - ' + item.desa : ''}</span><br>
                            <span style="color:${item.severity_color}; font-weight:600;">${item.severity_label}</span><br>
                            <span class="text-gray-500">Terkumpul: Rp ${Number(item.raised ?? 0).toLocaleString('id-ID')}</span><br>
                            <a href="${item.url}" class="inline-block mt-2 bg-blue-600 text-white px-3 py-1 rounded">
                                Donasi
                            </a>
                        </div>
                    `);
            });
        };

        const renderRegionLayer = async () => {
            try {
                const response = await fetch('/data/jember-kecamatan.geojson');

                if (! response.ok) {
                    renderCampaignMarkers();
                    return;
                }

                const geoJson = await response.json();

                L.geoJSON(geoJson, {
                    style: (feature) => {
                        const districtKey = normalize(featureDistrictName(feature));
                        const region = regionColors.get(districtKey);
                        const color = region?.severity_color ?? '#e5e7eb';

                        return {
                            color,
                            weight: 2,
                            fillColor: color,
                            fillOpacity: 0.28,
                        };
                    },
                    onEachFeature: (feature, layer) => {
                        const districtName = featureDistrictName(feature);
                        const region = regionColors.get(normalize(districtName));
                        const titles = region?.campaign_titles ?? [];
                        const summary = titles.length
                            ? titles.map(title => `<li>${title}</li>`).join('')
                            : '<li>Belum ada campaign aktif</li>';

                        layer.bindPopup(`
                            <div class="text-sm">
                                <b>${districtName || 'Kecamatan'}</b><br>
                                <span style="font-weight:600; color:${region?.severity_color ?? '#9ca3af'};">
                                    ${region?.severity_label ?? 'Belum ada data'}
                                </span><br>
                                <span>${region?.campaign_count ?? 0} campaign aktif</span>
                                <ul class="mt-2 list-disc pl-4">${summary}</ul>
                            </div>
                        `);
                    }
                }).addTo(map);

                renderCampaignMarkers();
            } catch (error) {
                renderCampaignMarkers();
            }
        };

        renderRegionLayer();
    });
</script>
