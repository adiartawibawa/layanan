<div wire:ignore>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
</div>

@script
    <script>
        let geojsonUrl = @js($geojson);
        let isPoint = @js($isPoint);
        let name = @js($name);

        // Objek penyimpan layer GeoJSON
        let layers = {};

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
         */
        function fetchGeoJsonData(geoJsonUrl, isPoint, map, markerClusterGroup) {
            fetch(geoJsonUrl)
                .then(response => {
                    if (!response.ok) throw new Error('Gagal memuat GeoJSON: ' + response.statusText);
                    return response.json();
                })
                .then(geoJsonData => {
                    // Gunakan parameter 'name' dari masing-masing komponen jika ada
                    const geoJsonLayer = L.geoJSON(geoJsonData, buildGeoJsonOptions(isPoint, markerClusterGroup));

                    // Simpan layer dengan menggunakan 'name' yang di-push dari Livewire
                    const layerName = name || geoJsonData.name || 'Layer ' + Object.keys(layers).length;
                    layers[layerName] = geoJsonLayer;

                    if (isPoint) {
                        markerClusterGroup.addLayer(geoJsonLayer);
                        map.addLayer(markerClusterGroup);
                        map.fitBounds(markerClusterGroup.getBounds());
                    } else {
                        geoJsonLayer.addTo(map);
                        map.fitBounds(geoJsonLayer.getBounds());
                    }

                    console.log("Layer ditambahkan:", layerName);
                    $wire.dispatchSelf('loadLayerData');
                    $wire.dispatch('layerAdded', {
                        name: layerName
                    });
                })
                .catch(error => console.error("Gagal memuat GeoJSON:", error));
        }


        function buildGeoJsonOptions(isPoint, markerClusterGroup) {
            const geoJsonOptions = {};

            if (isPoint) {
                geoJsonOptions.pointToLayer = (feature, latlng) => createCustomMarker(feature, latlng);
            } else {
                geoJsonOptions.style = getFeatureStyle;
            }

            geoJsonOptions.onEachFeature = (feature, layer) => {
                layer.bindPopup(`<strong>${feature.properties?.nama ?? feature.properties?.desa_name}</strong>`);
                if (isPoint && feature.geometry.type === 'Point') {
                    markerClusterGroup.addLayer(layer);
                }
            };

            return geoJsonOptions;
        }

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
            return L.marker(latlng); // Marker default
        }

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
         * Fungsi untuk menampilkan atau menyembunyikan layer
         */
        function toggleLayerVisibility(layerName, visible) {
            const layer = layers[layerName];
            if (layer) {
                if (visible) {
                    // Show layer
                    if (isPoint) {
                        // Jika marker cluster belum ada di peta, tambahkan kembali
                        if (!window.leafletMap.hasLayer(markerClusterGroup)) {
                            window.leafletMap.addLayer(markerClusterGroup);
                            markerClusterGroup.addLayer(layer); // Tambahkan kembali layer ke cluster
                        }
                    } else {
                        if (!window.leafletMap.hasLayer(layer)) {
                            window.leafletMap.addLayer(layer);
                        }
                    }
                    console.log("Layer ditampilkan:", layerName);
                } else {
                    // Hide layer
                    if (isPoint) {
                        // Hapus layer point dari MarkerClusterGroup
                        if (window.leafletMap.hasLayer(markerClusterGroup)) {
                            markerClusterGroup.removeLayer(layer); // Hapus layer dari cluster
                            window.leafletMap.removeLayer(markerClusterGroup);
                        }
                    } else {
                        if (window.leafletMap.hasLayer(layer)) {
                            window.leafletMap.removeLayer(layer);
                        }
                    }
                    console.log("Layer disembunyikan:", layerName);
                }
            } else {
                console.error(`Layer dengan nama ${layerName} tidak ditemukan.`);
            }
        }

        $wire.on('toggleLayer', (event) => {
            console.log("Event toggleLayer diterima:", event);

            const {
                layerName,
                visible
            } = event;

            if (typeof toggleLayerVisibility === 'function') {
                toggleLayerVisibility(layerName, visible);
            } else {
                console.error('toggleLayerVisibility is not a function');
            }
        });
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
