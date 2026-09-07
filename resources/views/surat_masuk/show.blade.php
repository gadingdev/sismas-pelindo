@extends('layouts.app')

@section('title', 'Detail Surat Masuk')

@section('content')

<!-- ========================================== -->
<!-- HEADER -->
<!-- ========================================== -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">
            <i class="fas fa-file-alt me-2" style="color: #003366;"></i> Detail Surat Masuk
        </h1>
        <p class="text-muted small">Informasi lengkap surat masuk</p>
    </div>
    <div class="d-flex gap-2">
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('surat-masuk.edit', $surat->id) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-pen me-1"></i> Edit
        </a>
        @endif
        <a href="{{ route('surat-masuk.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<!-- ========================================== -->
<!-- CARD DETAIL SURAT -->
<!-- ========================================== -->
<div class="dashboard-table mb-4">
    <div class="p-4">
        <div class="row g-3">
            <!-- KIRI -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Nomor Surat</label>
                    <p class="fw-semibold fs-5">{{ $surat->no_surat }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Pengirim</label>
                    <p class="fw-semibold">{{ $surat->pengirim }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Perihal</label>
                    <p>{{ $surat->perihal ?? '-' }}</p>
                </div>
            </div>

            <!-- KANAN -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Tanggal Surat</label>
                    <p>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d/m/Y') }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Tanggal Diterima</label>
                    <p>{{ \Carbon\Carbon::parse($surat->tanggal_diterima)->format('d/m/Y') }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">File Digital</label>
                    @if($surat->file_path)
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ asset('storage/' . $surat->file_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye me-1"></i> Lihat
                            </a>
                            <a href="{{ route('surat-masuk.download', $surat->id) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-download me-1"></i> Download
                            </a>
                        </div>
                    @else
                        <span class="text-muted">Tidak ada file</span>
                    @endif
                </div>
            </div>

            <!-- ========================================== -->
            <!-- TANDA TANGAN DIGITAL + NAMA -->
            <!-- ========================================== -->
            <div class="col-12 mt-5">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-pen me-2" style="color: #003366;"></i> Tanda Tangan Digital
                </h5>
                <div class="row g-4">
                    <!-- TTD Pengirim -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <label class="fw-bold small text-uppercase mb-0">TTD Pengirim</label>
                            </div>
                            <div class="card-body text-center">
                                @if($surat->ttd_pengirim_signature)
                                    <img src="{{ asset('storage/' . $surat->ttd_pengirim_signature) }}" 
                                         alt="TTD Pengirim" 
                                         class="img-fluid rounded border p-2"
                                         style="max-height: 100px; width: auto;">
                                    <p class="mt-2 fw-semibold">{{ $surat->ttd_pengirim_nama ?? '-' }}</p>
                                @else
                                    <p class="text-muted">Belum ada tanda tangan</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- TTD Penerima -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <label class="fw-bold small text-uppercase mb-0">TTD Penerima</label>
                            </div>
                            <div class="card-body text-center">
                                @if($surat->ttd_penerima_signature)
                                    <img src="{{ asset('storage/' . $surat->ttd_penerima_signature) }}" 
                                         alt="TTD Penerima" 
                                         class="img-fluid rounded border p-2"
                                         style="max-height: 100px; width: auto;">
                                    <p class="mt-2 fw-semibold">{{ $surat->ttd_penerima_nama ?? '-' }}</p>
                                @else
                                    <p class="text-muted">Belum ada tanda tangan</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- INFO TAMBAHAN -->
            <div class="col-12">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase">Dibuat Oleh</label>
                        <p>{{ $surat->creator->name ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase">Dibuat Pada</label>
                        <p>{{ $surat->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- SPACER -->
<!-- ========================================== -->
<div style="height: 40px;"></div>

@endsection