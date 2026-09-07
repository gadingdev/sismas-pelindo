@extends('layouts.app')

@section('title', 'Tambah Disposisi')

@section('content')

<!-- ========================================== -->
<!-- HEADER -->
<!-- ========================================== -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">
            <i class="fas fa-plus-circle me-2" style="color: #003366;"></i> Tambah Disposisi
        </h1>
        <p class="text-muted small">Buat disposisi untuk surat masuk</p>
    </div>
    <a href="{{ route('disposisi.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<!-- ========================================== -->
<!-- FORM -->
<!-- ========================================== -->
<div class="dashboard-table">
    <div class="p-4">
        <form action="{{ route('disposisi.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <!-- Surat -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Surat <span class="text-danger">*</span>
                    </label>
                    <select name="surat_masuk_id" class="form-select @error('surat_masuk_id') is-invalid @enderror" required>
                        <option value="">Pilih Surat</option>
                        @foreach($surats as $surat)
                            <option value="{{ $surat->id }}" {{ old('surat_masuk_id', $suratId ?? '') == $surat->id ? 'selected' : '' }}>
                                {{ $surat->no_surat }} - {{ $surat->perihal }}
                            </option>
                        @endforeach
                    </select>
                    @error('surat_masuk_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tujuan -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Tujuan Disposisi <span class="text-danger">*</span>
                    </label>
                    <select name="untuk_user_id" class="form-select @error('untuk_user_id') is-invalid @enderror" required>
                        <option value="">Pilih Staf</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('untuk_user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->jabatan ?? 'Staf' }})
                            </option>
                        @endforeach
                    </select>
                    @error('untuk_user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Instruksi -->
                <div class="col-12">
                    <label class="form-label fw-semibold">
                        Instruksi <span class="text-danger">*</span>
                    </label>
                    <textarea name="instruksi" rows="3" 
                              class="form-control @error('instruksi') is-invalid @enderror" 
                              placeholder="Tulis instruksi disposisi..." required>{{ old('instruksi') }}</textarea>
                    @error('instruksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Catatan -->
                <div class="col-12">
                    <label class="form-label fw-semibold">Catatan (Opsional)</label>
                    <textarea name="catatan" rows="2" 
                              class="form-control @error('catatan') is-invalid @enderror" 
                              placeholder="Catatan tambahan...">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Batas Waktu -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Batas Waktu</label>
                    <input type="date" name="batas_waktu" value="{{ old('batas_waktu', now()->addDays(7)->format('Y-m-d')) }}" 
                           class="form-control @error('batas_waktu') is-invalid @enderror">
                    @error('batas_waktu')
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
                        <a href="{{ route('disposisi.index') }}" class="btn btn-outline-secondary px-4">
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