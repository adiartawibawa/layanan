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
        <ul class="flex flex-col w-full">
            @foreach ($datas as $item)
                <li class="flex flex-row mb-2 border-gray-400">
                    <div
                        class="transition duration-500 shadow ease-in-out transform hover:-translate-y-1 hover:shadow-lg select-none cursor-pointer bg-white dark:bg-gray-800 rounded-md flex flex-1 items-center justify-start p-4">
                        <div class="flex flex-col items-start justify-center h-24 w-auto mr-4">
                            <a href="#" class="relative block">
                                <img alt="profil"
                                    src="https://img.freepik.com/free-vector/female-team-illustration_23-2150201048.jpg?t=st=1720245920~exp=1720249520~hmac=a9c3e4d2f52e83fcdb37b0297d46302b1b26b5c0e8f1a6e59eef43458d4c112a&w=740"
                                    class="mx-auto object-cover rounded-md h-24 w-auto " />
                            </a>
                        </div>
                        <div class="flex-1 pl-1 md:mr-16">
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
                                        @case(\App\Models\LayananPermohonanHistory::GAGAL)
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
                                    <button wire:click="mountAction('delete', { permohonan: '{{ $item->id }}' })"
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
                        <div class="text-xs text-gray-600 dark:text-gray-200 w-1/3 hidden md:block">
                            <div class="font-semibold">Catatan:</div>
                            <div>
                                {{ $item->latestHistory->note }}
                            </div>
                        </div>
                        <button wire:click="openModal('{{ $item->id }}')" class="flex justify-end w-24 text-right">
                            <svg width="12" fill="currentColor" height="12"
                                class="text-gray-500 hover:text-gray-800 dark:hover:text-white dark:text-gray-200"
                                viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M1363 877l-742 742q-19 19-45 19t-45-19l-166-166q-19-19-19-45t19-45l531-531-531-531q-19-19-19-45t19-45l166-166q19-19 45-19t45 19l742 742q19 19 19 45t-19 45z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </li>
            @endforeach
        </ul>

        <!-- Include modal component -->
        @livewire('permohonan.history-permohonan', [
            'width' => '3xl',
            'icon' => 'heroicon-o-queue-list',
            'iconColor' => 'danger',
        ])
    </div>

    <x-filament-actions::modals />

</div>
