<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat admin
        User::create([
            'name' => 'Admin',
            'email' => 'admins@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Buat user biasa
        User::create([
            'name' => 'User Biasa',
            'email' => 'users@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
