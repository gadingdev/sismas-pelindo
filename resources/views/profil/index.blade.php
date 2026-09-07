@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">
            <i class="fas fa-user-circle me-2" style="color: #003366;"></i> Profil Saya
        </h1>
        <p class="text-muted small">Kelola data diri dan password</p>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row">
    <!-- KOLOM KIRI: FOTO & INFO -->
    <div class="col-md-4">
        <div class="dashboard-table p-4" style="min-height: 400px; padding-bottom: 30px;">
            <div class="text-center">
                <!-- Foto Profil -->
                <div class="position-relative d-inline-block">
                    @if($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" 
                             alt="Foto Profil" 
                             class="rounded-circle img-fluid" 
                             id="fotoPreview"
                             style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #003366;">
                    @else
                        <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center" 
                             id="fotoPreview"
                             style="width: 150px; height: 150px; font-size: 60px; color: white;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <h5 class="mt-3">{{ $user->name }}</h5>
                <p class="text-muted">{{ $user->role === 'admin' ? 'Admin' : 'Staff' }}</p>
                <hr>
                <div class="text-start">
                    <p class="mb-1"><i class="fas fa-envelope me-2 text-primary"></i> {{ $user->email ?? '-' }}</p>
                    <p class="mb-1"><i class="fas fa-id-card me-2 text-primary"></i> {{ $user->nip ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: FORM -->
    <div class="col-md-8">
        <div class="dashboard-table p-4" style="min-height: 500px; padding-bottom: 30px;">
            
            <!-- ========================================== -->
            <!-- EDIT PROFIL -->
            <!-- ========================================== -->
            <h5 class="fw-bold mb-3">
                <i class="fas fa-edit me-2" style="color: #003366;"></i> Edit Profil
            </h5>
            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" id="profilForm">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                               class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                               class="form-control" placeholder="email@domain.com">
                        <small class="text-muted">Opsional</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">NIP</label>
                        <input type="text" name="nip" value="{{ old('nip', $user->nip) }}" 
                               class="form-control" placeholder="Nomor Induk Pegawai">
                        <small class="text-muted">Opsional</small>
                    </div>
                    
                    <!-- Upload Foto dengan Preview + Tombol X -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Foto Profil</label>
                        <div class="d-flex align-items-center gap-2">
                            <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/*">
                        </div>
                        <small class="text-muted">Max 10MB</small>
                        
                        <!-- Preview Foto -->
                        <div id="fotoPreviewContainer" class="mt-2" style="display: none;">
                            <div class="d-flex align-items-center gap-3 p-2 border rounded bg-light" style="max-width: 300px;">
                                <img id="fotoPreviewImg" src="#" alt="Preview" 
                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                <span id="fotoPreviewName" class="text-muted small grow"></span>
                                <button type="button" id="btnBatalFoto" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Update Profil
                        </button>
                    </div>
                </div>
            </form>

            <hr class="my-4">

            <!-- ========================================== -->
            <!-- GANTI PASSWORD -->
            <!-- ========================================== -->
            <h5 class="fw-bold mb-3">
                <i class="fas fa-lock me-2" style="color: #003366;"></i> Ganti Password
            </h5>
            <form action="{{ route('profil.change-password') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Password Lama</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Password Baru</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Konfirmasi Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key me-2"></i> Ganti Password
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- SPACER BIAR GAK KEPOTONG -->
<!-- ========================================== -->
<div style="height: 60px;"></div>

<!-- ========================================== -->
<!-- SCRIPT PREVIEW FOTO + TOMBOL BATAL -->
<!-- ========================================== -->
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fotoInput = document.getElementById('fotoInput');
    const previewContainer = document.getElementById('fotoPreviewContainer');
    const previewImg = document.getElementById('fotoPreviewImg');
    const previewName = document.getElementById('fotoPreviewName');
    const btnBatal = document.getElementById('btnBatalFoto');

    // Preview foto saat dipilih
    fotoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewName.textContent = file.name;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    // Tombol Batal (X) - hapus file yang dipilih
    btnBatal.addEventListener('click', function() {
        fotoInput.value = '';
        previewContainer.style.display = 'none';
        previewImg.src = '#';
        previewName.textContent = '';
    });
});
</script>
@endpush

<!-- SPACER EXTRA DI BAWAH SCRIPT -->
<div style="height: 40px;"></div>

@endsection