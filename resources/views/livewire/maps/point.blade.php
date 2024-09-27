<div>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('mapInitialized', (mapId) => {
                Livewire.dispatch('createLayer', '{{ $layerId }}');

                setTimeout(() => {
                    const map = window.maps[mapId];
                    const layerGroup = window.layerGroups['{{ $layerId }}'];

                    if (map && layerGroup && {{ $latitude ? 'true' : 'false' }} &&
                        {{ $longitude ? 'true' : 'false' }}) {
                        // Tentukan ikon jika ada URL yang diberikan
                        const customIcon = L.icon({
                            iconUrl: `{{ $iconUrl ?? 'https://leafletjs.com/examples/custom-icons/leaf-green.png' }}`, // Gunakan URL ikon atau default
                            iconSize: [50, 50], // Sesuaikan ukuran ikon jika perlu
                            iconAnchor: [25, 50], // Sesuaikan anchor ikon jika perlu
                            className: 'bounce' // Tambahkan kelas 'bounce' untuk animasi
                        });

                        // Tambahkan marker pada layer group sesuai dengan ikon yang diberikan
                        const point = L.marker([{{ $latitude }}, {{ $longitude }}], {
                            icon: customIcon
                        }).addTo(layerGroup);


                        if ({{ $readOnly ? 'true' : 'false' }}) {
                            point.dragging.disable();
                        } else {
                            point.dragging.enable();
                            point.on('dragend', function(event) {
                                var marker = event.target;
                                var position = marker.getLatLng();
                                Livewire.dispatch('pointUpdated', position.lat, position
                                    .lng);
                            });
                        }

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

                if (layerGroup) {
                    layerGroup.eachLayer(function(marker) {
                        if (marker.dragging) {
                            marker.dragging.enable();
                        }
                    });
                } else {
                    console.error("Layer tidak ditemukan untuk edit mode:", data.layerId);
                }
            });
        });
    </script>

</div>
