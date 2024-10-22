<div>
    <h3 class="text-lg font-semibold mb-4">Layer</h3>
    <div class="space-y-2">
        @foreach ($layers as $layer)
            <div class="flex items-center justify-between w-full">
                <!-- Switch -->
                <input type="checkbox" id="switch-{{ $layer['name'] }}"
                    wire:click="toggleLayerVisibility('{{ $layer['name'] }}')" {{ $layer['visible'] ? 'checked' : '' }}
                    class="sr-only" />
                <label for="switch-{{ $layer['name'] }}" class="flex items-center cursor-pointer">
                    <span class="text-black">{{ $layer['name'] }}</span>
                    <div class="relative ml-3">
                        <div class="block bg-gray-400 w-12 h-6 rounded-full"></div>
                        <div
                            class="dot absolute left-0 top-0 bg-white w-6 h-6 rounded-full transition transform {{ $layer['visible'] ? 'translate-x-full bg-primary' : '' }}">
                        </div>
                    </div>
                </label>
            </div>
        @endforeach
    </div>

</div>
