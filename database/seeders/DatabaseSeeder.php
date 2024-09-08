<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {
            $this->command->call('migrate:refresh');
            $this->command->warn("Data cleared, starting from blank database.");
        }

        // $this->command->call("shield:install");
        $this->command->call('shield:generate', ['--all' => 'policies_and_permissions,policies,permissions']);

        $this->call([
            // Filament-shield plugin seeder
            ShieldSeeder::class,
            // Default sekolah seeder
            SekolahSeeder::class,
            // Default user seeder
            UserSeeder::class,
        ]);


        $this->command->info('Default requirements added.');
    }
}
