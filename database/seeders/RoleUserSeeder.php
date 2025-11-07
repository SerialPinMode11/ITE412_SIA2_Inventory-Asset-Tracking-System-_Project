<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- Admin User ---
        if (DB::table('users')->where('email', 'admin@example.com')->doesntExist()) {
            DB::table('users')->insert([
                'name'       => 'Admin User',
                'email'      => 'admin@example.com',
                'password'   => Hash::make('password'), 
                'role'       => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // --- Viewer User ---
        if (DB::table('users')->where('email', 'viewer@example.com')->doesntExist()) {
            DB::table('users')->insert([
                'name'       => 'Viewer User',
                'email'      => 'viewer@example.com',
                'password'   => Hash::make('password'),
                'role'       => 'viewer',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // --- Standard User (optional) ---
        if (DB::table('users')->where('email', 'user@example.com')->doesntExist()) {
            DB::table('users')->insert([
                'name'       => 'Standard User',
                'email'      => 'user@example.com',
                'password'   => Hash::make('password'),
                'role'       => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
