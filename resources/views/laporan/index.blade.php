@extends('layouts.app')

@section('title', 'Laporan Surat Masuk')

@section('content')

<!-- ========================================== -->
<!-- HEADER -->
<!-- ========================================== -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">
            <i class="fas fa-file-alt me-2" style="color: #003366;"></i> Laporan Surat Masuk
        </h1>
        <p class="text-muted small">Rekap dan ekspor data surat masuk</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>
</div>

<!-- ========================================== -->
<!-- STATISTIK (SAMA DENGAN DASHBOARD) -->
<!-- ========================================== -->
<div class="row g-2 mb-4">
    <div class="col-md-4">
        <div class="stat-card text-center p-2" style="border: 1px solid #e9ecef; border-radius: 8px; background-color: #ffffff;">
            <div class="stat-icon bg-primary bg-opacity-10 text-primary mx-auto mb-1" style="width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-label text-muted small text-uppercase fw-semibold" style="font-size: 10px;">Total Surat</div>
            <div class="stat-number fw-bold" style="font-size: 20px;">{{ $total ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card text-center p-2" style="border: 1px solid #e9ecef; border-radius: 8px; background-color: #ffffff;">
            <div class="stat-icon bg-success bg-opacity-10 text-success mx-auto mb-1" style="width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-calendar-alt"></i> <!-- ← GANTI DARI fa-calendar-month -->
            </div>
            <div class="stat-label text-muted small text-uppercase fw-semibold" style="font-size: 10px;">Bulan Ini</div>
            <div class="stat-number fw-bold" style="font-size: 20px;">{{ $bulanIni ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card text-center p-2" style="border: 1px solid #e9ecef; border-radius: 8px; background-color: #ffffff;">
            <div class="stat-icon bg-warning bg-opacity-10 text-warning mx-auto mb-1" style="width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="stat-label text-muted small text-uppercase fw-semibold" style="font-size: 10px;">Hari Ini</div>
            <div class="stat-number fw-bold" style="font-size: 20px;">{{ $hariIni ?? 0 }}</div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- FILTER LAPORAN -->
<!-- ========================================== -->
<div class="dashboard-table mb-4">
    <div class="p-3">
        <form method="GET" action="{{ route('laporan.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="form-control" placeholder="Nomor surat / pengirim / perihal...">
                </div>
                <div class="col-md-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" style="font-weight: 500; padding: 6px 14px;">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary btn-sm" style="font-weight: 500;">
                            Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- TOMBOL EKSPOR -->
<!-- ========================================== -->
<div class="d-flex gap-2 mb-4">
    <a href="{{ route('laporan.export-excel', request()->query()) }}" class="btn btn-success">
        <i class="fas fa-file-excel me-2"></i> Export Excel
    </a>
    <a href="{{ route('laporan.export-pdf', request()->query()) }}" class="btn btn-danger">
        <i class="fas fa-file-pdf me-2"></i> Export PDF
    </a>
</div>

<!-- ========================================== -->
<!-- TABEL DATA -->
<!-- ========================================== -->
<div class="dashboard-table">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3 text-center" style="width: 5%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">No</th>
                    <th class="py-3" style="width: 20%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">Nomor Surat</th>
                    <th class="py-3" style="width: 20%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">Pengirim</th>
                    <th class="py-3 d-none d-md-table-cell" style="width: 25%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">Perihal</th>
                    <th class="py-3 text-center" style="width: 15%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">Tanggal Diterima</th>
                </tr>
            </thead>
            <tbody>
                @forelse($surats ?? [] as $index => $surat)
                <tr>
                    <td class="ps-4 text-center text-muted fw-medium">{{ $surats->firstItem() + $index }}</td>
                    <td class="fw-semibold">
                        <span class="text-primary">{{ $surat->no_surat }}</span>
                    </td>
                    <td>{{ $surat->pengirim }}</td>
                    <td class="d-none d-md-table-cell text-muted">{{ Str::limit($surat->perihal ?? '-', 35) }}</td>
                    <td class="text-center text-muted">{{ \Carbon\Carbon::parse($surat->tanggal_diterima)->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="fas fa-inbox fa-3x d-block mb-3 text-muted opacity-50"></i>
                        <span class="fw-semibold">Belum ada data</span>
                        <p class="small mb-0">Coba ubah filter atau tambahkan surat masuk</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="d-flex flex-wrap justify-content-between align-items-center px-3 py-2 border-top" style="background-color: #f8f9fa;">
        <div class="text-muted" style="font-size: 13px;">
            <i class="fas fa-list me-1"></i> 
            Menampilkan {{ $surats->firstItem() ?? 0 }} - {{ $surats->lastItem() ?? 0 }} dari {{ $surats->total() }} data
        </div>
        <div class="d-flex align-items-center gap-2">
            @if ($surats->onFirstPage())
                <span class="px-2 py-1 text-muted" style="font-size: 13px; border: 1px solid #dee2e6; border-radius: 4px; background-color: #f8f9fa; opacity: 0.6; cursor: not-allowed;">
                    « Previous
                </span>
            @else
                <a href="{{ $surats->previousPageUrl() }}" class="px-2 py-1 text-decoration-none" style="font-size: 13px; border: 1px solid #dee2e6; border-radius: 4px; color: #003366; background-color: #ffffff;">
                    « Previous
                </a>
            @endif

            <span class="text-muted" style="font-size: 13px;">
                Halaman {{ $surats->currentPage() }} dari {{ $surats->lastPage() }}
            </span>

            @if ($surats->hasMorePages())
                <a href="{{ $surats->nextPageUrl() }}" class="px-2 py-1 text-decoration-none" style="font-size: 13px; border: 1px solid #dee2e6; border-radius: 4px; color: #003366; background-color: #ffffff;">
                    Next »
                </a>
            @else
                <span class="px-2 py-1 text-muted" style="font-size: 13px; border: 1px solid #dee2e6; border-radius: 4px; background-color: #f8f9fa; opacity: 0.6; cursor: not-allowed;">
                    Next »
                </span>
            @endif
        </div>
    </div>
</div>

<!-- SPACER -->
<div style="height: 40px;"></div>

@endsection