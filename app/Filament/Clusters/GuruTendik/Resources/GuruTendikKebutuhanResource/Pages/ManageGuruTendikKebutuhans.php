<?php

namespace App\Filament\Clusters\GuruTendik\Resources\GuruTendikKebutuhanResource\Pages;

use App\Filament\Clusters\GuruTendik\Resources\GuruTendikKebutuhanResource;
use App\Filament\Clusters\GuruTendik\Resources\GuruTendikKebutuhanResource\Widgets\StatusKebutuhanOverview;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;

class ManageGuruTendikKebutuhans extends ManageRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = GuruTendikKebutuhanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatusKebutuhanOverview::class
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua'),
            'active' => Tab::make('Permohonan')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('active', true)),
            'inactive' => Tab::make('Terealisasi')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('active', false)),
        ];
    }
}
