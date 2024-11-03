<?php

namespace App\Services;

use App\Models\LayananPermohonan;
use App\Models\LayananPermohonanHistory;

class PermohonanHistoryService
{
    public function logStatusChange(LayananPermohonan $permohonan, string $newStatus, string $note = '')
    {
        // Mencatat riwayat status dengan menggunakan relasi histories
        $permohonan->histories()->create([
            'status' => $newStatus,
            'note' => $note,
        ]);
    }

    public function handleStatusDibuat(LayananPermohonan $permohonan)
    {
        $this->logStatusChange($permohonan, LayananPermohonanHistory::DIBUAT, 'Permohonan telah diajukan.');
    }

    public function handleStatusProses(LayananPermohonan $permohonan)
    {
        $this->logStatusChange($permohonan, LayananPermohonanHistory::DIPROSES, 'Permohonan sedang diproses oleh admin.');
    }

    public function handleStatusKembali(LayananPermohonan $permohonan, string $alasan)
    {
        $this->logStatusChange($permohonan, LayananPermohonanHistory::DIKEMBALIKAN, "Permohonan dikembalikan: $alasan");
    }

    public function handleStatusBerhasil(LayananPermohonan $permohonan)
    {
        $this->logStatusChange($permohonan, LayananPermohonanHistory::BERHASIL, 'Permohonan telah berhasil diproses.');
    }

    public function handleStatusBatal(LayananPermohonan $permohonan, string $alasan = 'Permohonan dibatalkan oleh pengguna')
    {
        $this->logStatusChange($permohonan, LayananPermohonanHistory::DIBATALKAN, $alasan);
    }
}
