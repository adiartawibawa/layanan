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
