<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class GeneralSettings extends Settings
{
    public string $app_name;
    public string $app_desc;
    public string $app_address_street;
    public string $app_address_district;
    public string $app_address_city;
    public string $app_address_province;
    public string $app_timezone;
    public string $app_locale;
    public string $app_phone;
    public string $app_mail;
    public bool $app_active;
    public string $app_favicon;
    public string $app_logo;

    public static function group(): string
    {
        return 'general';
    }
}
