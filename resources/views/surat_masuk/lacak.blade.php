@extends('layouts.app')

@section('title', 'Lacak Surat Masuk')

@section('content')

<!-- ========================================== -->
<!-- HEADER -->
<!-- ========================================== -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">
            <i class="fas fa-search me-2" style="color: #003366;"></i> Lacak Surat Masuk
        </h1>
        <p class="text-muted small">Cari dan lacak surat masuk dengan cepat</p>
    </div>
    <a href="{{ route('surat-masuk.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<!-- ========================================== -->
<!-- FORM PENCARIAN (TANPA TANGGAL) -->
<!-- ========================================== -->
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('surat-masuk.lacak') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Kata Kunci</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Nomor surat / pengirim / perihal..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i> Cari
                        </button>
                        <a href="{{ route('surat-masuk.lacak') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-undo me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- HASIL PENCARIAN -->
<!-- ========================================== -->
<div class="dashboard-table">
    <div class="p-4">
        @if(isset($surats) && $surats->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Surat</th>
                            <th>Pengirim</th>
                            <th>Perihal</th>
                            <th>Tanggal Diterima</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($surats as $index => $surat)
                        <tr>
                            <td>{{ $surats->firstItem() + $index }}</td>
                            <td><strong>{{ $surat->no_surat }}</strong></td>
                            <td>{{ $surat->pengirim }}</td>
                            <td>{{ Str::limit($surat->perihal, 40) }}</td>
                            <td>{{ \Carbon\Carbon::parse($surat->tanggal_diterima)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('surat-masuk.show', $surat->id) }}" 
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $surats->links() }}
            </div>

            <!-- Deskripsi Informasi Surat + Surat Digital -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle"></i> Informasi Surat</h5>
                        <p class="mb-0">Klik tombol <strong>Detail</strong> untuk melihat:</p>
                        <ul class="mb-0">
                            <li>Deskripsi lengkap informasi surat</li>
                            <li>Surat digital hasil scan (PDF)</li>
                            <li>Tanda tangan digital</li>
                        </ul>
                    </div>
                </div>
            </div>

        @elseif(isset($surats))
            <div class="text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <p class="text-muted">Tidak ada surat yang ditemukan.</p>
                <p class="text-muted small">Coba ubah kata kunci pencarian.</p>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <p class="text-muted">Gunakan form di atas untuk mencari surat.</p>
            </div>
        @endif
    </div>
</div>

<!-- SPACER -->
<div style="height: 40px;"></div>

@endsection