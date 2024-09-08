<?php

namespace App\Concerns;

use App\Models\Organization;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasOrganization
{
    /**
     * Boot the trait
     */
    protected static function bootHasOrganization(): void
    {
        if (auth()->user() && !(auth()->user()->hasRole(['super_admin', 'panel_admin']))) {

            static::addGlobalScope('organization', function (Builder $query) {
                if (auth()->check() && (auth()->user()->organization_id !== null)) {
                    $query->where('organization_id', auth()->user()->organization_id);
                    // or with a `user` relationship defined:
                    $query->whereBelongsTo(auth()->user()->organization);
                }
            });
        }

        static::creating(function (Model $model) {
            if (auth()->check() && !(auth()->user()->hasRole(['super_admin', 'panel_admin']))) {
                if (empty($model->organization_id)) {

                    $organizationId = auth()->user()?->organization_id;

                    if (is_null($organizationId)) {
                        throw new Exception($model);
                    }

                    // or with a `user` relationship defined:
                    $model->user()->associate($organizationId);
                }
            }
        });
    }

    /**
     * Relationship
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
