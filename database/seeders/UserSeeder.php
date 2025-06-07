<?php

namespace Database\Seeders;

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
        User::create([
            'full_name' => 'Admin Utama',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jl. Admin No.1',
            'position' => 'Manager',
            'gender' => 'male',
            'birth_date' => '1990-01-01',
            'status' => 'active',
            'last_login_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        User::factory()->count(20)->create([
            'role' => 'employee',
        ]);
    }
}
