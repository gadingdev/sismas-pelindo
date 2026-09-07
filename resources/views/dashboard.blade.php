@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<!-- ========================================== -->
<!-- 1. SELAMAT DATANG + NAMA USER -->
<!-- ========================================== -->
<div class="mb-3">
    <p class="text-muted mb-0" style="font-size: 14px;">Selamat datang,</p>
    <h3 class="fw-bold" style="color: #003366;">{{ Auth::user()->name }}</h3>
    <p class="text-muted mb-0" style="font-size: 13px; margin-top: 2px;">
        <i class="fas fa-calendar-alt me-1" style="color: #003366;"></i>
        {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
    </p>
</div>

<!-- ========================================== -->
<!-- 2. STATISTIK SURAT MASUK -->
<!-- ========================================== -->
<div class="row g-2 mb-5">
    <div class="col-md-4">
        <div class="stat-card text-center p-2" style="border: 1px solid #e9ecef; border-radius: 8px; background-color: #ffffff;">
            <div class="stat-icon bg-primary bg-opacity-10 text-primary mx-auto mb-1" style="width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="stat-label text-muted small text-uppercase fw-semibold" style="font-size: 10px;">Surat Masuk Hari Ini</div>
            <div class="stat-number fw-bold" style="font-size: 20px;">{{ $hariIni }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card text-center p-2" style="border: 1px solid #e9ecef; border-radius: 8px; background-color: #ffffff;">
            <div class="stat-icon bg-success bg-opacity-10 text-success mx-auto mb-1" style="width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-label text-muted small text-uppercase fw-semibold" style="font-size: 10px;">Surat Masuk Bulan Ini</div>
            <div class="stat-number fw-bold" style="font-size: 20px;">{{ $bulanIni }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card text-center p-2" style="border: 1px solid #e9ecef; border-radius: 8px; background-color: #ffffff;">
            <div class="stat-icon bg-warning bg-opacity-10 text-warning mx-auto mb-1" style="width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-label text-muted small text-uppercase fw-semibold" style="font-size: 10px;">Total Surat Masuk</div>
            <div class="stat-number fw-bold" style="font-size: 20px;">{{ $totalSurat }}</div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- 3. QUICK ACCESS BUTTONS (FITUR UTAMA) -->
<!-- ========================================== -->
<div class="row g-2 mb-5">
    <div class="col-md-4 text-center">
        <a href="{{ route('surat-masuk.index') }}" class="text-decoration-none d-block">
            <div style="display: inline-block; padding: 14px; border-radius: 6px; background-color: rgba(13, 110, 253, 0.08); border: 1px solid rgba(13, 110, 253, 0.2); transition: all 0.2s;">
                <i class="fas fa-envelope" style="font-size: 22px; color: #0d6efd;"></i>
            </div>
            <div style="font-weight: 500; font-size: 14px; color: #000000; margin-top: 6px;">Surat Masuk</div>
        </a>
    </div>
    <div class="col-md-4 text-center">
        <a href="{{ route('surat-masuk.lacak') }}" class="text-decoration-none d-block">
            <div style="display: inline-block; padding: 14px; border-radius: 6px; background-color: rgba(13, 110, 253, 0.08); border: 1px solid rgba(13, 110, 253, 0.2); transition: all 0.2s;">
                <i class="fas fa-search" style="font-size: 22px; color: #0d6efd;"></i>
            </div>
            <div style="font-weight: 500; font-size: 14px; color: #000000; margin-top: 6px;">Lacak Surat</div>
        </a>
    </div>
    <div class="col-md-4 text-center">
        <a href="{{ route('laporan.index') }}" class="text-decoration-none d-block">
            <div style="display: inline-block; padding: 14px; border-radius: 6px; background-color: rgba(13, 110, 253, 0.08); border: 1px solid rgba(13, 110, 253, 0.2); transition: all 0.2s;">
                <i class="fas fa-file-alt" style="font-size: 22px; color: #0d6efd;"></i>
            </div>
            <div style="font-weight: 500; font-size: 14px; color: #000000; margin-top: 6px;">Laporan</div>
        </a>
    </div>
</div>

<!-- ========================================== -->
<!-- 4. SLIDER FOTO -->
<!-- ========================================== -->
@if($foto->count() > 0)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-0" style="border-radius: 12px; overflow: hidden;">
        <div id="dashboardCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($foto as $index => $f)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $f->path) }}" 
                         class="d-block w-100" 
                         style="height: 520px; object-fit: cover;" 
                         alt="{{ $f->nama }}">
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#dashboardCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#dashboardCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            <div class="carousel-indicators">
                @foreach($foto as $index => $f)
                <button type="button" data-bs-target="#dashboardCarousel" data-bs-slide-to="{{ $index }}" 
                        class="{{ $index == 0 ? 'active' : '' }}" 
                        aria-current="{{ $index == 0 ? 'true' : 'false' }}" 
                        aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
        </div>
    </div>
</div>
@else
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body text-center py-5">
        <i class="fas fa-images fa-3x text-muted mb-3"></i>
        <p class="text-muted">Belum ada foto.</p>
        <a href="{{ route('dashboard.foto') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-upload me-1"></i> Tambah Foto
        </a>
    </div>
</div>
@endif

<!-- ========================================== -->
<!-- 5. ALAMAT PERUSAHAAN -->
<!-- ========================================== -->
<div class="text-center py-3 mt-4" style="padding-bottom: 40px;">
    <p class="mb-1" style="font-weight: 600; color: #003366; font-size: 14px;">
        PT Pelabuhan Indonesia (Persero) Regional 1 Dumai
    </p>
    <p class="mb-0" style="font-size: 13px; color: #6c757d;">
        {{ $alamatKantor }}
    </p>
</div>

@endsection