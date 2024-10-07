<div
    class="relative h-screen w-full bg-primary shadow-lg z-10 overflow-hidden pt-[60px] md:pt-[65px] lg:pt-[80px] dark:bg-dark">
    <livewire:maps.geo-json-search />
    <livewire:maps.base-map height="100vh" width="100%">
        {{-- komponen lain yang relevan --}}
        <livewire:maps.geo-json-viewer geo-json-url="{{ $sekolahGeoJsonUrl }}" is-point=true allowSearch="true"
            searchableProperties="nama, alamat" layerId="sekolahGeoJsonLayer" />
        <livewire:maps.geo-json-viewer geo-json-url="{{ $wilayahGeoJsonUrl }}" allowSearch="true"
            searchableProperties="desa_name" layerId="wilayahGeoJsonLayer" />
    </livewire:maps.base-map>
</div>
