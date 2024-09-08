<div class="flex flex-wrap items-center -mx-4">
    <x-slot name="page_title">
        {{ $layanan->nama }}
    </x-slot>

    <x-slot name="page_desc">
        {{ $layanan->desc }}
    </x-slot>

    <x-slot name="additional_item">
        <a href="{{ route('permohonan.create', $layanan->slug) }}"
            class="bg-white text-primary shadow-xl px-4 py-2 rounded-md">
            Ajukan Permohonan
        </a>
    </x-slot>

    <div class="mx-auto w-full max-w-2xl rounded-xl ring-1 ring-gray-200 lg:mx-0 lg:flex lg:max-w-none">
        <div class="p-8 sm:p-10 lg:flex-auto">
            <h3 class="text-2xl font-bold tracking-tight text-gray-900 mb-10">Panduan</h3>

            @foreach ($layanan->panduan as $panduan)
                @if ($loop->first)
                    <div class="flex flex-col-reverse w-full md:flex-row-reverse items-start justify-end gap-4">
                        <div
                            class="flex w-full md:w-1/2 items-start gap-4  bg-white px-6 pt-6 pb-10 rounded-lg shadow-xl">
                            <div class="rounded-full bg-red-500 px-4 py-2 text-white">{{ $loop->iteration }}</div>
                            <div class="text-slate-600">
                                <div class="text-2xl font-bold">{{ $panduan['judul'] }}</div>
                                <article class="prose text-sm text-slate-500">{!! $panduan['konten'] !!}</article>
                                @if ($panduan['file'] != null)
                                    <a href="{{ url('/') . '/storage/' . $panduan['file'] }}" target="_blank"
                                        class="inline-flex items-center mt-4 px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:ring-4 focus:outline-none focus:ring-gray-200 focus:text-red-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                                        <svg class="w-3.5 h-3.5 mr-2.5" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                        Panduan {{ $panduan['judul'] }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="w-full md:w-1/2">
                            <img class="h-64 w-full rounded-lg object-cover shadow-xl"
                                src="{{ url('/') . '/storage/' . $panduan['image_header'] }}"
                                alt="{{ $loop->iteration }}" />
                        </div>
                    </div>
                @else
                    @if ($loop->iteration % 2 == 0)
                        <!-- left to right -->
                        <div class="mx-auto my-4 h-32 max-w-[10rem] md:max-w-md">
                            <div class="flex h-full flex-row-reverse">
                                <div
                                    class="mt-[62px] h-16 w-1/2 rounded-tr-lg border-r-2 border-t-2 border-dashed border-gray-300">
                                </div>
                                <div
                                    class="h-16 w-1/2 rounded-bl-lg border-b-2 border-l-2 border-dashed border-gray-300">
                                </div>
                            </div>
                        </div>

                        <!-- direction flex row  -->
                        <div class="flex flex-col-reverse w-full md:flex-row items-start justify-end gap-4">
                            <div
                                class="flex w-full md:w-1/2 items-start gap-4  bg-white px-6 pt-6 pb-10 rounded-lg shadow-xl">
                                <div class="rounded-full bg-red-500 px-4 py-2 text-white">
                                    {{ $loop->iteration }}
                                </div>
                                <div class="text-slate-600">
                                    <div class="text-2xl font-bold">{{ $panduan['judul'] }}</div>
                                    <article class="prose text-sm text-slate-500">{!! $panduan['konten'] !!}</article>
                                    @if ($panduan['file'] != null)
                                        <a href="{{ url('/') . '/storage/' . $panduan['file'] }}" target="_blank"
                                            class="inline-flex items-center mt-4 px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:ring-4 focus:outline-none focus:ring-gray-200 focus:text-red-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                                            <svg class="w-3.5 h-3.5 mr-2.5" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                            </svg>
                                            Panduan {{ $panduan['judul'] }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full md:w-1/2">
                                <img class="h-64 w-full rounded-lg object-cover shadow-xl"
                                    src="{{ url('/') . '/storage/' . $panduan['image_header'] }}"
                                    alt="{{ $panduan['judul'] }}" />
                            </div>
                        </div>
                    @else
                        <!-- right to left -->
                        <div class="mx-auto my-4 h-32 max-w-[15rem] md:max-w-md">
                            <div class="grid h-full grid-cols-2">
                                <div
                                    class="mt-[62px] h-16 rounded-tl-lg border-l-2 border-t-2 border-dashed border-gray-300">
                                </div>
                                <div class="h-16 rounded-br-lg border-b-2 border-r-2 border-dashed border-gray-300">
                                </div>
                            </div>
                        </div>

                        <!-- direction flex row reverse  -->
                        <div class="flex flex-col-reverse w-full md:flex-row-reverse items-start justify-end gap-4">
                            <div
                                class="flex w-full md:w-1/2 items-start gap-4  bg-white px-6 pt-6 pb-10 rounded-lg shadow-xl">
                                <div class="rounded-full bg-red-500 px-4 py-2 text-white">
                                    {{ $loop->iteration }}
                                </div>
                                <div class="text-slate-600">
                                    <div class="text-2xl font-bold">{{ $panduan['judul'] }}</div>
                                    <article class="prose text-sm text-slate-500">{!! $panduan['konten'] !!}</article>
                                    @if ($panduan['file'] != null)
                                        <a href="{{ url('/') . '/storage/' . $panduan['file'] }}" target="_blank"
                                            class="inline-flex items-center mt-4 px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:ring-4 focus:outline-none focus:ring-gray-200 focus:text-red-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                                            <svg class="w-3.5 h-3.5 mr-2.5" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                            </svg>
                                            Panduan {{ $panduan['judul'] }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full md:w-1/2">
                                <img class="h-64 w-full rounded-lg object-cover shadow-xl"
                                    src="{{ url('/') . '/storage/' . $panduan['image_header'] }}"
                                    alt="{{ $panduan['judul'] }}" />
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach

        </div>
    </div>
</div>
