<?php

namespace App\Listeners;

use App\Events\LayananPermohonanCreated;
use App\Models\LayananPermohonan;
use App\Models\LayananPermohonanHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateLayananPermohonanHistory
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LayananPermohonanCreated $event): void
    {
        $layananPermohonan = $event->layananPermohonan;

        // Simpan history pembuatan permohonan
        LayananPermohonanHistory::create([
            'status' => LayananPermohonanHistory::DIBUAT,
            'note' => 'Permohonan dibuat',
            'permohonan_type' => LayananPermohonan::class,
            'permohonan_id' => $layananPermohonan->id,
        ]);
    }
}
