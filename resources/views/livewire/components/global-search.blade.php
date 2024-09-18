<div>
    <input type="text" wire:model.live.debounce.300ms="searchQuery"
        placeholder="Silahkan masukan apa yang ingin Anda cari?"
        class="h-12 w-full rounded-lg pl-11 pr-6 border-primary text-dark-5 duration-300 focus:border-primary focus:ring-0">
    <span class="absolute left-0 top-0 flex h-12 w-12 items-center justify-center text-body-color">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_1473_9422)">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M7.30131 1.32751C4.00207 1.32751 1.32751 4.00207 1.32751 7.30131C1.32751 10.6005 4.00207 13.2751 7.30131 13.2751C10.6005 13.2751 13.2751 10.6005 13.2751 7.30131C13.2751 4.00207 10.6005 1.32751 7.30131 1.32751ZM0 7.30131C0 3.26891 3.26891 0 7.30131 0C11.3337 0 14.6026 3.26891 14.6026 7.30131C14.6026 9.07839 13.9676 10.7075 12.9122 11.9735L15.8056 14.8669C16.0648 15.1261 16.0648 15.5464 15.8056 15.8056C15.5464 16.0648 15.1261 16.0648 14.8669 15.8056L11.9735 12.9122C10.7075 13.9676 9.07839 14.6026 7.30131 14.6026C3.26891 14.6026 0 11.3337 0 7.30131Z"
                    fill="currentColor"></path>
            </g>
            <defs>
                <clipPath id="clip0_1473_9422">
                    <rect width="16" height="16" fill="white"></rect>
                </clipPath>
            </defs>
        </svg>
    </span>

    <!-- Display search results. -->
    <div class="overflow-auto max-h-[35vh] sm:rounded-md shadow-md">
        <ul role="list" class="divide-y divide-gray-100 bg-white px-4">
            @if (!empty($results))
                @foreach ($results as $model => $records)
                    @if ($records->isNotEmpty())
                        @foreach ($records as $record)
                            @dd($record)
                            <li class="flex justify-between gap-x-6 py-5">
                                <div class="flex min-w-0 gap-x-4">
                                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                        src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                        alt="">
                                    <div class="min-w-0 flex-auto">
                                        <p class="text-sm font-semibold leading-6 text-gray-900">
                                            {{ $record->name ?? ($record->title ?? 'Unknown') }}</p>
                                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                                            on {{ class_basename($model) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                                    <p class="text-sm leading-6 text-gray-900">Co-Founder / CEO</p>
                                    <p class="mt-1 text-xs leading-5 text-gray-500">Last seen <time
                                            datetime="2023-01-23T13:23Z">3h
                                            ago</time></p>
                                </div>
                            </li>
                        @endforeach
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
    {{-- <ul>
        @if (!empty($results))
            @foreach ($results as $model => $records)
                <!-- Display model name dynamically as section title -->
                <li><strong>{{ class_basename($model) }}:</strong></li>
                @if ($records->isNotEmpty())
                    <!-- Loop through the records dynamically -->
                    @foreach ($records as $record)
                        <!-- Display record's first available attribute dynamically -->
                        <li>{{ $record->name ?? ($record->title ?? 'Unknown') }}</li>
                    @endforeach
                @else
                    <!-- Message if no records found for a particular model -->
                    <li>No results found for {{ class_basename($model) }}</li>
                @endif
            @endforeach
        @else
            <!-- Display a message when no results are found. -->
            <li>No results found</li>
        @endif
    </ul> --}}
</div>
