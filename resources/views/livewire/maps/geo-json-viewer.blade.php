<div wire:ignore>
    <script>
        document.addEventListener('livewire:init', () => {
            // Listener untuk 'mapInitialized' event dari Livewire
            Livewire.on('mapInitialized', (mapId) => {
                // Kirim event untuk membuat layer baru dengan ID yang diberikan
                Livewire.dispatch('createLayer', '{{ $layerId }}');

                setTimeout(() => {
                    const map = window.maps[mapId];
                    const layerGroup = window.layerGroups['{{ $layerId }}'];

                    if (map && layerGroup) {
                        // Bersihkan layer sebelumnya jika ada
                        layerGroup.clearLayers();

                        // Ambil data GeoJSON dari URL yang diberikan
                        fetchGeoJsonData('{{ $geoJsonUrl }}', '{{ $isPoint }}', layerGroup,
                            map);
                    }
                }, 500); // Delay untuk memastikan peta sudah siap
            });
        });

        /**
         * Ambil data GeoJSON dari URL yang diberikan dan tambahkan ke layerGroup
         * @param {string} geoJsonUrl - URL untuk GeoJSON
         * @param {boolean} isPoint - Apakah GeoJSON berupa point atau bukan
         * @param {object} layerGroup - Leaflet layer group untuk menambahkan layer
         * @param {object} map - Objek peta dari Leaflet
         */
        function fetchGeoJsonData(geoJsonUrl, isPoint, layerGroup, map) {
            fetch(geoJsonUrl)
                .then(response => response.json())
                .then(geoJsonData => {
                    // Tentukan opsi berdasarkan apakah data adalah Point atau bukan
                    const geoJsonOptions = buildGeoJsonOptions(isPoint, layerGroup);

                    // Buat layer GeoJSON
                    const geoJsonLayer = L.geoJSON(geoJsonData, geoJsonOptions);

                    // Tambahkan layer ke peta dan sesuaikan bounds
                    addGeoJsonLayerToMap(geoJsonLayer, isPoint, layerGroup, map);
                })
                .catch(error => console.error("Failed to load GeoJSON:", error));
        }

        /**
         * Tentukan opsi untuk GeoJSON layer
         * @param {boolean} isPoint - Apakah data GeoJSON berisi point
         * @param {object} layerGroup - Leaflet layer group
         * @returns {object} - Opsi GeoJSON
         */
        function buildGeoJsonOptions(isPoint, layerGroup) {
            const geoJsonOptions = {};

            if (isPoint) {
                geoJsonOptions.pointToLayer = (feature, latlng) => createCustomMarker(feature, latlng);
            } else {
                geoJsonOptions.style = (feature) => getFeatureStyle(feature);
            }

            geoJsonOptions.onEachFeature = (feature, layer) => onEachFeatureHandler(feature, layer, isPoint, layerGroup);

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
                const iconUrl = feature.styles.icon;

                const customIcon = L.icon({
                    iconUrl: iconUrl,
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
            if (feature.styles) {
                const s = feature.styles;
                return {
                    color: s.stroke || '#3388ff',
                    weight: s['stroke-width'] || 3,
                    opacity: s['stroke-opacity'] || 1.0,
                    fillColor: s.fill || s.stroke || '#3388ff',
                    fillOpacity: s['fill-opacity'] || 0.5,
                    dashArray: '3',
                };
            }

            return {
                color: '#3388ff',
                weight: 2,
                opacity: 1.0,
                fillColor: '#3388ff',
                fillOpacity: 0.2,
                dashArray: '3',
            };
        }

        /**
         * Handler untuk setiap fitur dalam GeoJSON
         * @param {object} feature - Fitur GeoJSON
         * @param {object} layer - Layer Leaflet
         * @param {boolean} isPoint - Apakah fitur adalah Point
         * @param {object} layerGroup - Group layer untuk clustering
         */
        function onEachFeatureHandler(feature, layer, isPoint, layerGroup) {
            if (feature.properties && feature.properties.nama) {
                layer.bindPopup(`<strong>${feature.properties.nama}</strong>`);
            }

            if (isPoint && feature.geometry.type === 'Point') {
                // Tambahkan marker ke markerClusterGroup jika data adalah point
                const markerClusterGroup = getMarkerClusterGroup(layerGroup);
                markerClusterGroup.addLayer(layer);
            }
        }

        /**
         * Dapatkan atau buat MarkerClusterGroup jika belum ada
         * @param {object} layerGroup - Group layer Leaflet
         * @returns {object} - MarkerClusterGroup
         */
        function getMarkerClusterGroup(layerGroup) {
            // Cek apakah markerClusterGroup sudah ada
            if (!layerGroup.markerClusterGroup) {
                // Buat MarkerClusterGroup baru dan tambahkan ke layerGroup
                layerGroup.markerClusterGroup = L.markerClusterGroup();
                layerGroup.addLayer(layerGroup.markerClusterGroup);
            }
            return layerGroup.markerClusterGroup;
        }

        /**
         * Tambahkan layer GeoJSON ke peta dan sesuaikan bounds
         * @param {object} geoJsonLayer - Layer GeoJSON
         * @param {boolean} isPoint - Apakah fitur adalah Point
         * @param {object} layerGroup - Layer group untuk clustering
         * @param {object} map - Peta Leaflet
         */
        function addGeoJsonLayerToMap(geoJsonLayer, isPoint, layerGroup, map) {
            if (isPoint) {
                // Tambahkan MarkerClusterGroup jika ada Point
                const markerClusterGroup = getMarkerClusterGroup(layerGroup);
                markerClusterGroup.addLayer(geoJsonLayer);
            } else {
                geoJsonLayer.addTo(layerGroup);
            }

            // Sesuaikan bounds jika GeoJSON memiliki data
            if (geoJsonLayer.getLayers().length > 0) {
                map.fitBounds(geoJsonLayer.getBounds());
            } else {
                console.warn("GeoJSON layer is empty, cannot fit bounds.");
            }
        }
    </script>
</div>

<!-- Include MarkerCluster only if isPoint is true -->
@push('scripts')
    @if ($isPoint)
        <!-- MarkerCluster CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />

        <!-- MarkerCluster JS -->
        <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
    @endif
@endpush
