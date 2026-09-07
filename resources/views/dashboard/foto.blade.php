@extends('layouts.app')

@section('title', 'Kelola Foto Dashboard')

@section('content')

<!-- ========================================== -->
<!-- HEADER -->
<!-- ========================================== -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">
            <i class="fas fa-images me-2" style="color: #003366;"></i> Kelola Foto Dashboard
        </h1>
        <p class="text-muted small">Tambah atau hapus foto yang tampil di dashboard</p>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali 
    </a>
</div>

<!-- ========================================== -->
<!-- UPLOAD FOTO (SEJAJAR) -->
<!-- ========================================== -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3">
            <i class="fas fa-upload me-2" style="color: #003366;"></i> Upload Foto Baru
        </h5>

        <form action="{{ route('dashboard.upload-foto') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
            @csrf

            <div class="d-flex align-items-end gap-3 flex-wrap">
                <!-- Pilih Foto -->
                <div style="flex: 0 0 300px;">
                    <label class="form-label fw-semibold">Pilih Foto</label>
                    <div class="position-relative">
                        <input type="file" name="foto" id="fileInput" class="form-control form-control-sm" accept="image/*" style="padding-right: 35px;">
                        <button type="button" id="btnRemoveFile" class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-1" style="display: none; border: none; background: transparent; font-size: 14px; color: #dc3545; padding: 2px 4px;">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                </div>

                <!-- Tombol Upload -->
                <div style="padding-bottom: 1px;">
                    <button type="submit" class="btn btn-primary btn-sm px-3" style="margin-bottom: 0;">
                        <i class="fas fa-upload me-1"></i> Upload
                    </button>
                </div>
            </div>

            @error('foto')
                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
            @enderror
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- DAFTAR FOTO (SLIDER/CAROUSEL) -->
<!-- ========================================== -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="fw-bold mb-3">
            <i class="fas fa-list me-2" style="color: #003366;"></i> Daftar Foto
        </h5>

        @if($foto->count() > 0)
        <div id="fotoCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($foto as $index => $f)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $f->path) }}" 
                         class="d-block w-100" 
                         style="height: 500px; object-fit: cover; border-radius: 8px;">
                    <div class="text-center mt-2">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $f->id }})">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                        <form id="delete-form-{{ $f->id }}" action="{{ route('dashboard.hapus-foto', $f->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#fotoCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#fotoCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-images fa-3x text-muted mb-3"></i>
            <p class="text-muted">Belum ada foto. Upload foto pertama Anda!</p>
        </div>
        @endif
    </div>
</div>

<!-- SPACER -->
<div style="height: 40px;"></div>

@endsection

@push('scripts')
<script>
// ========================================== TOMBOL × UNTUK BATALKAN
const fileInput = document.getElementById('fileInput');
const btnRemoveFile = document.getElementById('btnRemoveFile');

fileInput.addEventListener('change', function() {
    if (this.files && this.files[0]) {
        btnRemoveFile.style.display = 'block';
    } else {
        btnRemoveFile.style.display = 'none';
    }
});

btnRemoveFile.addEventListener('click', function() {
    fileInput.value = '';
    btnRemoveFile.style.display = 'none';
});

// ========================================== HAPUS FOTO
function confirmDelete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Foto ini akan dihapus secara permanen!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endpush