@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')

<!-- ========================================== -->
<!-- HEADER -->
<!-- ========================================== -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">
            <i class="fas fa-folder me-2" style="color: #003366;"></i> Daftar Kategori
        </h1>
        <p class="text-muted small">Kelola kategori dan KKA surat</p>
    </div>
    <a href="{{ route('kategori.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Tambah Kategori
    </a>
</div>

<!-- ========================================== -->
<!-- TABEL KATEGORI -->
<!-- ========================================== -->
<div class="dashboard-table">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3" style="width: 5%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">#</th>
                    <th class="py-3" style="width: 25%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">Nama Kategori</th>
                    <th class="py-3" style="width: 20%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">Kode KKA</th>
                    <th class="py-3" style="width: 35%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">Deskripsi</th>
                    <th class="py-3 text-center pe-4" style="width: 15%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $index => $kategori)
                <tr>
                    <td class="ps-4 text-center text-muted fw-medium">{{ $kategoris->firstItem() + $index }}</td>
                    <td class="fw-semibold">{{ $kategori->nama }}</td>
                    <td>
                        @if($kategori->kode_kka)
                            <span class="badge bg-primary">{{ $kategori->kode_kka }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-muted">{{ $kategori->deskripsi ?? '-' }}</td>
                    <td class="text-center pe-4">
                        <a href="{{ route('kategori.edit', $kategori->id) }}" 
                           class="btn btn-sm btn-outline-warning rounded-circle" 
                           title="Edit"
                           style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-sm btn-outline-danger rounded-circle ms-1" 
                                    title="Hapus"
                                    onclick="return confirm('Yakin ingin menghapus kategori ini?')"
                                    style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="fas fa-folder-open fa-3x d-block mb-3 text-muted opacity-50"></i>
                        <span class="fw-semibold">Belum ada kategori</span>
                        <p class="small mb-0">Silakan tambahkan kategori baru</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- FOOTER -->
    <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top" style="background-color: #f8f9fa;">
        <div class="text-muted small">
            Menampilkan {{ $kategoris->firstItem() ?? 0 }} - {{ $kategoris->lastItem() ?? 0 }} dari {{ $kategoris->total() }} data
        </div>
        <div>
            {{ $kategoris->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<!-- SPACER -->
<div style="height: 40px;"></div>

@endsection