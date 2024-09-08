<div x-data="{ isOpen: true }" class="relative mr-2">
    <!-- Dropdown toggle button -->
    <button @click="isOpen = !isOpen"
        class="relative z-50 block p-3 text-gray-700 bg-white rounded-xl border border-transparent dark:text-white hover:bg-slate-100">
        <svg class="w-5 h-5 text-gray-800 dark:text-white" viewBox="0 0 24 24" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M12 22C10.8954 22 10 21.1046 10 20H14C14 21.1046 13.1046 22 12 22ZM20 19H4V17L6 16V10.5C6 7.038 7.421 4.793 10 4.18V2H13C12.3479 2.86394 11.9967 3.91762 12 5C12 5.25138 12.0187 5.50241 12.056 5.751H12C10.7799 5.67197 9.60301 6.21765 8.875 7.2C8.25255 8.18456 7.94714 9.33638 8 10.5V17H16V10.5C16 10.289 15.993 10.086 15.979 9.9C16.6405 10.0366 17.3226 10.039 17.985 9.907C17.996 10.118 18 10.319 18 10.507V16L20 17V19ZM17 8C16.3958 8.00073 15.8055 7.81839 15.307 7.477C14.1288 6.67158 13.6811 5.14761 14.2365 3.8329C14.7919 2.5182 16.1966 1.77678 17.5954 2.06004C18.9942 2.34329 19.9998 3.5728 20 5C20 6.65685 18.6569 8 17 8Z"
                fill="currentColor"></path>
        </svg>
        <span class="absolute inset-0 object-right-top -mr-6">
            <div
                class="inline-flex items-center px-2 py-0.5 border-2 border-white rounded-full text-xs font-semibold leading-4 bg-red-500 text-white">
                {{ $notificationsCount }}
            </div>
        </span>
    </button>

    <!-- Dropdown menu -->
    <div x-cloak x-show="!isOpen" @click.away="isOpen = true" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="absolute right-0 z-20 w-64 pt-2 mt-4 overflow-hidden origin-top-right bg-white rounded-md shadow-lg sm:w-80 dark:bg-gray-800">
        <div class="py-2 flex-1">
            @if ($notificationsCount === 0)
                <p class="mx-auto text-sm text-gray-600 dark:text-white">Tidak ada notifikasi baru.</p>
            @else
                @foreach ($notificationDetails as $notification)
                    <a href="{{ route('permohonan.detail', $notification['id']) }}"
                        class="flex items-center px-4 py-3 -mx-2 transition-colors duration-300 transform border-b border-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-700">
                        <img class="flex-shrink-0 object-cover w-8 h-8 mx-1 rounded-full"
                            src="{{ $notification['ilustrasi_url'] }}" alt="avatar" />
                        <p class="mx-2 text-sm text-gray-600 dark:text-white">
                            <span class="text-rose-500 hover:underline"
                                href="{{ route('permohonan.detail', $notification['id']) }}">Permohonan
                                layanan {{ $notification['nama'] }}</span>
                            @switch($notification['status'])
                                @case(\App\Models\LayananPermohonanHistory::DIBUAT)
                                    telah dibuat
                                @break

                                @case(\App\Models\LayananPermohonanHistory::DIPROSES)
                                    sedang diproses
                                @break

                                @case(\App\Models\LayananPermohonanHistory::DIKEMBALIKAN)
                                    telah dikembalikan
                                @break

                                @case(\App\Models\LayananPermohonanHistory::BERHASIL)
                                    telah berhasil
                                @break

                                @case(\App\Models\LayananPermohonanHistory::GAGAL)
                                    gagal
                                @break

                                @default
                                    Status tidak diketahui
                            @endswitch
                            {{-- @dd($notification) --}}
                            . {{ $notification['created_at']->diffForHumans() }} .
                            @if (array_key_exists('read_at', $notification) && is_null($notification['read_at']))
                                <span wire:click.prevent="markAsRead('{{ $notification['id'] }}')"
                                    class="hover:underline text-rose-800">Tandai telah dibaca</span>
                            @endif
                        </p>
                    </a>
                @endforeach
            @endif

            <div wire:loading wire:target="loadNotifications">
                Loading...
            </div>

            @if ($notificationsCount > count($notifications))
                <button wire:click="loadNotifications" wire:loading.attr="disabled"
                    class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">
                    Load More
                </button>
            @endif
        </div>
        <a href="{{ route('all.notifications') }}"
            class="block py-2 font-bold text-center text-white bg-gray-800 dark:bg-gray-700 hover:underline">See
            all notifications</a>
    </div>

    @script
        <script>
            document.addEventListener('scroll', () => {
                const container = document.getElementById('notification-container');
                if (container.getBoundingClientRect().bottom <= window.innerHeight) {
                    @this.call('loadNotifications');
                }
            });
        </script>
    @endscript
</div>
