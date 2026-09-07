@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')

<!-- ========================================== -->
<!-- HEADER -->
<!-- ========================================== -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">
            <i class="fas fa-plus-circle me-2" style="color: #003366;"></i> Tambah Kategori
        </h1>
        <p class="text-muted small">Tambah kategori atau KKA baru</p>
    </div>
    <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<!-- ========================================== -->
<!-- FORM -->
<!-- ========================================== -->
<div class="dashboard-table">
    <div class="p-4">
        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <!-- Nama Kategori -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Nama Kategori <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama') }}" 
                           class="form-control @error('nama') is-invalid @enderror" 
                           placeholder="Contoh: Keuangan, SDM, Hukum" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kode KKA -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kode KKA</label>
                    <input type="text" name="kode_kka" value="{{ old('kode_kka') }}" 
                           class="form-control @error('kode_kka') is-invalid @enderror" 
                           placeholder="Contoh: KU.01, SM.01, HK.01">
                    <div class="form-text text-muted small">Kode untuk klasifikasi arsip (opsional)</div>
                    @error('kode_kka')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="col-12">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" 
                              class="form-control @error('deskripsi') is-invalid @enderror" 
                              placeholder="Deskripsi kategori...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- TOMBOL -->
                <div class="col-12">
                    <hr>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="fas fa-save me-2"></i> Simpan
                        </button>
                        <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary px-4">
                            Batal
                        </a>
                    </div>
                </div>

            </div> <!-- END row -->

        </form>
    </div>
</div>

<!-- SPACER -->
<div style="height: 40px;"></div>

@endsection