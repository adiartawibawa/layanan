<!-- Div container untuk Leaflet Map -->
<div class="rounded-lg" style="height: {{ $height }}; width: {{ $width }};">
    <div id="{{ $mapId }}" class="h-full w-full rounded-lg"></div>
</div>


@assets
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
@endassets

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            var map = L.map('{{ $mapId }}').setView([0, 0], 2);

            // Tambahkan tile layer dari OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Simpan instance peta ke objek global agar bisa diakses oleh child component
            if (!window.maps) window.maps = {};
            window.maps['{{ $mapId }}'] = map;

            // Siapkan objek layer groups
            if (!window.layerGroups) window.layerGroups = {};

            // Fungsi untuk membuat layer secara dinamis jika belum ada
            function createLayer(layerId) {
                if (!window.layerGroups[layerId]) {
                    window.layerGroups[layerId] = L.layerGroup().addTo(map);
                }
            }

            // Mendengar event dari child component untuk membuat layer baru jika diperlukan
            Livewire.on('createLayer', (layerId) => {
                createLayer(layerId);
            });

            // Emit event ke child component bahwa map telah siap digunakan
            Livewire.dispatch('mapInitialized', '{{ $mapId }}');
        });
    </script>
@endpush
