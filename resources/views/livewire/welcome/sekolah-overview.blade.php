<div>
    <h5 class="mb-[18px] text-lg font-semibold text-dark dark:text-white">
        Sekolah Kami
    </h5>
    <div class="text-sm text-body-color dark:text-dark-6 w-full">
        <div class="flex flex-col items-start justify-start gap-2 text-white">
            <div class="bg-primary shadow-md rounded-md p-4">
                <div class="flex flex-row gap-2">
                    <div>
                        Total :
                    </div>
                    <div>
                        {{ $totalSekolah }} Sekolah
                    </div>
                </div>
            </div>
            <div class="bg-primary shadow-md rounded-md p-4">
                <div class="flex flex-row gap-2">
                    <div>

                    </div>
                    <div>
                        <ul>
                            @foreach ($sekolahBentukStatistics as $bentuk)
                                <li>
                                    <span>{{ $bentuk->name }} : </span> {{ $bentuk->sekolah_count }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
