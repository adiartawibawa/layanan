<div wire:ignore>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
</div>

@script
    <script>
        let geojsonUrl = @js($geojson);
        let searchable = @js($searchable);
        let searchableFields = @js($searchableFields);

        if (!window.leafletMap) {
            console.error('Peta belum diinisialisasi.');
            return;
        }

        // Memuat data GeoJSON ke dalam peta
        fetch(geojsonUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Gagal memuat GeoJSON: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                // Menambahkan layer GeoJSON ke peta
                const layer = L.geoJSON(data).addTo(window.leafletMap);

                $wire.dispatchSelf('loadLayerData');

            })
            .catch(error => {
                console.error('Gagal memuat GeoJSON:', error);
            });
    </script>
@endscript
