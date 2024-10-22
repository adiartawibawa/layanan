<div>
    @if (!empty($legendData))
        {{-- @dd($legendData) --}}
        <div class="legend-container pt-4">
            @foreach ($legendData as $layerName => $items)
                <div class="layer-group mb-4 p-4 border border-gray-300 rounded relative">
                    <!-- Floating Title -->
                    <span class="absolute top-[-10px] left-[10px] bg-gray-1 dark:bg-dark px-2 text-sm font-semibold">
                        {{ $layerName }} <!-- Nama Layer -->
                    </span>

                    @foreach ($items as $item)
                        <div class="inline-flex items-center mb-2">
                            <!-- Legend Icon (mengambil dari styles icon) -->
                            @if (isset($item['styles']['icon']))
                                <!-- Jika ada icon, gunakan gambar -->
                                <img src="{{ $item['styles']['icon'] }}" alt="Icon" class="w-5 h-5 me-2">
                            @else
                                <!-- Jika tidak ada icon, gunakan kotak berwarna sesuai dengan styles -->
                                <span class="size-2 inline-block me-2"
                                    style="width: 20px; height: 20px; background-color: {{ $item['styles']['fill'] }}; border: 1px solid {{ $item['styles']['stroke'] }};"></span>
                            @endif

                            <!-- Legend Text (groupedBy dan returnedField) -->
                            <span class="text-gray-600 dark:text-neutral-400">
                                {{ $item['groupedBy'] }} ({{ $item['returnedField'] }})
                            </span>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @else
        <p>No legend data available.</p>
    @endif
</div>

@push('styles')
    <style>
        .legend-list {
            list-style-type: none;
            padding: 0;
        }

        .legend-item {
            display: flex;
            align-items: center;
        }

        .legend-icon {
            margin-right: 10px;
        }

        .legend-label {
            font-weight: bold;
        }
    </style>
@endpush
