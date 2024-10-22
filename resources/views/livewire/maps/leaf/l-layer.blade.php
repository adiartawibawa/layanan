<div>
    <h3 class="text-xl font-semibold mb-4">Layer</h3>
    <div class="space-y-2">
        @foreach ($layers as $layer)
            <div class="flex items-center mb-4 py-2">
                <!-- Switch -->
                <input type="checkbox" id="switch-{{ $layer['name'] }}"
                    wire:click="toggleLayerVisibility('{{ $layer['name'] }}')" {{ $layer['visible'] ? 'checked' : '' }}
                    class="sr-only" />
                <label for="switch-{{ $layer['name'] }}" class="flex w-full items-center cursor-pointer justify-between">
                    <span>{{ $layer['name'] }}</span>
                    <div class="relative ml-3">
                        <div
                            class="block w-12 h-6 rounded-full transition-colors
                                    {{ $layer['visible'] ? 'bg-primary' : 'bg-gray-300' }}">
                        </div>
                        <div
                            class="dot absolute left-0 top-0 bg-white w-6 h-6 rounded-full transition-transform
                                    {{ $layer['visible'] ? 'translate-x-full' : 'translate-x-0' }}">
                        </div>
                    </div>
                </label>
            </div>
        @endforeach
    </div>
</div>
