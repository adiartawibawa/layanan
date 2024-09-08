<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Pengaturan Umum
    |--------------------------------------------------------------------------
    */
    'general_settings' => [
        'nav' => [
            "group" => 'Pengaturan',
            "icon" => 'heroicon-o-cog-6-tooth',
            "sort" => 1,
        ],
        'title' => 'Pengaturan Umum',
        'heading' => 'Pengaturan Umum',
        'subheading' => 'Kelola pengaturan situs umum di sini.',
        'navigationLabel' => 'Umum',
        'sections' => [
            "site" => [
                "title" => "Situs",
                "description" => "Kelola pengaturan dasar."
            ],
            "theme" => [
                "title" => "Tema",
                "description" => "Ubah tema default."
            ],
        ],
        "fields" => [
            "app_name" => "Nama Aplikasi",
            "app_desc" => "Deskripsi Aplikasi",
            "app_contact" => "Kontak Telepon",
            "app_mail" => "Kontak Email",
            "app_timezone" => "Zona Waktu",
            "app_locale" => "Lokal Aplikasi",
            "site_active" => "Status Situs",
            "app_logo" => "Logo Aplikasi",
            "site_favicon" => "Favicon Situs",
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Pengaturan Surat
    |--------------------------------------------------------------------------
    */
    'mail_settings' => [
        'nav' => [
            "group" => 'Pengaturan',
            "icon" => 'heroicon-o-at-symbol',
        ],
        'title' => 'Pengaturan Surat',
        'heading' => 'Pengaturan Surat',
        'subheading' => 'Kelola konfigurasi surat.',
        'navigationLabel' => 'Surat',
        'sections' => [
            "config" => [
                "title" => "Konfigurasi",
                "description" => "deskripsi"
            ],
            "sender" => [
                "title" => "Dari (Pengirim)",
                "description" => "deskripsi"
            ],
            "mail_to" => [
                "title" => "Kirim ke",
                "description" => "deskripsi"
            ],
        ],
        "fields" => [
            "placeholder" => [
                "receiver_email" => "Email penerima.."
            ],
            "driver" => "Driver",
            "host" => "Host",
            "port" => "Port",
            "encryption" => "Enkripsi",
            "timeout" => "Waktu Habis",
            "username" => "Nama Pengguna",
            "password" => "Kata Sandi",
            "email" => "Email",
            "name" => "Nama",
            "mail_to" => "Kirim ke",
        ],
        "actions" => [
            "send_test_mail" => "Kirim Surat Uji"
        ]
    ],

];
