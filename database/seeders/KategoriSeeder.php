<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            [
                'nama' => 'Kerjasama',
                'kode_kka' => 'KS.01',
                'deskripsi' => 'Surat terkait kerjasama dengan pihak ketiga (vendor, mitra, dll)'
            ],
            [
                'nama' => 'Keuangan',
                'kode_kka' => 'KU.01',
                'deskripsi' => 'Surat terkait keuangan, anggaran, dan pembayaran'
            ],
            [
                'nama' => 'Sumber Daya Manusia',
                'kode_kka' => 'SM.01',
                'deskripsi' => 'Surat terkait SDM, kepegawaian, dan pelatihan'
            ],
            [
                'nama' => 'Operasional',
                'kode_kka' => 'OP.01',
                'deskripsi' => 'Surat terkait operasional kantor dan kegiatan sehari-hari'
            ],
            [
                'nama' => 'Hukum',
                'kode_kka' => 'HK.01',
                'deskripsi' => 'Surat terkait hukum, peraturan, dan kontrak'
            ],
            [
                'nama' => 'Pengadaan',
                'kode_kka' => 'PG.01',
                'deskripsi' => 'Surat terkait pengadaan barang dan jasa'
            ],
            [
                'nama' => 'Teknologi Informasi',
                'kode_kka' => 'TI.01',
                'deskripsi' => 'Surat terkait IT, sistem, dan infrastruktur teknologi'
            ],
            [
                'nama' => 'Pemasaran',
                'kode_kka' => 'PM.01',
                'deskripsi' => 'Surat terkait pemasaran dan promosi'
            ],
            [
                'nama' => 'Umum',
                'kode_kka' => 'UM.01',
                'deskripsi' => 'Surat umum yang tidak masuk kategori lain'
            ],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }

        $this->command->info('✅ Kategori berhasil di-seed!');
    }
}