<?php

namespace App\Filament\Resources\MapHistoryResource\Pages;

use App\Filament\Resources\MapHistoryResource;
use App\Models\MapHistory;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;

class ManageMapHistories extends ManageRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = MapHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus-circle'),

            Action::make('generateMap')
                ->color('success')
                ->label('Generate Peta')
                ->icon('heroicon-o-globe-asia-australia')
                ->form([
                    Select::make('type')
                        ->label('Tipe Peta')
                        ->options([
                            'sekolah' => 'Sekolah',
                            'wilayah' => 'Wilayah',
                        ])->required()
                ])
                ->action(function (array $data): void {
                    // Panggil fungsi generateGeoJson di model MapHistory
                    MapHistory::generateGeoJson($data['type']);

                    // Berikan feedback atau notifikasi jika diperlukan

                })
                ->modalSubmitActionLabel('Generate Peta'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return static::$resource::getWidgets();
    }

    public function getTabs(): array
    {
        $tabs = [
            null => Tab::make('All'),
            'Sekolah' => Tab::make()->query(fn($query) => $query->whereType('sekolah')),
            'Wilayah' => Tab::make()->query(fn($query) => $query->whereType('wilayah')),
        ];

        return $tabs;
    }
}
