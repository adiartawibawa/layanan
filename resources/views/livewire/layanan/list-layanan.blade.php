<div>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold text-slate-600">Daftar Layanan</h1>
        <p class="text-sm font-normal">Daftar layanan <span class="font-bold">{{ config('app.name') }}</span> yang
            tersedia untuk Anda</p>
    </x-slot>

    <x-slot name="breadcrumbs">
        <li>
            <a href="{{ route('dashboard') }}" class="block transition hover:text-gray-700">
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
            <a href="{{ route('layanan.index') }}"
                class="block transition text-indigo-600 dark:text-indigo-400 hover:underline">
                Layanan </a>
        </li>
    </x-slot>

    <div class="container flex flex-col items-center justify-center w-full mx-auto mt-4">
        <ul class="flex flex-col w-full">
            @foreach ($layanans as $item)
                <li class="flex flex-row mb-2 border-gray-400">
                    <a href="{{ route('layanan.view', $item->slug) }}" class="flex flex-row">
                        <div
                            class="transition duration-500 shadow ease-in-out transform hover:-translate-y-1 hover:shadow-lg select-none cursor-pointer bg-white dark:bg-gray-800 rounded-md flex flex-1 items-center p-4">
                            <div class="flex flex-col items-center justify-center w-1/2 h-auto md:w-1/3 md:h-32 mr-4">
                                <img alt="{{ $item->nama }}" src="{{ $item->ilustrasi_url }}"
                                    class="mx-auto object-cover rounded-md md:h-32 w-auto h-24 " />
                            </div>
                            <div class="flex md:flex-row flex-col gap-y-4 items-start md:items-center">
                                <div class="flex-1 pl-1 md:mr-16">
                                    <div class="font-medium dark:text-white">
                                        {{ $item->nama }}
                                    </div>
                                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-200">
                                        {{ $item->first_five_sentences }}
                                    </div>
                                    <div class="mt-3 text-xs font-semibold dark:text-gray-400">
                                        Estimasi proses : {{ $item->estimasi }} Hari Kerja
                                    </div>
                                </div>
                                <div class="text-xs text-gray-600 dark:text-gray-200 w-full md:w-1/6">
                                    <button type="button"
                                        wire:click.prevent="ajukanPermohonanLayanan('{{ $item->slug }}')"
                                        class="p-2 md:p-4 w-full bg-rose-600 hover:bg-rose-700 rounded-md text-white">
                                        Ajukan Permohonan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
