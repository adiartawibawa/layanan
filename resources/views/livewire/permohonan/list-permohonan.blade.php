<div>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold text-slate-600">Daftar Permohonan</h1>
        <p class="text-sm font-normal">Daftar ajuan permohonan Anda</p>
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
                Permohonan </a>
        </li>
    </x-slot>

    <div class="container flex flex-col items-center justify-center w-full mx-auto mt-4">
        <div class="flex flex-col w-full">
            @foreach ($datas as $item)
                <div class="flex flex-row mb-2 border-gray-400">
                    <div
                        class="w-full transition duration-500 shadow ease-in-out transform hover:-translate-y-1 hover:shadow-lg select-none cursor-pointer bg-white dark:bg-gray-800 rounded-md flex flex-1 items-center justify-start p-4">
                        <div class="w-auto flex flex-col items-start justify-center h-24 mr-4">
                            <a href="#" class="relative block">
                                <img alt="profil"
                                    src="https://img.freepik.com/free-vector/female-team-illustration_23-2150201048.jpg?t=st=1720245920~exp=1720249520~hmac=a9c3e4d2f52e83fcdb37b0297d46302b1b26b5c0e8f1a6e59eef43458d4c112a&w=740"
                                    class="mx-auto object-cover rounded-md h-24 w-auto " />
                            </a>
                        </div>
                        <div class="flex flex-row w-full justify-start items-center gap-8">
                            <div class="w-2/4 flex-1 pl-1">
                                <div class="font-medium dark:text-white">
                                    [
                                    <span
                                        class="
                                        @switch($item->latestHistory->status)
                                            @case(\App\Models\LayananPermohonanHistory::DIBUAT)
                                                text-black
                                                @break
                                            @case(\App\Models\LayananPermohonanHistory::DIPROSES)
                                                text-sky-700
                                                @break
                                            @case(\App\Models\LayananPermohonanHistory::DIKEMBALIKAN)
                                                text-orange-700
                                                @break
                                            @case(\App\Models\LayananPermohonanHistory::BERHASIL)
                                                text-emerald-700
                                                @break
                                            @case(\App\Models\LayananPermohonanHistory::DIBATALKAN)
                                                text-rose-700
                                                @break
                                            @default
                                                text-black
                                        @endswitch
                                                uppercase font-semibold">

                                        {{ $item->latestHistory->status_label }}
                                    </span>
                                    ]
                                    Permohonan {{ $item->layanan->nama }}
                                    @if ($item->latestHistory->status == \App\Models\LayananPermohonanHistory::DIBUAT)
                                        <button wire:click="mountAction('batal', { permohonan: '{{ $item->id }}' })"
                                            class="underline text-xs text-rose-700">batalkan</button>
                                    @endif
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-200 mt-2">
                                    Dibuat tanggal {{ $item->created_at }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-200">
                                    Diperbaharui tanggal {{ $item->latestHistory->updated_at }}
                                </div>
                                @if ($item->latestHistory->status == \App\Models\LayananPermohonanHistory::DIKEMBALIKAN)
                                    <div class="mt-2">
                                        <a href="{{ route('permohonan.edit', $item->id) }}"
                                            class="px-4 py-2 bg-rose-600 rounded-md text-white uppercase text-xs">
                                            Ajukan Ulang
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div class="w-1/4 text-xs text-gray-600 dark:text-gray-200 hidden md:block">
                                <div class="font-semibold">Catatan:</div>
                                <div>
                                    {{ $item->latestHistory->note }}
                                </div>
                            </div>
                            <div class="w-1/4 inline-flex items-center justify-start gap-4">
                                <button title="Riwayat Permohonan" wire:click="openModal('{{ $item->id }}')"
                                    class="flex justify-end w-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="text-gray-500 hover:text-red-800 dark:hover:text-white dark:text-gray-200">
                                        <path fill-rule="evenodd"
                                            d="M12 5.25c1.213 0 2.415.046 3.605.135a3.256 3.256 0 0 1 3.01 3.01c.044.583.077 1.17.1 1.759L17.03 8.47a.75.75 0 1 0-1.06 1.06l3 3a.75.75 0 0 0 1.06 0l3-3a.75.75 0 0 0-1.06-1.06l-1.752 1.751c-.023-.65-.06-1.296-.108-1.939a4.756 4.756 0 0 0-4.392-4.392 49.422 49.422 0 0 0-7.436 0A4.756 4.756 0 0 0 3.89 8.282c-.017.224-.033.447-.046.672a.75.75 0 1 0 1.497.092c.013-.217.028-.434.044-.651a3.256 3.256 0 0 1 3.01-3.01c1.19-.09 2.392-.135 3.605-.135Zm-6.97 6.22a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.752-1.751c.023.65.06 1.296.108 1.939a4.756 4.756 0 0 0 4.392 4.392 49.413 49.413 0 0 0 7.436 0 4.756 4.756 0 0 0 4.392-4.392c.017-.223.032-.447.046-.672a.75.75 0 0 0-1.497-.092c-.013.217-.028.434-.044.651a3.256 3.256 0 0 1-3.01 3.01 47.953 47.953 0 0 1-7.21 0 3.256 3.256 0 0 1-3.01-3.01 47.759 47.759 0 0 1-.1-1.759L6.97 15.53a.75.75 0 0 0 1.06-1.06l-3-3Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                @if ($item->latestHistory->status == \App\Models\LayananPermohonanHistory::BERHASIL)
                                    <livewire:permohonan.cetak-laporan :permohonanId="$item->id" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Include modal component -->
        @livewire('permohonan.history-permohonan', [
            'width' => '3xl',
            'icon' => 'heroicon-o-queue-list',
            'iconColor' => 'danger',
        ])
    </div>

    <x-filament-actions::modals />

</div>
