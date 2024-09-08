<x-layouts.main>

    {{-- <div class="relative h-screen overflow-hidden bg-gray-100 dark:bg-gray-800 text-gray-800"> --}}
    <div class="relative h-full overflow-hidden bg-gray-100 dark:bg-gray-800 text-gray-800">
        <div x-data="{ openMenu: false }" :class="openMenu ? 'overflow-hidden' : 'overflow-visible'"
            class="flex items-start justify-between">

            <x-layouts.partials.sidenav />

            <div class="flex flex-col w-full pl-0 md:p-4 md:space-y-4">

                <x-layouts.partials.header />

                <main
                    class="flex flex-col h-screen justify-between pt-2 pb-12 md:pb-24 pl-2 pr-2 overflow-y-auto no-scrollbar md:pt-0 md:pr-0 md:pl-0 mb-auto">

                    <div class="flex flex-col flex-wrap sm:flex-row mb-auto">
                        <div class="flex md:flex-row flex-col-reverse w-full text-slate-500 items-start justify-between">
                            @if (isset($header))
                                <x-page-header>
                                    {{ $header }}
                                </x-page-header>
                            @endif
                            @if (isset($breadcrumbs))
                                <x-breadcrumbs>
                                    {{ $breadcrumbs }}
                                </x-breadcrumbs>
                            @endif
                        </div>
                        <div class="mb-4 mt-2 w-full">
                            {{ $slot }}
                        </div>
                    </div>
                    <footer class="h-10 mb-2 md:p-4 md:space-y-4 text-xs text-gray-400 inline-block bg-transparent">
                        <div class="flex flex-row items-center justify-between ">
                            <div>
                                ©️ {{ date('Y') }}. <a class="text-indigo-700"
                                    href="#">{{ config('app.name') }}</a>
                            </div>
                            <div>
                                made with ❤️ by <a href="https://wa.me/+6281916175060" target="_blank"
                                    rel="noopener noreferrer" class="text-indigo-700">Adi Arta Wibawa</a>
                            </div>
                        </div>

                    </footer>
                </main>


            </div>
        </div>
    </div>

    @livewire('notifications')

    {{-- @livewire('database-notifications') --}}

</x-layouts.main>
