@extends('layouts.app')

@section('title', 'Edit Disposisi')

@section('content')

<!-- ========================================== -->
<!-- HEADER -->
<!-- ========================================== -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">
            <i class="fas fa-pen me-2" style="color: #003366;"></i> Edit Disposisi
        </h1>
        <p class="text-muted small">Perbarui status disposisi</p>
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
        <form action="{{ route('disposisi.update', $disposisi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <!-- Status -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Status <span class="text-danger">*</span>
                    </label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="pending" {{ old('status', $disposisi->status) == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="proses" {{ old('status', $disposisi->status) == 'proses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ old('status', $disposisi->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Batas Waktu -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Batas Waktu</label>
                    <input type="date" name="batas_waktu" value="{{ old('batas_waktu', $disposisi->batas_waktu ? \Carbon\Carbon::parse($disposisi->batas_waktu)->format('Y-m-d') : '') }}" 
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
                            <i class="fas fa-save me-2"></i> Update
                        </button>
                        <a href="{{ route('disposisi.show', $disposisi->id) }}" class="btn btn-outline-secondary px-4">
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