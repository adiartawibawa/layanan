<div>
    <h3 class="text-lg font-semibold mb-4">Layer Legend</h3>
    <ul class="space-y-2">
        @foreach ($layers as $layer)
            <li class="flex items-center">
                <input type="checkbox" wire:click="toggleLayerVisibility('{{ $layer['name'] }}')"
                    {{ $layer['visible'] ? 'checked' : '' }}>
                {{ $layer['name'] }}
            </li>
        @endforeach
    </ul>
</div>
