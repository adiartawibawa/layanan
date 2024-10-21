<div>
    @foreach ($legendData as $item)
        <livewire:maps.legend-item :data=$item />
        {{-- <livewire:maps.legend-item name="{{ $item['name'] }}" data-url="{{ $item['geojson'] }}"
            grouped-by="{{ $item['groupedBy'] }}" /> --}}
    @endforeach
</div>
