@extends('layouts.app')

@section('title', 'Detail Disposisi')

@section('content')

<!-- ========================================== -->
<!-- HEADER -->
<!-- ========================================== -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">
            <i class="fas fa-file-alt me-2" style="color: #003366;"></i> Detail Disposisi
        </h1>
        <p class="text-muted small">Informasi lengkap disposisi surat</p>
    </div>
    <a href="{{ route('disposisi.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<!-- ========================================== -->
<!-- CARD DETAIL -->
<!-- ========================================== -->
<div class="dashboard-table">
    <div class="p-4">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Surat</label>
                    <p class="fw-semibold">
                        <a href="{{ route('surat-masuk.show', $disposisi->surat_masuk_id) }}" class="text-primary">
                            {{ $disposisi->suratMasuk->no_surat ?? '-' }}
                        </a>
                    </p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Dari</label>
                    <p class="fw-semibold">{{ $disposisi->dariUser->name ?? '-' }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Untuk</label>
                    <p class="fw-semibold">{{ $disposisi->untukUser->name ?? '-' }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Status</label>
                    <p>
                        <span class="badge {{ $disposisi->status === 'pending' ? 'bg-secondary' : ($disposisi->status === 'proses' ? 'bg-warning' : 'bg-success') }} px-3 py-2">
                            <i class="fas {{ $disposisi->status === 'pending' ? 'fa-clock' : ($disposisi->status === 'proses' ? 'fa-spinner fa-spin' : 'fa-check-circle') }} me-1"></i>
                            {{ $disposisi->status_label }}
                        </span>
                    </p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Batas Waktu</label>
                    <p>
                        @if($disposisi->batas_waktu)
                            @php
                                $batas = \Carbon\Carbon::parse($disposisi->batas_waktu);
                                $isOverdue = $batas->isPast() && $disposisi->status != 'selesai';
                            @endphp
                            <span class="{{ $isOverdue ? 'text-danger fw-semibold' : '' }}">
                                {{ $batas->format('d/m/Y') }}
                                @if($isOverdue)
                                    <span class="badge bg-danger ms-1">Lewat</span>
                                @endif
                            </span>
                        @else
                            -
                        @endif
                    </p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Dibuat</label>
                    <p>{{ $disposisi->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            <div class="col-12">
                <hr>
                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Instruksi</label>
                    <p class="fw-semibold fs-5">{{ $disposisi->instruksi }}</p>
                </div>
                @if($disposisi->catatan)
                    <div class="mb-3">
                        <label class="text-muted small fw-bold text-uppercase">Catatan</label>
                        <p>{{ $disposisi->catatan }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- SPACER -->
<div style="height: 40px;"></div>

@endsection