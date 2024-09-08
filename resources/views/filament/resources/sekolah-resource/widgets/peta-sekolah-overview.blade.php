<x-filament-widgets::widget>
    <x-filament::section>
        <div id="map" style="height: 400px; z-index:0;" x-data="{
            init() {
                const map = L.map('map').setView([-8.6042279, 115.1761774], {{ $this->zoomLevel }});
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: `<a href='http://www.openstreetmap.org/copyright'>OpenStreetMap</a>`
                }).addTo(map);
        
                let desa = {{ $this->desa }};
                let layerDesa = L.geoJSON(desa, {
                    style: function(feature) {
                        return {
                            {{-- Warna diambil dari properti color dalam geojson --}}
                            fillColor: feature.properties.color,
                            {{-- Atur opasitas --}}
                            fillOpacity: 0.5,
                            {{-- Warna garis tepi --}}
                            color: feature.properties.color,
                            {{-- Ketebalan garis tepi --}}
                            weight: 1,
                        };
                    }
                }).addTo(map);
        
                {{-- Tambahkan pop-up ke setiap fitur --}}
                layerDesa.eachLayer(function(layer) {
                    let properties = layer.feature.properties;
                    let popupContent = `<b>Desa:</b> ${properties.name}<br><b>Kecamatan:</b> ${properties.kecamatan_name}<br><b>Kabupaten:</b> ${properties.kabupaten_name}`;
                    layer.bindPopup(popupContent);
                });
        
                {{-- Tambahkan event listener untuk setiap fitur --}}
                layerDesa.eachLayer(function(layer) {
                    layer.on('mouseover', function() {
                        // Ubah ketebalan garis saat fitur dihover
                        layer.setStyle({ weight: 5 }); // Ubah ketebalan garis menjadi 5 saat fitur dihover
                    });
        
                    layer.on('mouseout', function() {
                        // Kembalikan ketebalan garis ke nilai awal saat fitur tidak dihover
                        layer.setStyle({ weight: 1 }); // Kembalikan ketebalan garis ke nilai awal
                    });
        
                    layer.on('click', function() {
                        // Perbarui ketebalan garis saat fitur diklik
                        layer.setStyle({ weight: 5 }); // Ubah ketebalan garis menjadi 5 saat fitur diklik
                    });
                });
        
                let sekolah = {{ $this->sekolah }};
                let layerSekolah = L.geoJSON(sekolah, {
                    pointToLayer: function(feature, latlng) {
                        {{-- Icon diambil dari properti icon dalam geojson --}}
                        let iconUrl = feature.properties.icon;
                        let icon = L.icon({
                            iconUrl: iconUrl,
                            iconSize: [50, 50], // Sesuaikan ukuran ikon jika perlu
                            iconAnchor: [25, 50], // Sesuaikan anchor ikon jika perlu
                            className: 'bounce' // Tambahkan kelas 'bounce' untuk animasi
                        });
                        return L.marker(latlng, { icon: icon });
                    },
                });
        
                {{-- Tambahkan pop-up ke setiap fitur --}}
                layerSekolah.eachLayer(function(layer) {
                    let properties = layer.feature.properties;
                    let popupContent = `<div class='mb-4 text-xl font-semibold'>${properties.nama}</div>` +
                        `<div class=''>NPSN : ${properties.npsn}</div>` +
                        `<div class=''>Status : ${properties.status}</div>` +
                        `<div class=''>Alamat : ${properties.alamat}</div>`;
                    layer.bindPopup(popupContent);
                });
        
                const markerSekolah = L.markerClusterGroup().addLayer(layerSekolah);
        
                map.addLayer(markerSekolah);
                map.fitBounds(markerSekolah.getBounds());
            }
        }" wire:ignore>

        </div>
    </x-filament::section>
</x-filament-widgets::widget>
