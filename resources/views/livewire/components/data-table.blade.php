<div>
    <!-- Dropdown untuk memilih jumlah data per halaman -->
    {{-- <div class="mb-4">
        <label for="perPage" class="block text-sm font-medium text-gray-700">Items per page</label>
        <select wire:model="perPage" id="perPage"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
        </select>
    </div> --}}

    <!-- Tabel dan paginasi -->
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-white border-b">
                <tr>
                    @foreach ($columns as $column)
                        <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            {{ $column }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($paginatedData as $row)
                    <tr class="{{ $loop->odd ? 'bg-gray-100' : 'bg-white' }} border-b">
                        @foreach ($row as $cell)
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                {{ $cell }}
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) }}" class="text-center text-gray-500 py-4">
                            No records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="mt-4">
            {{ $paginatedData->links() }}
        </div>
    </div>
</div>
