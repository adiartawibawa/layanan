<div wire:ignore>
    {{-- Nothing in the world is as soft and yielding as water. --}}
</div>

@script
    <script>
        let latitude = @js($latitude);
        let longitude = @js($longitude);
        let iconUrl = @js($iconUrl);

        console.log(iconUrl);


        if (!window.leafletMap) {
            console.error('Peta belum diinisialisasi.');
            return;
        }

        const customIcon = L.icon({
            iconUrl: iconUrl || 'https://leafletjs.com/examples/custom-icons/leaf-green.png',
            iconSize: [50, 50],
            iconAnchor: [25, 50],
            className: 'bounce'
        });

        // Gunakan ikon custom pada marker
        const marker = L.marker([latitude, longitude], {
            // icon: customIcon
        }).addTo(window.leafletMap);

        window.leafletMap.setView([latitude, longitude], 15);
    </script>
@endscript


@push('styles')
    <style>
        .bounce {
            animation: bounce 1s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }
    </style>
@endpush
