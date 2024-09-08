<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('mail.from_address', config('mail.from.address'));
        $this->migrator->add('mail.from_name', config('mail.from.name'));
        $this->migrator->add('mail.driver', config('mail.mailers.smtp.transport'));
        $this->migrator->add('mail.host', config('mail.mailers.smtp.host'));
        $this->migrator->add('mail.port', config('mail.mailers.smtp.port'));
        $this->migrator->add('mail.encryption', 'tls');
        $this->migrator->addEncrypted('mail.username', config('mail.mailers.smtp.username'));
        $this->migrator->addEncrypted('mail.password', config('mail.mailers.smtp.password'));
        $this->migrator->add('mail.timeout', config('mail.mailers.smtp.timeout'));
        $this->migrator->add('mail.local_domain', config('mail.mailers.smtp.local_domain'));
    }
};
