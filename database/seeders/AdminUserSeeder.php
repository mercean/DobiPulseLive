<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'adminsafwan@example.com',
            'password' => 'amirsaf32', // Use the hashed password
            'account_type' => 'admin', // Set as admin
        ]);
    }
}
