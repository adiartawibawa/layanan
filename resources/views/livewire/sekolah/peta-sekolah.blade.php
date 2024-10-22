<div x-data="{ showSearch: false, showLayer: false, showLegend: false }"
    class="relative h-screen w-full top-24 md:top-20 bg-primary shadow-lg z-10 overflow-hidden dark:bg-dark">

    <!-- Base Map Component -->
    <livewire:maps.leaf.l-map-container height='100vh'>

        <livewire:maps.leaf.l-geo-json name="Wilayah" model="Desa" :searchable=true returnedField="kecamatan_name"
            groupedBy="kecamatan_name" legendTitle="kecamatan_name" :is-point=false geojson="{{ $wilayahGeoJsonUrl }}" />

        <livewire:maps.leaf.l-geo-json name="Sekolah" model="Sekolah" :searchable=true returnedField="bentuk"
            groupedBy="bentuk_code" legendTitle="bentuk" :is-point=true geojson="{{ $sekolahGeoJsonUrl }}" />

        <!-- Floating Menu -->
        <div class="absolute top-3 right-4 flex flex-col space-y-1 z-[500]">

            <!-- Search Button -->
            <button @click="showSearch = !showSearch"
                class="p-2 bg-primary hover:bg-red-600 text-white rounded-lg shadow-lg focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35M11 5a6 6 0 100 12 6 6 0 000-12z" />
                </svg>
            </button>

            <!-- Layer Button -->
            <button @click="showLayer = !showLayer"
                class="p-2 bg-primary hover:bg-red-600 text-white rounded-lg shadow-lg focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                </svg>

            </button>

            <!-- Legend Button -->
            <button @click="showLegend = !showLegend"
                class="p-2 bg-primary hover:bg-red-600 text-white rounded-lg shadow-lg focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 11c-1.333 0-2-.667-2-2 0-1.333.667-2 2-2s2 .667 2 2c0 1.333-.667 2-2 2zm0 4c-1.333 0-2-.667-2-2s.667-2 2-2 2 .667 2 2c0 1.333-.667 2-2 2zm0 4c-1.333 0-2-.667-2-2 0-1.333.667-2 2-2s2 .667 2 2c0 1.333-.667 2-2 2z" />
                </svg>
            </button>
        </div>

        <!-- Search Drawer -->
        <div x-show="showSearch" @click.outside="showSearch = false" wire:click.outside="$dispatch('resetQuery')"
            x-transition:enter="transform transition ease-in-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="fixed top-16 right-0 py-8 w-80 h-screen bg-gray-1 dark:bg-dark dark:text-white shadow-lg z-[500] p-4 overflow-y-auto">
            <h2 class="text-lg font-semibold mb-4">Search</h2>

            <livewire:maps.leaf.l-map-search />

            <button @click="showSearch = false" wire:click="$dispatch('resetQuery')"
                class="mt-4 mb-14 p-2 bg-primary text-white rounded-lg w-full">Close</button>
        </div>

        <!-- Layer Drawer -->
        <div x-show="showLayer" @click.outside="showLayer = false"
            x-transition:enter="transform transition ease-in-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="fixed top-16 right-0 py-8 w-80 h-screen bg-gray-1 dark:bg-dark dark:text-white shadow-lg z-[500] p-4 overflow-y-auto">

            <livewire:maps.leaf.l-layer />

            <button @click="showLayer = false"
                class="mt-4 mb-14 p-2 bg-primary text-white rounded-lg w-full">Close</button>
        </div>

        <!-- Legend Drawer -->
        <div x-show="showLegend" @click.outside="showLegend = false"
            x-transition:enter="transform transition ease-in-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="fixed top-16 right-0 py-8 w-80 h-screen bg-gray-1 dark:bg-dark dark:text-white shadow-lg z-[500] p-4 overflow-y-auto">

            <livewire:maps.legend />

            <button @click="showLegend = false"
                class="mt-4 mb-14 p-2 bg-primary text-white rounded-lg w-full">Close</button>
        </div>

    </livewire:maps.leaf.l-map-container>
</div>
