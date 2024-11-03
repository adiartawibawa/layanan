<?php

namespace App\Observers;

use App\Models\LayananPermohonan;
use App\Models\LayananPermohonanHistory;
use App\Services\PermohonanHistoryService;

class LayananPermohonanObserver
{
    protected $historyService;

    public function __construct(PermohonanHistoryService $historyService)
    {
        $this->historyService = $historyService;
    }

    public function created(LayananPermohonan $permohonan)
    {
        // Buat riwayat untuk status DIBUAT setiap kali permohonan baru dibuat
        $this->historyService->handleStatusDibuat($permohonan);
    }

    public function updated(LayananPermohonan $permohonan)
    {
        // Ambil riwayat status terakhir
        $latestHistory = $permohonan->latestHistory;
        $originalStatus = $latestHistory ? $latestHistory->status : null;

        // Tentukan status baru berdasarkan proses bisnis (misalnya dari input atau proses lainnya)
        $newStatus = $this->determineNewStatus($permohonan);

        // Cek jika status baru berbeda dengan status sebelumnya
        if ($newStatus && $newStatus !== $originalStatus) {
            switch ($newStatus) {
                case LayananPermohonanHistory::DIPROSES:
                    $this->historyService->handleStatusProses($permohonan);
                    break;
                case LayananPermohonanHistory::DIKEMBALIKAN:
                    $alasan = 'Dokumen tidak lengkap'; // Bisa diambil dari input admin
                    $this->historyService->handleStatusKembali($permohonan, $alasan);
                    break;
                case LayananPermohonanHistory::BERHASIL:
                    $this->historyService->handleStatusBerhasil($permohonan);
                    break;
                case LayananPermohonanHistory::DIBATALKAN:
                    $alasanPembatalan = 'Dibatalkan oleh pengguna'; // Bisa juga dari input
                    $this->historyService->handleStatusBatal($permohonan, $alasanPembatalan);
                    break;
            }
        }
    }

    /**
     * Method untuk menentukan status baru dari permohonan.
     * Ini hanya sebagai contoh dan bisa dimodifikasi sesuai dengan bisnis logika.
     *
     * @param LayananPermohonan $permohonan
     * @return string|null
     */
    protected function determineNewStatus(LayananPermohonan $permohonan): ?string
    {
        // Logika untuk menentukan status baru
        // Sebagai contoh, bisa diambil dari data tambahan atau input pengguna
        return $permohonan->new_status ?? null;
    }
}
