<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user (for RBAC demo)
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('Admin@123'),
            'role' => 'admin',
        ]);

        // Normal user (optional)
        User::create([
            'name' => 'Normal User',
            'email' => 'user@test.com',
            'password' => Hash::make('User@123'),
            'role' => 'user',
        ]);
    }
}

