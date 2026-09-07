@extends('layouts.app')

@section('title', 'Arsip Inaktif')

@section('content')

<!-- ========================================== -->
<!-- HEADER -->
<!-- ========================================== -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">
            <i class="fas fa-archive me-2" style="color: #003366;"></i> Arsip Inaktif
        </h1>
        <p class="text-muted small">Surat yang sudah selesai dan dipindahkan ke arsip inaktif</p>
    </div>
    <a href="{{ route('surat-masuk.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Surat Masuk
    </a>
</div>

<!-- ========================================== -->
<!-- SEARCH -->
<!-- ========================================== -->
<div class="dashboard-table mb-4">
    <div class="p-3">
        <form method="GET" action="{{ route('surat-masuk.arsip') }}" class="row g-2">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-transparent"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="form-control" 
                           placeholder="Cari nomor surat / pengirim / perihal...">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter me-1"></i> Cari
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('surat-masuk.arsip') }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-undo me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- TABEL ARSIP -->
<!-- ========================================== -->
<div class="dashboard-table">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3 text-center" style="width: 5%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">#</th>
                    <th class="py-3" style="width: 20%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">Nomor Surat</th>
                    <th class="py-3" style="width: 20%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">Pengirim</th>
                    <th class="py-3 d-none d-md-table-cell" style="width: 20%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">Perihal</th>
                    <th class="py-3" style="width: 12%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">Status</th>
                    <th class="py-3 text-center" style="width: 12%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">Tanggal</th>
                    <th class="py-3 text-center pe-4" style="width: 15%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($surats as $index => $surat)
                <tr>
                    <td class="ps-4 text-center text-muted fw-medium">{{ $surats->firstItem() + $index }}</td>
                    <td class="fw-semibold">
                        <span class="text-primary">{{ $surat->no_surat }}</span>
                    </td>
                    <td>{{ $surat->pengirim }}</td>
                    <td class="d-none d-md-table-cell text-muted">{{ Str::limit($surat->perihal, 35) }}</td>
                    <td>
                        <span class="badge bg-secondary">
                            <i class="fas fa-archive me-1"></i> Inaktif
                        </span>
                    </td>
                    <td class="text-center text-muted">{{ \Carbon\Carbon::parse($surat->tanggal_diterima)->format('d/m/Y') }}</td>
                    <td class="text-center pe-4">
                        <a href="{{ route('surat-masuk.show', $surat->id) }}" 
                           class="btn btn-sm btn-outline-primary rounded-circle" 
                           title="Detail"
                           style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form action="{{ route('surat-masuk.restore-to-aktif', $surat->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" 
                                    class="btn btn-sm btn-outline-success rounded-circle ms-1" 
                                    title="Kembalikan ke Aktif"
                                    onclick="return confirm('Kembalikan surat ini ke arsip aktif?')"
                                    style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-undo"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-archive fa-3x d-block mb-3 text-muted opacity-50"></i>
                        <span class="fw-semibold">Belum ada arsip inaktif</span>
                        <p class="small mb-0">Surat yang selesai akan otomatis masuk ke arsip inaktif</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($surats->hasPages())
    <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top" style="background-color: #f8f9fa;">
        <div class="text-muted small">
            Menampilkan {{ $surats->firstItem() ?? 0 }} - {{ $surats->lastItem() ?? 0 }} dari {{ $surats->total() }} data
        </div>
        <div>
            {{ $surats->appends(request()->query())->links() }}
        </div>
    </div>
    @endif
</div>

<!-- SPACER -->
<div style="height: 40px;"></div>

@endsection