<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@hrm.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
        
        User::create([
            'name' => 'Regular User',
            'email' => 'user@hrm.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
    }
}
