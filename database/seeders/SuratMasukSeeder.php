<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SuratMasukSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('surat_masuk')->insert([
            [
                'no_surat' => '001/PEL/VI/2026',
                'tanggal_surat' => '2026-07-20',
                'tanggal_diterima' => '2026-07-21',
                'pengirim' => 'PT. Agung Jaya',
                'penerima' => 'Resepsionis Pelindo',
                'perihal' => 'Penawaran Kerjasama',
                'file_path' => 'surat_masuk/001.pdf', // ← Ganti jadi file_path
                'ttd_pengirim_nama' => 'Andi Wijaya',
                'ttd_penerima_nama' => 'Budi Santoso',
                'ttd_pengirim_signature' => null,
                'ttd_penerima_signature' => null,
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'no_surat' => '002/PEL/VI/2026',
                'tanggal_surat' => '2026-07-19',
                'tanggal_diterima' => '2026-07-20',
                'pengirim' => 'PT. Bina Karya',
                'penerima' => 'Resepsionis Pelindo',
                'perihal' => 'Undangan Rapat Kerja',
                'file_path' => 'surat_masuk/002.pdf', // ← Ganti jadi file_path
                'ttd_pengirim_nama' => 'Siti Rahayu',
                'ttd_penerima_nama' => 'Budi Santoso',
                'ttd_pengirim_signature' => null,
                'ttd_penerima_signature' => null,
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'no_surat' => '003/PEL/VI/2026',
                'tanggal_surat' => '2026-07-18',
                'tanggal_diterima' => '2026-07-19',
                'pengirim' => 'Kementerian Perhubungan',
                'penerima' => 'Resepsionis Pelindo',
                'perihal' => 'Izin Operasional Pelabuhan',
                'file_path' => 'surat_masuk/003.pdf', // ← Ganti jadi file_path
                'ttd_pengirim_nama' => 'Ir. Ahmad Fauzi',
                'ttd_penerima_nama' => 'Budi Santoso',
                'ttd_pengirim_signature' => null,
                'ttd_penerima_signature' => null,
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}