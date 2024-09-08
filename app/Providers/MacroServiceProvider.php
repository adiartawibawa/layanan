<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ForeignIdColumnDefinition;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blueprint::macro('assignOrganization', function () {
            $column = $this->foreignUuid('organization_id');

            return tap(
                $column,
                fn (ForeignIdColumnDefinition $column) =>
                $column
                    ->nullable()
                    ->constrained()
                    ->cascadeOnDelete()
            );
        });

        Blueprint::macro('dropOrganization', function () {
            $this->dropForeign(['organization_id']);
            $this->dropColumn('organization_id');

            return $this;
        });
    }
}
