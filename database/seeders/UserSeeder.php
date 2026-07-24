<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@smartclass.com',
            'role' => 'admin',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        // Membuat Akun Mahasiswa
        User::create([
            'name' => 'Nadin Rahmatika Piliang',
            'nim' => '240170079',
            'program_studi' => 'Teknik Informatika',
            'email' => 'NadinRahmatikaPiliang@smartclass.com',
            'role' => 'user',
            'password' => Hash::make('240170079'),
            'email_verified_at' => now(),
        ]);
    }
}
