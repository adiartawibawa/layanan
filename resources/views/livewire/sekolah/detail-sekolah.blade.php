<div class="flex flex-wrap items-center -mx-4">
    <x-slot name="page_title">
        {{ $sekolah->nama }}
    </x-slot>

    <x-slot name="page_desc">
        Alamat: {{ $sekolah->alamat_lengkap }}
    </x-slot>

    <div class="w-full flex flex-col md:flex-row gap-4">
        <div class="shadow-md w-full md:w-1/3 h-max rounded-lg">
            {{-- Map goes here --}}
            <livewire:maps.base-map height="350px" width="100%">
                <livewire:maps.point readOnly="true" latitude="{{ $sekolah->meta['lat'] }}"
                    longitude="{{ $sekolah->meta['lon'] }}" layerId="pointsLayer"
                    iconUrl="{{ asset('icon/school-' . strtolower($sekolah->bentuk->code) . '.png') }}" />
            </livewire:maps.base-map>
        </div>
        <div class="w-full p-4 mb-6 rounded-lg shadow-md bg-white dark:text-white dark:bg-dark md:w-2/3">
            {{-- Detail Information goes here --}}
            <!-- Starts component -->
            <div x-data="{ activeTab: 2 }" class="mx-auto w-full mt-6">
                <!-- Tab List -->
                <ul role="tablist" class="-mb-px flex items-stretch gap-2 text-slate-500">
                    <!-- Tab 1 -->
                    <li>
                        <button @click="activeTab = 0" :aria-selected="activeTab === 0"
                            :class="{ 'bg-red-50 dark:bg-dark-2 dark:text-white text-primary': activeTab === 0 }"
                            class="flex gap-1 items-center rounded-full px-4 h-10 py-1 text-sm font-medium bg-red-50 dark:bg-dark-2 dark:text-white text-primary"
                            role="tab" aria-selected="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                            </svg>
                            <span>Umum</span>
                        </button>
                    </li> <!-- Tab 2 -->
                    <li>
                        <button @click="activeTab = 1" :aria-selected="activeTab === 1"
                            :class="{ 'bg-red-50 dark:bg-dark-2 dark:text-white text-primary': activeTab === 1 }"
                            class="flex gap-1 items-center rounded-full px-4 h-10 py-1 text-sm font-medium"
                            role="tab" aria-selected="false">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                            </svg>
                            <span>GTK</span>
                        </button>
                    </li>
                    <li>
                        <button @click="activeTab = 2" :aria-selected="activeTab === 2"
                            :class="{ 'bg-red-50 dark:bg-dark-2 dark:text-white text-primary': activeTab === 2 }"
                            class="flex gap-1 items-center rounded-full px-4 h-10 py-1 text-sm font-medium"
                            role="tab" aria-selected="false">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                            </svg>
                            <span>Sarpras</span>
                        </button>
                    </li>
                </ul> <!-- Panels -->
                <div role="tabpanels"
                    class="border rounded-xl overflow-hidden border-stroke dark:border-dark-4 mt-4 bg-white dark:bg-dark">
                    <!-- Panel 1 -->
                    <section x-show="activeTab === 0" role="tabpanel" class="p-8">
                        <ul role="list" class="divide-y divide-gray-100">
                            <li class="relative flex flex-col min-w-0 gap-2">
                                <div>NPSN: {{ $sekolah->npsn }}</div>
                                <div>Kepala Sekolah:</div>
                                <div>Status: {{ $sekolah->status }}</div>
                                <div>Bentuk Pendidikan: {{ $sekolah->bentuk->name }}</div>
                                <div>Status Kepemilikan: {{ $sekolah->npsn }}</div>
                                <div>SK Pendirian Sekolah: {{ $sekolah->npsn }}</div>
                                <div>Tanggal SK Pendirian: {{ $sekolah->npsn }}</div>
                                <div>SK Izin Operasional: {{ $sekolah->npsn }}</div>
                                <div>Tanggal SK Izin Operasional: {{ $sekolah->npsn }}</div>
                            </li>
                        </ul>
                    </section> <!-- Panel 2 -->
                    <section x-show="activeTab === 1" role="tabpanel" class="p-8" style="display: none;">
                        <ul role="list" class="divide-y divide-gray-100">
                            <li class="relative flex flex-col min-w-0 gap-2">
                                <div>
                                    @foreach ($sekolah->pegawais as $pegawai)
                                        {{ $pegawai }}
                                    @endforeach
                                </div>
                            </li>
                        </ul>
                    </section>
                    <section x-show="activeTab === 2" role="tabpanel" class="p-8" style="display: none;">
                        <ul role="list" class="divide-y divide-gray-100">
                            <li class="relative flex flex-col min-w-0 gap-2">
                                <div>
                                    <div class="mb-4">
                                        <h3 class="bg-primary w-full uppercase text-white p-1 mb-2">Tanah</h3>
                                        <livewire:components.data-table :per-page="$perPage" :columns="$tanahColumns"
                                            :data="$tanahData" />
                                    </div>
                                    <div class="mb-4">
                                        <h3 class="bg-primary w-full uppercase text-white p-1 mb-2">Bangunan dimiliki
                                        </h3>
                                        <livewire:components.data-table :per-page="$perPage" :columns="$bangunanColumns"
                                            :data="$bangunanData" />
                                    </div>
                                    <div class="mb-4">
                                        <h3 class="bg-primary w-full uppercase text-white p-1 mb-2">Ruang dimiliki</h3>
                                        <livewire:components.data-table :per-page="$perPage" :columns="$ruangColumns"
                                            :data="$ruangData" />
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </section>
                </div>
            </div> <!-- Ends component -->
        </div>
    </div>

</div>
