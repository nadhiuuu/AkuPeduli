<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's users.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin AkuPeduli',
                'email' => 'saipulamin32467@gmail.com',
                'password' => Hash::make('Password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Budi Donatur',
                'email' => 'ipulpoel54321@gmail.com',
                'password' => Hash::make('Password1234'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user,
            );
        }
    }
}
