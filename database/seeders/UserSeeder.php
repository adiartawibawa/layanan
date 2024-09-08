<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default_organization = Organization::create([
            'name' => 'Unorganization'
        ]);

        $disdik_organization = Organization::create([
            'name' => 'Dinas Pendidikan Kepemudaan dan Olahraga Kabupaten Badung'
        ]);

        // creating users of the application
        $super_admin = User::create([
            'name' => 'Adi Arta Wibawa',
            'email' => 'surat.buat.adi@gmail.com',
            'organization_id' => $disdik_organization->id,
            'email_verified_at' => now(),
            'password' => Hash::make('fujiyama'),
            'remember_token' => Str::random(10),
        ]);

        $this->command->call('shield:super-admin', [
            '--user' => $super_admin->id
        ]);

        $admin_user = User::create([
            'name' => 'Admin Dinas',
            'email' => 'admindisdik@mail.test',
            'organization_id' => $disdik_organization->id,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
        $admin_user->assignRole('panel_user');

        $user = User::create([
            'name' => 'User',
            'email' => 'user@mail.test',
            'organization_id' => $default_organization->id,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
        $user->assignRole('user');

        $this->command->warn('Default users create successfully');
        $this->command->info('Here is your super user details to login:');
        $this->command->info('=========================================');
        $this->command->warn('Username is ' . $super_admin->email);
        $this->command->warn('Password is "loveofmylife"');
        $this->command->info('=========================================');
        $this->command->info('Here is your admindisdik user details to login:');
        $this->command->info('=========================================');
        $this->command->warn('Username is ' . $admin_user->email);
        $this->command->warn('Password is "password"');
        $this->command->info('=========================================');
        $this->command->info('Here is your regular user details to login:');
        $this->command->info('=========================================');
        $this->command->warn('Username is ' . $user->email);
        $this->command->warn('Password is "password"');
        $this->command->info('=========================================');
    }
}
