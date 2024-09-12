<div>
    <h5 class="mb-[18px] text-lg font-semibold text-dark dark:text-white">
        Guru & Tenaga Kependidikan Kami
    </h5>
    <div class="text-sm text-body-color dark:text-dark-6 w-full">
        <div class="flex flex-col items-start justify-center gap-2 w-full">
            <div class="bg-primary shadow-md rounded-md w-auto text-white p-2">
                <div class="inline-flex space-x-2 justify-center items-center">
                    <h4>Total Guru dan Tendik : </h4>
                    <p>{{ $totalGuruTendik }}</p>
                </div>
            </div>
            <div class="bg-primary shadow-md rounded-md w-auto text-white p-2">
                <div class="inline-flex space-x-2 justify-center items-center">
                    <h4>Total Kepala Sekolah : </h4>
                    <p>{{ $totalKepsek }}</p>
                </div>
            </div>
            <div class="bg-primary shadow-md rounded-md w-auto text-white p-2">
                <div class="inline-flex space-x-2 justify-center items-center">
                    <ul>
                        @foreach ($statusKepegawaianStatistics as $status => $count)
                            <li>
                                <span>{{ $status }} : </span> {{ $count }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        {{-- <div class="mt-2">
            <div class="text-gray-500 text-xs">* data per Tahun 2022</div>
        </div> --}}
    </div>

</div>
