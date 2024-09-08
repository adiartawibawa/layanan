<div>
    @if ($permohonan)
        <x-filament::modal id="history-modal" :width="$width" :icon="$icon" :icon-color="$iconColor">
            <x-slot name="heading">
                Riwayat Permohonan #{{ $permohonan->layanan->nama }}
                <div class="text-xs mb-4">Dibuat pada : {{ $permohonan->created_at }}</div>
                <hr>
            </x-slot>

            <x-slot name="description">
                <div class="-my-6 text-sm">
                    @foreach ($permohonan->histories->reverse() as $history)
                        <div class="relative pl-8 sm:pl-32 py-6 group">
                            <div
                                class="font-caveat font-medium text-2xl mb-1 sm:mb-0
                                @switch($history->status)
                                    @case(\App\Models\LayananPermohonanHistory::DIBUAT)
                                        text-black
                                            @break
                                    @case(\App\Models\LayananPermohonanHistory::DIPROSES)
                                        text-sky-500
                                            @break
                                    @case(\App\Models\LayananPermohonanHistory::DIKEMBALIKAN)
                                        text-orange-500
                                            @break
                                    @case(\App\Models\LayananPermohonanHistory::BERHASIL)
                                        text-emerald-500
                                            @break
                                    @case(\App\Models\LayananPermohonanHistory::GAGAL)
                                        text-rose-500
                                            @break
                                    @default
                                        text-black
                                @endswitch
                                ">
                                {{ $history->status_label }}
                                <span class="font-mono text-sm">[{{ $permohonan->getAttribute('created_at') }}]</span>
                            </div>

                            <div
                                class="flex flex-col sm:flex-row items-start mb-1 group-last:before:hidden before:absolute before:left-2 sm:before:left-0 before:h-full before:px-px before:bg-slate-300 sm:before:ml-[6.5rem] before:self-start before:-translate-x-1/2 before:translate-y-3 after:absolute after:left-2 sm:after:left-0 after:w-2 after:h-2 after:bg-rose-600 after:border-4 after:box-content after:border-slate-50 after:rounded-full sm:after:ml-[6.5rem] after:-translate-x-1/2 after:translate-y-1.5">
                                <time
                                    class="sm:absolute left-0 translate-y-0.5 inline-flex items-center justify-center text-xs font-semibold uppercase w-20 h-6 mb-3 sm:mb-0 text-emerald-600 bg-emerald-100 rounded-full">
                                    {{ $history->created_at_month }}
                                </time>
                                <div class="text-base font-bold text-slate-900">
                                    {{ ucwords('Permohonan Layanan ' . $permohonan->layanan->nama . ' ' . $history->status_label) }}
                                </div>
                            </div>

                            <div class="text-slate-500">{{ $history->note }}</div>
                        </div>
                    @endforeach
                </div>
            </x-slot>

            <x-slot name="footerActions">
                <x-filament::button color="danger" wire:click="$dispatch('close-modal', { id: 'history-modal' })">
                    Close
                </x-filament::button>
            </x-slot>
        </x-filament::modal>
    @endif
</div>
