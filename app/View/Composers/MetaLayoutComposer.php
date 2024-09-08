<?php

namespace App\View\Composers;

use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MetaLayoutComposer
{
    protected $generalSettings;

    public function __construct(GeneralSettings $settings)
    {
        $this->generalSettings = $settings;
    }

    public function compose(View $view)
    {
        $meta = [
            'app_name' => $this->generalSettings->app_name,
            'app_desc' => $this->generalSettings->app_desc,
            'app_address_street' => $this->generalSettings->app_address_street,
            'app_address_city' => $this->generalSettings->app_address_city,
            'app_address_province' => $this->generalSettings->app_address_province,
            'app_phone' => $this->generalSettings->app_phone,
            'app_mail' => $this->generalSettings->app_mail,
            'app_favicon' => Storage::url($this->generalSettings->app_favicon),
            'app_logo' => Storage::url($this->generalSettings->app_logo),
        ];

        $view->with('meta', $meta);
    }
}
