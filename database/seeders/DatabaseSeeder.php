<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menjalankan seeder secara berurutan
        $this->call([
            UserSeeder::class,
            JadwalSeeder::class, // <-- Tambahkan ini agar Jadwal KRS ikut terisi
        ]);
    }
}
