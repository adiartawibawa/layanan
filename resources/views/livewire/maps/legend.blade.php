<div>
    <h3 class="text-lg font-semibold mb-4">Legenda</h3>
    <div class="space-y-2">
        @foreach ($legendData as $item)
            <livewire:maps.legend-item :data=$item />
        @endforeach
    </div>
</div>
