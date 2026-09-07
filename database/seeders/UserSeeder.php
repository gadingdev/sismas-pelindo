<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // ADMIN / RESEPSIONIS (Full Akses)
        // ==========================================
        User::create([
            'name' => 'Kak Resepsionis',
            'email' => 'resepsionis@pelindo.co.id',
            'nip' => '198001012024001',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // ==========================================
        // STAFF / MAGANG (Akses Terbatas)
        // ==========================================
        User::create([
            'name' => 'Anak Magang',
            'email' => 'magang@pelindo.co.id',
            'nip' => '200501012024002',
            'password' => Hash::make('password123'),
            'role' => 'staff',
        ]);

        User::create([
            'name' => 'Staff TU',
            'email' => 'stafftu@pelindo.co.id',
            'nip' => '198501152024003',
            'password' => Hash::make('password123'),
            'role' => 'staff',
        ]);

        $this->command->info('✅ User berhasil di-seed!');
    }
}