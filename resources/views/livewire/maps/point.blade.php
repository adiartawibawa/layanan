<div wire:ignore>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('mapInitialized', (mapId) => {
                Livewire.dispatch('createLayer', '{{ $layerId }}');

                setTimeout(() => {
                    const map = window.maps[mapId];
                    const layerGroup = window.layerGroups['{{ $layerId }}'];

                    if (isMapLayerValid(map, layerGroup) && areCoordinatesValid(
                            '{{ $latitude }}', '{{ $longitude }}')) {
                        const point = createMarker(layerGroup, '{{ $latitude }}',
                            '{{ $longitude }}', '{{ $iconUrl }}', {{ $readOnly }});

                        // Atur tampilan peta dengan posisi dan zoom yang sesuai
                        map.setView([{{ $latitude }}, {{ $longitude }}], 15);
                    } else {
                        console.error("Layer atau Map tidak ditemukan atau koordinat tidak valid:",
                            mapId, '{{ $layerId }}', {{ $latitude }},
                            {{ $longitude }});
                    }
                }, 500);
            });

            Livewire.on('enable-edit-mode', (data) => {
                const layerGroup = window.layerGroups[data.layerId];
                enableMarkerEditing(layerGroup);
            });
        });

        /**
         * Fungsi untuk memvalidasi apakah peta dan layer group tersedia
         * @param {object} map - Objek peta dari Leaflet
         * @param {object} layerGroup - Leaflet layer group
         * @returns {boolean} - True jika valid
         */
        function isMapLayerValid(map, layerGroup) {
            return map && layerGroup;
        }

        /**
         * Fungsi untuk memvalidasi koordinat latitude dan longitude
         * @param {string} latitude - Nilai latitude
         * @param {string} longitude - Nilai longitude
         * @returns {boolean} - True jika koordinat valid
         */
        function areCoordinatesValid(latitude, longitude) {
            return latitude && longitude;
        }

        /**
         * Fungsi untuk membuat marker baru dan menambahkannya ke layer group
         * @param {object} layerGroup - Leaflet layer group
         * @param {string} latitude - Nilai latitude
         * @param {string} longitude - Nilai longitude
         * @param {string|null} iconUrl - URL ikon, atau null jika default
         * @param {boolean} readOnly - Apakah marker dalam mode read-only
         * @returns {object} - Objek marker yang telah ditambahkan
         */
        function createMarker(layerGroup, latitude, longitude, iconUrl, readOnly) {
            const customIcon = L.icon({
                iconUrl: iconUrl ||
                'https://leafletjs.com/examples/custom-icons/leaf-green.png', // Gunakan URL ikon atau default
                iconSize: [50, 50], // Ukuran ikon
                iconAnchor: [25, 50], // Anchor point ikon
                className: 'bounce' // Kelas animasi
            });

            const point = L.marker([latitude, longitude], {
                icon: customIcon
            }).addTo(layerGroup);

            if (readOnly) {
                point.dragging.disable();
            } else {
                enableMarkerDragging(point);
            }

            return point;
        }

        /**
         * Fungsi untuk mengaktifkan dragging pada marker dan mengirimkan event ketika marker dipindahkan
         * @param {object} marker - Marker Leaflet
         */
        function enableMarkerDragging(marker) {
            marker.dragging.enable();

            marker.on('dragend', function(event) {
                const position = event.target.getLatLng();
                Livewire.dispatch('pointUpdated', position.lat, position.lng);
            });
        }

        /**
         * Fungsi untuk mengaktifkan mode edit pada marker
         * @param {object} layerGroup - Leaflet layer group
         */
        function enableMarkerEditing(layerGroup) {
            if (layerGroup) {
                layerGroup.eachLayer(function(marker) {
                    if (marker.dragging) {
                        marker.dragging.enable();
                    }
                });
            } else {
                console.error("Layer tidak ditemukan untuk edit mode.");
            }
        }
    </script>
</div>
