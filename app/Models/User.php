<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Concerns\HasOrganization;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Cviebrock\EloquentSluggable\Sluggable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia, FilamentUser, HasAvatar, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;
    use HasUuids;
    use SoftDeletes;
    use InteractsWithMedia;
    use HasRoles;
    use HasOrganization;
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'password',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Define the sluggable configuration for the model.
     * The 'username' slug is created from the 'name' attribute.
     */
    public function sluggable(): array
    {
        return [
            'username' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Get the Filament display name for the user.
     * If 'username' is set, return it, otherwise return 'name'.
     */
    public function getFilamentName(): string
    {
        return $this->username ?: $this->name;
    }

    /**
     * Accessor for the 'name' attribute.
     * Combines 'firstname' and 'lastname' into a single string.
     */
    public function getNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /**
     * Determine if the user can access the specified Filament panel.
     * Always returns true, granting access to all panels.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * Get the URL for the user's avatar.
     * Returns the URL of the first media item in the 'avatars' collection,
     * or a default avatar URL if no media is found.
     */
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->getMedia('avatars')?->first()?->getUrl() ?? $this->defaultAvatar();
    }

    /**
     * Check if the user has the 'super_admin' role.
     * Uses the role name defined in the configuration.
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole(config('filament-shield.super_admin.name'));
    }

    /**
     * Check if the user has the 'admin' role.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Accessor for the 'avatar_url' attribute.
     * Returns the URL of the last media item in the 'avatars' collection,
     * or a default avatar URL if no media is found.
     */
    public function getAvatarUrlAttribute(): ?string
    {
        return $this->getMedia('avatars')?->last()?->getUrl() ?? $this->defaultAvatar();
    }

    /**
     * Get the default avatar URL.
     * Uses Gravatar with the user's email.
     */
    private function defaultAvatar(): ?string
    {
        return 'https://gravatar.com/avatar/' . md5(strtolower(trim($this->email))) . '?d=mp';
    }

    public function permohonanLayanan(): HasMany
    {
        return $this->hasMany(LayananPermohonan::class, 'user_id', 'id');
    }
}
