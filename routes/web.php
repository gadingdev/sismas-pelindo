<?php

use App\Http\Controllers\{
    DashboardController,
    SuratMasukController,
    LaporanController,
    ProfilController,
};
use Illuminate\Support\Facades\Route;

// ==========================================
// HALAMAN UTAMA (Redirect ke login)
// ==========================================
Route::get('/', function () {
    return redirect()->route('login');
});

// ==========================================
// ROUTE YANG BUTUH LOGIN
// ==========================================
Route::middleware(['auth'])->group(function () {

    // ==========================================
    // DASHBOARD
    // ==========================================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==========================================
    // LACAK SURAT (DILETAKKAN DI ATAS RESOURCE)
    // ==========================================
    Route::get('/lacak', [SuratMasukController::class, 'lacak'])->name('surat-masuk.lacak');

    // ==========================================
    // SURAT MASUK (RESOURCE)
    // ==========================================
    Route::resource('surat-masuk', SuratMasukController::class);
    
    Route::get('/surat-masuk/{id}/download', [SuratMasukController::class, 'download'])->name('surat-masuk.download');
    Route::get('/surat-masuk/{id}/cetak', [SuratMasukController::class, 'cetak'])->name('surat-masuk.cetak');

    // ==========================================
    // LAPORAN
    // ==========================================
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export-excel');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');

    // ==========================================
    // PROFIL
    // ==========================================
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::post('/profil/change-password', [ProfilController::class, 'changePassword'])->name('profil.change-password');

    // ==========================================
    // KELOLA FOTO DASHBOARD
    // ==========================================
    Route::get('/dashboard/foto', [DashboardController::class, 'kelolaFoto'])->name('dashboard.foto');
    Route::post('/dashboard/foto', [DashboardController::class, 'uploadFoto'])->name('dashboard.upload-foto');
    Route::delete('/dashboard/foto/{id}', [DashboardController::class, 'hapusFoto'])->name('dashboard.hapus-foto');
});

// ==========================================
// AUTH ROUTES (Login, Register, Logout)
// ==========================================
require __DIR__.'/auth.php';