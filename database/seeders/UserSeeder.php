<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // Admin
        User::create([
            'nama' => 'Admin Kezi',
            'username' => 'admin',
            'email' => 'admin@kezistore.com',
            'password' => Hash::make('admin123'),
            'jabatan' => 'admin',
        ]);

        // Kasir 1
        User::create([
            'nama' => 'Kasir Joni',
            'username' => 'joni',
            'email' => 'joni@kezistore.com',
            'password' => Hash::make('joni123'),
            'jabatan' => 'kasir',
        ]);

        // Kasir 2
        User::create([
            'nama' => 'Kasir Siti',
            'username' => 'siti',
            'email' => 'siti@kezistore.com',
            'password' => Hash::make('siti123'),
            'jabatan' => 'kasir',
        ]);
    }
}
