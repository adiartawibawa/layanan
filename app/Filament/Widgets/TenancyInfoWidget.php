<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class TenancyInfoWidget extends Widget
{
    public $data;

    protected static ?int $sort = -2;

    protected static bool $isLazy = false;

    protected static string $view = 'filament.widgets.tenancy-info-widget';

    public function mount(): void
    {
        $user = auth()->user();

        $this->data = [
            'organization' => $user->organization->name,
        ];
    }
}
