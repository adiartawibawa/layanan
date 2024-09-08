<?php

return [
    /*
    |--------------------------------------------------------------------------
    | General Settings
    |--------------------------------------------------------------------------
    */
    'general_settings' => [
        'nav' => [
            "group" => 'Settings',
            "icon" => 'heroicon-o-cog-6-tooth',
            "sort" => 1,
        ],
        'title' => 'General Settings',
        'heading' => 'General Settings',
        'subheading' => 'Manage general site settings here.',
        'navigationLabel' => 'General',
        'sections' => [
            "site" => [
                "title" => "Site",
                "description" => "Manage basic settings."
            ],
            "theme" => [
                "title" => "Theme",
                "description" => "Change default theme."
            ],
        ],
        "fields" => [
            "app_name" => "Application Name",
            "app_desc" => "Description of Application",
            "app_contact" => "Contact Phone",
            "app_mail" => "Contact Email",
            "app_timezone" => "Application Timezone",
            "app_locale" => "Application Locale",
            "site_active" => "Site Status",
            "app_logo" => "Application Logo",
            "site_favicon" => "Site Favicon",
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Mail Settings
    |--------------------------------------------------------------------------
    */
    'mail_settings' => [
        'nav' => [
            "group" => 'Settings',
            "icon" => 'heroicon-o-at-symbol',
            "sort" => 2,
        ],
        'title' => 'Mail Settings',
        'heading' => 'Mail Settings',
        'subheading' => 'Manage mail configuration.',
        'navigationLabel' => 'Mail',
        'sections' => [
            "config" => [
                "title" => "Configuration",
                "description" => "description"
            ],
            "sender" => [
                "title" => "From (Sender)",
                "description" => "description"
            ],
            "mail_to" => [
                "title" => "Mail to",
                "description" => "description"
            ],
        ],
        "fields" => [
            "placeholder" => [
                "receiver_email" => "Receiver email.."
            ],
            "driver" => "Driver",
            "host" => "Host",
            "port" => "Port",
            "encryption" => "Encryption",
            "timeout" => "Timeout",
            "username" => "Username",
            "password" => "Password",
            "email" => "Email",
            "name" => "Name",
            "mail_to" => "Mail to",
        ],
        "actions" => [
            "send_test_mail" => "Send Test Mail"
        ]
    ],

];
