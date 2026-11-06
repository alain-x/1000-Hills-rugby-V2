<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@1000hillsrugby.rw')],
            [
                'name' => env('ADMIN_NAME', 'Club Administrator'),
                'username' => 'admin',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'Admin@1000hills')),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'editor@1000hillsrugby.rw'],
            [
                'name' => 'Club Editor',
                'username' => 'editor',
                'password' => Hash::make('Editor@1000hills'),
                'role' => 'editor',
                'is_active' => true,
            ]
        );
    }
}
