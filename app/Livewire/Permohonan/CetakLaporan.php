<?php

namespace App\Livewire\Permohonan;

use App\Models\LayananPermohonan;
use Livewire\Component;
// use PDF;

class CetakLaporan extends Component
{
    public $permohonanId;
    public ?LayananPermohonan $permohonan = null;

    public function mount($permohonanId)
    {
        $this->permohonanId = $permohonanId;
        $this->permohonan = LayananPermohonan::find($this->permohonanId);
    }

    public function printReport()
    {
        $data = [
            'permohonan' => $this->permohonan,
            'permohonanId' => $this->permohonanId,
        ];

        // $pdf = PDF::loadView('reports.permohonan-check-list', $data);
        // return $pdf->download('laporan_permohonan_' . $this->permohonanId . '.pdf');

        // $pdf = PDF::loadView('reports.permohonan-check-list', $data);
        // return response()->streamDownload(function () use ($pdf) {
        //     echo $pdf->stream();
        // }, 'laporan_permohonan_' . $this->permohonanId . '.pdf');
    }

    public function render()
    {
        return view('livewire.permohonan.cetak-laporan');
    }
}
