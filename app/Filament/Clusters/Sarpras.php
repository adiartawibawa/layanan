<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Sarpras extends Cluster
{
    protected static ?string $navigationGroup = 'Manajemen Sekolah';

    protected static ?string $navigationParentItem = 'Sekolah';

    protected static ?int $navigationSort = 0;

    protected static ?string $slug = 'sekolah/sarpras';
}
