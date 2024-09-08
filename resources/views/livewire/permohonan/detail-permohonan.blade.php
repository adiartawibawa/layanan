<div>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold text-slate-600">Rincian Permohonan Layanan</h1>
        <p class="text-sm font-normal">
            Semua yang perlu Anda ketahui tentang permohonan layanan Anda dalam satu tampilan.
        </p>
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
            <a href="{{ route('permohonan.index') }}"
                class="block transition text-indigo-600 dark:text-indigo-400 hover:underline">
                Permohonan </a>
        </li>
        <li class="rtl:rotate-180">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                    clip-rule="evenodd" />
            </svg>
        </li>
        <li>
            <a href="{{ route('permohonan.detail', $permohonan->id) }}"
                class="block transition text-indigo-600 dark:text-indigo-400 hover:underline">
                {{ $permohonan->layanan->nama }}
            </a>
        </li>

    </x-slot>

    <div class="container flex flex-col w-full mx-auto mt-4">
        <div class="flex flex-col w-full gap-4">
            <div class="flex flex-row bg-white rounded-md p-4">
                <form class="w-full">
                    {{ $this->viewPermohonanForm }}
                </form>
            </div>

            <div class="flex flex-row bg-white rounded-md p-4">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit in iure facere minima, amet voluptatem
                non corporis eligendi dolore, reiciendis dolores at laboriosam et totam tempore quas tenetur, quod nemo!
            </div>

            <div class="flex flex-row bg-white rounded-md p-4">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit in iure facere minima, amet voluptatem
                non corporis eligendi dolore, reiciendis dolores at laboriosam et totam tempore quas tenetur, quod nemo!
            </div>
        </div>
    </div>

    <x-filament-actions::modals />
</div>
