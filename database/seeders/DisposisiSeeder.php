<?php

namespace Database\Seeders;

use App\Models\Disposisi;
use Illuminate\Database\Seeder;

class DisposisiSeeder extends Seeder
{
    public function run(): void
    {
        $disposisis = [
            // Disposisi untuk surat #001 (selesai)
            [
                'surat_masuk_id' => 1,
                'dari_user_id' => 4, // Dewi (Pimpinan)
                'untuk_user_id' => 7, // Andi (Staf)
                'instruksi' => 'Tolong analisis penawaran ini dan buat rekomendasi',
                'catatan' => 'Harap dikerjakan dengan teliti',
                'status' => 'selesai',
                'batas_waktu' => '2026-06-10',
                'selesai_at' => '2026-06-08',
            ],
            // Disposisi untuk surat #002 (proses)
            [
                'surat_masuk_id' => 2,
                'dari_user_id' => 6, // Rina (Pimpinan)
                'untuk_user_id' => 9, // Hendra (Staf Keuangan)
                'instruksi' => 'Cek data tagihan dan verifikasi kelengkapan dokumen',
                'catatan' => 'Prioritas karena batas waktu 7 hari',
                'status' => 'proses',
                'batas_waktu' => '2026-06-15',
                'selesai_at' => null,
            ],
            // Disposisi untuk surat #004 (proses)
            [
                'surat_masuk_id' => 4,
                'dari_user_id' => 4, // Dewi (Pimpinan)
                'untuk_user_id' => 8, // Sri (Staf Operasional)
                'instruksi' => 'Buat analisis kebutuhan perpanjangan kontrak',
                'catatan' => 'Koordinasikan dengan bagian hukum',
                'status' => 'proses',
                'batas_waktu' => '2026-06-20',
                'selesai_at' => null,
            ],
            // Disposisi untuk surat #007 (proses)
            [
                'surat_masuk_id' => 7,
                'dari_user_id' => 4, // Dewi (Pimpinan)
                'untuk_user_id' => 7, // Andi (Staf)
                'instruksi' => 'Evaluasi proposal event dan buat draft nota dinas',
                'catatan' => 'Libatkan bagian pemasaran',
                'status' => 'pending',
                'batas_waktu' => '2026-06-25',
                'selesai_at' => null,
            ],
            // Disposisi untuk surat #009 (proses)
            [
                'surat_masuk_id' => 9,
                'dari_user_id' => 6, // Rina (Pimpinan)
                'untuk_user_id' => 10, // Lina (Staf TU)
                'instruksi' => 'Siapkan data dan jadwal untuk audit internal',
                'catatan' => 'Koordinasikan dengan semua bagian',
                'status' => 'pending',
                'batas_waktu' => '2026-06-30',
                'selesai_at' => null,
            ],
        ];

        foreach ($disposisis as $disposisi) {
            Disposisi::create($disposisi);
        }

        $this->command->info('✅ Disposisi berhasil di-seed!');
    }
}