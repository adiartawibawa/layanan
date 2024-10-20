<div>
    <div wire:ignore id="map" style="height: {{ $height }}; width: {{ $width }};">
    </div>
</div>

@script
    <script>
        let map;

        async function initMap() {
            map = L.map('map').setView([@js($lat), @js($lon)], @js($minZoom));
            window.leafletMap = map; // Menyimpan map ke window agar bisa diakses di komponen lain
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: @js($maxZoom),
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
        }

        initMap();
    </script>
@endscript

@assets
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
@endassets
