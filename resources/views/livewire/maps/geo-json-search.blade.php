<div>
    <input class="w-full p-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary" type="text"
        wire:model.live.debounce.500ms="searchQuery" placeholder="Search..." />

    <!-- Daftar hasil pencarian -->
    @if (!empty($searchResults))
        <div class="mt-2 bg-white border border-gray-200 rounded-lg shadow-lg">
            <ul class="divide-y divide-gray-200">
                @foreach ($searchResults as $result)
                    <li class="p-4 hover:bg-gray-50 cursor-pointer transition"
                        wire:click="$emit('zoomToLocation', {{ $result['id'] }})">
                        <div class="font-semibold text-gray-900">
                            {{ $result['name'] }}
                        </div>
                        <div class="text-sm text-gray-600">
                            {{ $result['address'] }}
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        @if (!empty($searchQuery))
            <div class="mt-2 text-sm text-gray-500">
                No results found for "{{ $searchQuery }}".
            </div>
        @endif
    @endif

</div>
