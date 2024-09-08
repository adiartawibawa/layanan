<?php

namespace App\Filament\Imports;

use App\Models\GuruTendik;
use App\Models\GuruTendikKepegawaian;
use App\Models\GuruTendikTugas;
use App\Models\Sekolah;
use App\Models\User;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Facades\Hash;

class GuruTendikImporter extends Importer
{
    protected static ?string $model = GuruTendik::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nik')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nuptk')
                ->rules(['max:255']),
            ImportColumn::make('nip')
                ->rules(['max:255']),
            ImportColumn::make('gender')
                ->requiredMapping()
                ->rules(['required', 'max:1']),
            ImportColumn::make('tempat_lahir')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('tanggal_lahir')
                ->requiredMapping()
                ->rules(['required', 'date']),
        ];
    }

    public function resolveRecord(): ?GuruTendik
    {
        // Generate email and get school ID
        $email = $this->generateEmail($this->data['nama']);
        $sekolah = $this->getTempatTugas($this->data['NPSN']);

        // Use upsert to create or update the user
        $user = User::updateOrCreate(
            [
                'username' => $this->data['nik'],
            ],
            [
                'name' => $this->data['nama'],
                'email' => $email,
                'password' => Hash::make('password'),
            ]
        );

        // Use upsert to create or update the GuruTendik record
        $guruTendik = GuruTendik::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'nama' => $this->data['nama'],
                'nik' => $this->data['nik'],
                'nuptk' => $this->data['nuptk'],
                'nip' => $this->data['nip'],
                'gender' => $this->data['gender'],
                'tempat_lahir' => $this->data['tempat_lahir'],
                'tanggal_lahir' => $this->data['tanggal_lahir'],
                'no_telp' => $this->data['Nomor_HP'],
            ]
        );

        // Use upsert to create or update the GuruTendikTugas record
        GuruTendikTugas::updateOrCreate(
            [
                'guru_tendik_id' => $guruTendik->id,
                'organization_id' => $sekolah,
            ],
            [
                'status_tugas' => $this->data['Status_Tugas'],
                'mapel_ajar' => $this->data['Mata_Pelajaran_Diajarkan'],
                'jam_mengajar' => $this->data['Jam_Mengajar_Perminggu'],
                'tahun' => $this->data['Tahun'],
                'semester' => $this->data['Semester'],
            ]
        );

        // Use upsert to create or update the GuruTendikKepegawaian record
        GuruTendikKepegawaian::updateOrCreate(
            [
                'guru_tendik_id' => $guruTendik->id,
            ],
            [
                'sk_cpns' => $this->data['SK_CPNS'],
                'tmt_cpns' => $this->data['Tanggal_CPNS'],
                'sk_pengangkatan' => $this->data['SK_Pengangkatan'],
                'tmt_pengangkatan' => $this->data['TMT_Pengangkatan'],
                'jenis_ptk' => $this->data['Jenis_PTK'],
                'pendidikan_terakhir' => $this->data['Pendidikan'],
                'bidang_studi_pendidikan' => $this->data['Bidang_Studi_Pendidikan'],
                'bidang_studi_sertifikasi' => $this->data['Bidang_Studi_Sertifikasi'],
                'status_kepegawaian' => $this->data['Status_Kepegawaian'],
                'pangkat_gol_terakhir' => $this->data['Pangkat_Gol'],
                'tmt_pangkat_terakhir' => $this->data['TMT_Pangkat'],
                'masa_kerja_tahun' => $this->data['Masa_Kerja_Tahun'],
                'masa_kerja_bulan' => $this->data['Masa_Kerja_Bulan'],
                'is_kepsek' => $this->data['Jabatan_Kepsek'] === 'Ya',
            ]
        );

        // Update the user and GuruTendik organization_id if status_tugas is Induk
        if ($this->data['Status_Tugas'] === 'Induk') {
            $user->organization_id = $sekolah;
            $user->save();

            $guruTendik->organization_id = $sekolah;
            $guruTendik->save();
        }

        return $guruTendik;
    }

    private function generateEmail($name)
    {
        $words = explode(' ', $name);
        $initials = '';

        foreach ($words as $word) {
            $initials .= strtolower(substr($word, 0, 1));
        }

        $username = strtolower(substr(str_replace(' ', '', $name), 0, 10));
        $randomPart = rand(100, 9999);

        return "{$username}{$initials}{$randomPart}@mail.test";
    }

    private function getTempatTugas($npsn)
    {
        return Sekolah::whereNpsn($npsn)->value('organization_id');
    }


    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your guru tendik import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
