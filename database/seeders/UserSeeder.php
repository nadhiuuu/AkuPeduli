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
                'email' => 'gamingputra384@gmail.com',
                'password' => Hash::make('#Putr4int4n'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Budi Donatur',
                'email' => 'dwirasyariputra07@gmail.com',
                'password' => Hash::make('#Putr4int4n'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
            ['name' => 'Admin peduli 2',
                'email' => 'putgaming170705@gmail.com',
                'password' => Hash::make('#Putr4int4n'),
                'role' => 'admin',
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
