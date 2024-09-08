<div>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold text-slate-600">Semua Notifikasi</h1>
        <p class="text-sm font-normal">Mengelola dan melihat semua notifikasi Anda yang dikelompokkan berdasarkan waktu.
        </p>
    </x-slot>

    <x-slot name="breadcrumbs">
        <li>
            <a href="#" class="block transition hover:text-gray-700">
                <span class="sr-only"> Home </span>

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </a>
        </li>

        <li class="rtl:rotate-180">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                    clip-rule="evenodd" />
            </svg>
        </li>

        <li>
            <a href="#" class="block transition text-indigo-600 dark:text-indigo-400 hover:underline">
                Semua Notifikasi </a>
        </li>
    </x-slot>

    <div class="container flex flex-col items-center justify-center w-full mx-auto mt-4">
        <div class="flex flex-col w-full bg-white rounded-md p-4">
            <div class="py-2 flex-1">
                @foreach (['today' => 'Hari Ini', 'week' => 'Minggu Ini', 'month' => 'Bulan Ini', 'older' => 'Lebih Dari Sebulan'] as $key => $label)
                    @if (count($groupedNotifications[$key]) > 0)
                        <div class="flex justify-between items-center mt-4">
                            <h3 class="text-lg font-bold">{{ $label }}</h3>
                            <button wire:click="markGroupAsRead('{{ $key }}')"
                                class="text-rose-600 text-xs hover:underline">
                                Tandai Semua Telah Dibaca
                            </button>
                        </div>
                        @foreach ($groupedNotifications[$key] as $notification)
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
                                    . {{ $notification['created_at']->diffForHumans() }} .
                                    @if (is_null($notification['notification']['read_at']))
                                        <span
                                            wire:click.prevent="singleMarkAsRead('{{ $notification['notification']['id'] }}')"
                                            class="hover:underline text-rose-800">Tandai telah dibaca</span>
                                    @endif
                                </p>
                            </a>
                        @endforeach
                    @endif
                @endforeach

                <div wire:loading wire:target="loadNotifications">
                    Loading...
                </div>

                @if (count($this->notifications) < $this->totalNotifications)
                    <button wire:click="loadNotifications" wire:loading.attr="disabled"
                        class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">
                        Load More
                    </button>
                @endif
            </div>

        </div>
    </div>

    {{-- @script
        <script>
            document.addEventListener('scroll', () => {
                const container = document.getElementById('all-notification-container');
                if (container.getBoundingClientRect().bottom <= window.innerHeight) {
                    @this.call('loadNotifications');
                }
            });
        </script>
    @endscript --}}

</div>
