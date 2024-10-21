<div wire:ignore>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
</div>

@script
    <script>
        let geojsonUrl = @js($geojson);
        let isPoint = @js($isPoint);

        if (!window.leafletMap) {
            console.error('Peta belum diinisialisasi.');
            return;
        }

        // Inisialisasi MarkerClusterGroup jika data berupa Point
        let markerClusterGroup = isPoint ? L.markerClusterGroup() : null;

        // Memuat data GeoJSON ke dalam peta
        fetchGeoJsonData(geojsonUrl, isPoint, window.leafletMap, markerClusterGroup);

        /**
         * Ambil data GeoJSON dari URL yang diberikan dan tambahkan ke peta
         * @param {string} geoJsonUrl - URL untuk GeoJSON
         * @param {boolean} isPoint - Apakah GeoJSON berupa point atau bukan
         * @param {object} map - Objek peta dari Leaflet
         * @param {object} markerClusterGroup - Cluster untuk marker jika isPoint true
         */
        function fetchGeoJsonData(geoJsonUrl, isPoint, map, markerClusterGroup) {
            fetch(geoJsonUrl)
                .then(response => {
                    if (!response.ok) throw new Error('Gagal memuat GeoJSON: ' + response.statusText);
                    return response.json();
                })
                .then(geoJsonData => {
                    // Buat layer GeoJSON dengan opsi yang sesuai
                    const geoJsonLayer = L.geoJSON(geoJsonData, buildGeoJsonOptions(isPoint, markerClusterGroup));

                    if (isPoint) {
                        // Jika data adalah Point, tambahkan ke MarkerClusterGroup
                        markerClusterGroup.addLayer(geoJsonLayer);
                        map.addLayer(markerClusterGroup); // Tambahkan cluster ke peta
                        map.fitBounds(markerClusterGroup.getBounds()); // Sesuaikan bounds dengan cluster
                    } else {
                        geoJsonLayer.addTo(map); // Untuk data non-Point, tambahkan langsung ke peta
                        map.fitBounds(geoJsonLayer.getBounds()); // Sesuaikan bounds dengan layer non-Point
                    }

                    $wire.dispatchSelf('loadLayerData');
                })
                .catch(error => console.error("Gagal memuat GeoJSON:", error));
        }

        /**
         * Tentukan opsi untuk GeoJSON layer
         * @param {boolean} isPoint - Apakah data GeoJSON berisi point
         * @param {object} markerClusterGroup - Cluster untuk marker jika isPoint true
         * @returns {object} - Opsi GeoJSON
         */
        function buildGeoJsonOptions(isPoint, markerClusterGroup) {
            const geoJsonOptions = {};

            if (isPoint) {
                geoJsonOptions.pointToLayer = (feature, latlng) => createCustomMarker(feature, latlng);
            } else {
                geoJsonOptions.style = getFeatureStyle;
            }

            geoJsonOptions.onEachFeature = (feature, layer) => {
                if (feature.properties && feature.properties.nama) {
                    layer.bindPopup(`<strong>${feature.properties.nama}</strong>`);
                }

                if (isPoint && feature.geometry.type === 'Point') {
                    // Jika data point, tambahkan ke MarkerClusterGroup
                    markerClusterGroup.addLayer(layer);
                }
            };

            return geoJsonOptions;
        }

        /**
         * Buat marker kustom jika ada ikon, atau kembalikan marker default
         * @param {object} feature - Fitur GeoJSON
         * @param {object} latlng - LatLng dari fitur GeoJSON
         * @returns {object} - Leaflet marker
         */
        function createCustomMarker(feature, latlng) {
            if (feature.styles && feature.styles.icon) {
                const customIcon = L.icon({
                    iconUrl: feature.styles.icon,
                    iconSize: [40, 40],
                    iconAnchor: [20, 40],
                });
                return L.marker(latlng, {
                    icon: customIcon
                });
            }
            return L.marker(latlng); // Default marker
        }

        /**
         * Tentukan style untuk fitur GeoJSON
         * @param {object} feature - Fitur GeoJSON
         * @returns {object} - Style untuk GeoJSON
         */
        function getFeatureStyle(feature) {
            const s = feature.styles || {};
            return {
                color: s.stroke || '#3388ff',
                weight: s['stroke-width'] || 3,
                opacity: s['stroke-opacity'] || 1.0,
                fillColor: s.fill || s.stroke || '#3388ff',
                fillOpacity: s['fill-opacity'] || 0.5,
                dashArray: '3',
            };
        }

        /**
         * Dapatkan atau buat MarkerClusterGroup jika belum ada
         * @returns {object} - MarkerClusterGroup
         */
        function getMarkerClusterGroup() {
            if (!window.leafletMap.markerClusterGroup) {
                window.leafletMap.markerClusterGroup = L.markerClusterGroup();
                window.leafletMap.addLayer(window.leafletMap.markerClusterGroup);
            }
            return window.leafletMap.markerClusterGroup;
        }
    </script>
@endscript

<!-- Include MarkerCluster hanya jika isPoint true -->
@push('scripts')
    @if ($isPoint)
        <!-- MarkerCluster CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />

        <!-- MarkerCluster JS -->
        <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
    @endif
@endpush
