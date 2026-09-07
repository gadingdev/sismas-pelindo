<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            
            // Informasi Surat
            $table->string('no_surat')->unique();
            $table->date('tanggal_surat');
            $table->date('tanggal_diterima');
            $table->string('pengirim');
            $table->string('penerima')->nullable(); // UNTUK LACAK SURAT
            $table->text('perihal'); // Bisa diisi manual
            
            // File Digital
            $table->string('file_path')->nullable(); // Untuk scan surat
            
            // Tanda Tangan Digital (Signature Pad) + Nama di bawah
            $table->string('ttd_pengirim_nama')->nullable(); // Nama di bawah TTD
            $table->string('ttd_penerima_nama')->nullable(); // Nama di bawah TTD
            $table->text('ttd_pengirim_signature')->nullable(); // Base64 dari signature pad
            $table->text('ttd_penerima_signature')->nullable(); // Base64 dari signature pad
            
            // Created By (User yang input)
            $table->unsignedBigInteger('created_by')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};