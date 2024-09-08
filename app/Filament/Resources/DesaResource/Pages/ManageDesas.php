<?php

namespace App\Filament\Resources\DesaResource\Pages;

use App\Filament\Imports\DesaImporter;
use App\Filament\Resources\DesaResource;
use App\Models\Desa;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ManageDesas extends ManageRecords
{
    protected static string $resource = DesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus-circle'),

            Actions\ImportAction::make()
                ->label('Import Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->importer(DesaImporter::class),

            Action::make('importMaps')
                ->color('warning')
                ->label('Import Geometry Desa')
                ->icon('heroicon-o-map')
                ->form([
                    FileUpload::make('geojson')
                        ->label('File geometry desa.geojson')
                        ->storeFiles(),
                ])
                ->action(function (array $data) {
                    $fileJson = $data['geojson'];

                    $result = $this->importingGeoJson($fileJson);

                    // Hapus file setelah import selesai
                    Storage::delete('public/' . $fileJson);

                    $recipient = auth()->user();

                    if ($result['success']) {
                        Notification::make()
                            ->title('Import data Geometry berhasil.')
                            ->success()
                            ->sendToDatabase($recipient);
                    } else {
                        Notification::make()
                            ->title('Import data Geometry gagal. Kesalahan: ' . $result['error'])
                            ->danger()
                            ->sendToDatabase($recipient);
                    }
                }),
        ];
    }

    public function importingGeoJson($fileName)
    {
        $result = ['success' => false, 'error' => ''];

        try {
            $data = json_decode(Storage::get('public/' . $fileName));

            $features = $data->features;

            foreach ($features as $feature) {
                $code = $feature->properties->FID_BIDANG;
                $geometry = $feature->geometry;

                $desa = Desa::where('code', $code)->first();

                if ($desa) {
                    $meta = json_decode($desa->meta, true);
                    $meta['geometry'] = $geometry;
                    $desa->meta = json_encode($meta);
                    $desa->save();
                }
            }

            $result['success'] = true;
        } catch (\Exception $e) {
            Log::error("Error: " . $e->getMessage());
            $result['error'] = $e->getMessage();
        }

        return $result;
    }
}
