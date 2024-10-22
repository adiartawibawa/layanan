<div>
    <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                <path
                    d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </span>

        <input wire:model.live="query" type="text"
            class="w-full py-3 pl-10 pr-4 text-gray-700 bg-white border rounded-md dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40"
            placeholder="Search">
    </div>

    <!-- Skeleton loader saat loading pencarian -->
    <div wire:loading class="mt-4">
        <div class="flex w-full max-w-sm animate-pulse overflow-hidden bg-white dark:bg-gray-800 rounded-md">
            <div class="w-1/4 bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                {{--  --}}
            </div>
            <div class="w-3/4 p-4 md:p-4">
                <h1 class="h-2 w-40 rounded-lg bg-gray-200 dark:bg-gray-700"></h1>
                <p class="mt-4 h-2 w-48 rounded-lg bg-gray-200 dark:bg-gray-700"></p>
                <p class="mt-4 h-2 w-56 rounded-lg bg-gray-200 dark:bg-gray-700"></p>
                <p class="mt-4 h-2 w-44 rounded-lg bg-gray-200 dark:bg-gray-700"></p>
            </div>
        </div>
    </div>

    <!-- Cek apakah ada hasil pencarian -->
    <div wire:loading.remove>
        @if (!empty($searchResults))
            @foreach ($searchResults as $searchResult)
                @foreach ($searchResult as $result)
                    <div class="flex w-full max-w-full overflow-hidden bg-white dark:bg-gray-800 rounded-md mt-4 hover:cursor-pointer"
                        wire:click="$dispatch('zoomTo', { lat: {{ $result->meta['lat'] }}, lng: {{ $result->meta['lon'] }} })">
                        <div class="w-1/4 bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                            @if (!empty($result->icon))
                                <img class="object-cover shadow-inner" src="{{ $result->icon }}"
                                    alt="{{ $result->nama }}">
                                {{-- @endif --}}
                            @elseif (!empty($result->meta['geometry']))
                                <livewire:maps.map-thumbnail :id="$result->id" :meta="$result->meta" />
                            @endif
                        </div>
                        <div class="w-3/4 pt-4 pl-4 pb-4 pr-0">
                            <h1 class="text-lg font-bold">
                                {{ $result->nama ?? $result->name }}</h1>
                            <p class="text-base text-gray-500">
                                {{ $result->alamat ?? $result->kecamatanName }}</p>
                            <p class="text-sm italic text-gray-300">
                                {{ $result->bentuk->name ?? $result->kabupatenName }}</p>
                        </div>
                    </div>
                @endforeach
            @endforeach
        @else
            <!-- Pesan jika tidak ada hasil pencarian -->
            @if (!empty($query))
                <p>No results found for "{{ $query }}"</p>
            @endif
        @endif
    </div>

    @script
        <script>
            let mapContainer = window.leafletMap;

            if (!mapContainer) {
                console.error('Peta belum diinisialisasi.');
                return;
            }

            function zoomTo(latitude, longitude) {
                if (latitude && longitude) {
                    mapContainer.setView(new L.LatLng(latitude, longitude));
                    mapContainer.setZoom(18);
                } else {
                    console.error('Koordinat tidak valid:', latitude, longitude);
                }
            }

            $wire.on('zoomTo', (event) => {
                // Pastikan detail ada dan bukan undefined
                if (event && event.lat && event.lng) {
                    zoomTo(event.lat, event.lng); // Memanggil fungsi zoomTo dengan lat dan lng
                } else {
                    console.error('Event tidak tersedia atau koordinat tidak valid:', event);
                }
            });
        </script>
    @endscript
</div>
