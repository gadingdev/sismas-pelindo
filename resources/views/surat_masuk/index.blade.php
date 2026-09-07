@extends('layouts.app')

@section('title', 'Daftar Surat Masuk')

@section('content')

<!-- ========================================== -->
<!-- HEADER -->
<!-- ========================================== -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">
            <i class="fas fa-envelope me-2" style="color: #003366;"></i> Daftar Surat Masuk
        </h1>
        <p class="text-muted small">Kelola semua surat masuk yang diterima</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
        <a href="{{ route('surat-masuk.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Tambah Surat
        </a>
    </div>
</div>

<!-- ========================================== -->
<!-- TABEL SURAT MASUK -->
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
                    <td class="d-none d-md-table-cell text-muted">{{ Str::limit($surat->perihal ?? '-', 35) }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($surat->tanggal_diterima)->format('d/m/Y') }}</td>
                    <td class="text-center pe-4">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('surat-masuk.show', $surat->id) }}" 
                               class="btn btn-sm btn-outline-primary rounded-circle" 
                               title="Detail"
                               style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('surat-masuk.edit', $surat->id) }}" 
                               class="btn btn-sm btn-outline-warning rounded-circle ms-1" 
                               title="Edit"
                               style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button type="button" 
                                    class="btn btn-sm btn-outline-danger rounded-circle ms-1" 
                                    title="Hapus"
                                    onclick="confirmDelete({{ $surat->id }})"
                                    style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-form-{{ $surat->id }}" action="{{ route('surat-masuk.destroy', $surat->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-inbox fa-3x d-block mb-3 text-muted opacity-50"></i>
                        <span class="fw-semibold">Belum ada surat masuk</span>
                        <p class="small mb-0">Silakan tambahkan surat masuk baru</p>
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

<!-- SWEET ALERT -->
@push('scripts')
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data surat ini akan dihapus secara permanen!",
        icon: 'question',
        iconColor: '#003366',
        showCancelButton: true,
        confirmButtonColor: '#003366',
        cancelButtonColor: '#dc3545',
        confirmButtonText: '<i class="fas fa-trash me-2"></i> Ya, Hapus!',
        cancelButtonText: '<i class="fas fa-times me-2"></i> Batal',
        reverseButtons: true,
        backdrop: 'rgba(0, 51, 102, 0.2)',
        background: '#ffffff',
        customClass: {
            title: 'text-dark fw-bold',
            confirmButton: 'btn btn-primary px-4 py-2',
            cancelButton: 'btn btn-outline-danger px-4 py-2',
            popup: 'rounded-4 shadow-lg',
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endpush

@endsection