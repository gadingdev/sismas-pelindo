@extends('layouts.app')

@section('title', 'Lacak Surat')

@section('content')

<!-- ========================================== -->
<!-- HEADER -->
<!-- ========================================== -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">
            <i class="fas fa-search me-2" style="color: #003366;"></i> Lacak Surat
        </h1>
        <p class="text-muted small">Cari posisi surat berdasarkan nomor surat</p>
    </div>
    <a href="{{ route('disposisi.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<!-- ========================================== -->
<!-- FORM PENCARIAN (DIPERKECIL) -->
<!-- ========================================== -->
<div class="dashboard-table mb-4">
    <div class="p-3">
        <form method="GET" action="{{ route('disposisi.track') }}" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-semibold">Nomor Surat</label>
                <input type="text" name="no_surat" value="{{ request('no_surat') }}" 
                       class="form-control" 
                       placeholder="Contoh: 001/PT.X/VI/2026">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-1"></i> Cari
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('disposisi.track') }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-undo me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- HASIL PENCARIAN -->
<!-- ========================================== -->
@if(request('no_surat'))

    @if(isset($surat) && $surat)

        <!-- ========================================== -->
        <!-- SURAT DITEMUKAN -->
        <!-- ========================================== -->
        <div class="dashboard-table">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-file-alt me-2" style="color: #003366;"></i> {{ $surat->no_surat }}
                        </h5>
                        <p class="text-muted small mb-0">
                            Diterima: {{ \Carbon\Carbon::parse($surat->tanggal_diterima)->format('d/m/Y') }}
                        </p>
                    </div>
                    <div>
                        <span class="badge {{ $surat->status === 'baru' ? 'bg-danger' : ($surat->status === 'proses_disposisi' ? 'bg-warning' : 'bg-success') }} px-3 py-2">
                            <i class="fas {{ $surat->status === 'baru' ? 'fa-clock' : ($surat->status === 'proses_disposisi' ? 'fa-spinner fa-spin' : 'fa-check-circle') }} me-1"></i>
                            {{ $surat->status_label }}
                        </span>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase">Pengirim</label>
                        <p class="fw-semibold">{{ $surat->pengirim }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase">Perihal</label>
                        <p>{{ $surat->perihal }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase">Kategori</label>
                        <p>{{ $surat->kategori->nama ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase">Keamanan / Kecepatan</label>
                        <p>
                            <span class="badge {{ $surat->keamanan === 'biasa' ? 'bg-success' : ($surat->keamanan === 'rahasia' ? 'bg-warning' : 'bg-danger') }}">
                                {{ $surat->keamanan_label }}
                            </span>
                            <span class="badge {{ $surat->kecepatan === 'biasa' ? 'bg-success' : ($surat->kecepatan === 'segera' ? 'bg-warning' : 'bg-danger') }} ms-1">
                                {{ $surat->kecepatan_label }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- HISTORI DISPOSISI -->
        <!-- ========================================== -->
        <div class="dashboard-table mt-4">
            <div class="px-4 py-3 border-bottom">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-history me-2" style="color: #003366;"></i> Histori Disposisi
                </h5>
            </div>
            <div class="p-4">
                @if(isset($disposisis) && $disposisis->count() > 0)
                    <div class="timeline">
                        @foreach($disposisis as $disposisi)
                        <div class="d-flex gap-3 mb-3">
                            <div class="shrink-0">
                                <span class="badge rounded-circle p-2 {{ $disposisi->status === 'selesai' ? 'bg-success' : ($disposisi->status === 'proses' ? 'bg-warning' : 'bg-secondary') }}">
                                    <i class="fas {{ $disposisi->status === 'selesai' ? 'fa-check' : ($disposisi->status === 'proses' ? 'fa-spinner fa-spin' : 'fa-clock') }} text-white"></i>
                                </span>
                            </div>
                            <div class="grow">
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div>
                                        <p class="fw-semibold mb-0">{{ $disposisi->instruksi }}</p>
                                        <p class="text-muted small mb-0">
                                            Dari: <strong>{{ $disposisi->dariUser->name ?? '-' }}</strong>
                                            → Untuk: <strong>{{ $disposisi->untukUser->name ?? '-' }}</strong>
                                        </p>
                                        @if($disposisi->catatan)
                                            <p class="text-muted small mb-0">📝 {{ $disposisi->catatan }}</p>
                                        @endif
                                    </div>
                                    <div class="text-end">
                                        <span class="badge {{ $disposisi->status === 'selesai' ? 'bg-success' : ($disposisi->status === 'proses' ? 'bg-warning' : 'bg-secondary') }}">
                                            {{ $disposisi->status_label }}
                                        </span>
                                        <p class="text-muted small mb-0">
                                            {{ \Carbon\Carbon::parse($disposisi->created_at)->format('d/m/Y H:i') }}
                                        </p>
                                        @if($disposisi->batas_waktu)
                                            <p class="small {{ \Carbon\Carbon::parse($disposisi->batas_waktu)->isPast() && $disposisi->status != 'selesai' ? 'text-danger' : 'text-muted' }}">
                                                ⏰ {{ \Carbon\Carbon::parse($disposisi->batas_waktu)->format('d/m/Y') }}
                                                @if(\Carbon\Carbon::parse($disposisi->batas_waktu)->isPast() && $disposisi->status != 'selesai')
                                                    <span class="badge bg-danger ms-1" style="font-size: 9px;">Lewat</span>
                                                @endif
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-muted py-3">
                        <i class="fas fa-inbox fa-2x d-block mb-2 text-muted opacity-50"></i>
                        Belum ada disposisi untuk surat ini
                    </p>
                @endif
            </div>
        </div>

    @else
        <!-- ========================================== -->
        <!-- SURAT TIDAK DITEMUKAN -->
        <!-- ========================================== -->
        <div class="dashboard-table">
            <div class="p-4 text-center">
                <i class="fas fa-exclamation-circle fa-3x text-warning mb-3"></i>
                <h5 class="fw-bold">Surat Tidak Ditemukan</h5>
                <p class="text-muted">Surat dengan nomor <strong>"{{ request('no_surat') }}"</strong> tidak ditemukan di sistem.</p>
                <p class="text-muted small">Pastikan nomor surat yang dimasukkan benar.</p>
            </div>
        </div>
    @endif

@else
    <!-- ========================================== -->
    <!-- DEFAULT: BELUM CARI -->
    <!-- ========================================== -->
    <div class="dashboard-table">
        <div class="p-5 text-center">
            <i class="fas fa-search fa-4x text-muted opacity-25 mb-3"></i>
            <h5 class="fw-bold text-muted">Cari Surat</h5>
            <p class="text-muted">Masukkan nomor surat di atas untuk melacak posisinya.</p>
        </div>
    </div>
@endif

<!-- SPACER -->
<div style="height: 40px;"></div>

@endsection