<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,        // User (admin, resepsionis, magang)
            SuratMasukSeeder::class,  // Data surat masuk dummy
        ]);
    }
}