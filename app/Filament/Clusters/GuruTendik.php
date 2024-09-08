<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class GuruTendik extends Cluster
{
    protected static ?string $navigationGroup = 'Manajemen Sekolah';

    protected static ?string $navigationParentItem = 'Sekolah';

    protected static ?string $navigationLabel = 'GTK';

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'sekolah/gtk';
}
