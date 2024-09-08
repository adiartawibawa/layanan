<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.app_name', 'Disdikpora Badung');
        $this->migrator->add('general.app_desc', 'Dinas Pendidikan Kepemudaan dan Olahraga Kabupaten Badung');
        $this->migrator->add('general.app_address_street', 'Jl. Raya Sempidi');
        $this->migrator->add('general.app_address_district', 'MENGWI');
        $this->migrator->add('general.app_address_city', 'KABUPATEN BADUNG');
        $this->migrator->add('general.app_address_province', 'BALI');
        $this->migrator->add('general.app_favicon', 'https://upload.wikimedia.org/wikipedia/commons/d/d2/Lambang_Kabupaten_Badung.png');
        $this->migrator->add('general.app_logo', 'https://upload.wikimedia.org/wikipedia/commons/d/d2/Lambang_Kabupaten_Badung.png');
        $this->migrator->add('general.app_phone', '0361-900926');
        $this->migrator->add('general.app_mail', 'badungdisdikpora@gmail.com');
        $this->migrator->add('general.app_timezone', 'Asia/Makassar');
        $this->migrator->add('general.app_locale', 'id');
        $this->migrator->add('general.app_active', true);
    }
};
