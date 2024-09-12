@push('styles')
    @filamentStyles
@endpush

<div>
    <div class="mx-auto max-w-[770px] text-center">
        <h2 class="mb-2.5 text-3xl font-bold text-white md:text-[38px] md:leading-[1.44]">
            <span>Berlangganan Informasi Terbaru</span>
        </h2>
        <p class="mx-auto mb-6 max-w-[615px] text-base leading-[1.5] text-white">
            Tetap terhubung dengan kami dan dapatkan informasi terbaru tentang program, kegiatan, dan
            berita penting dari Dinas Pendidikan. Berlanggananlah untuk menerima update langsung di
            kotak masuk Anda.
        </p>

        {{ $this->subscribe }}

        <x-filament-actions::modals />

    </div>

</div>

@push('scripts')
    @filamentScripts
@endpush
