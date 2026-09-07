@extends('layouts.app')

@section('title', 'Edit Surat Masuk')

@section('content')

<!-- ========================================== -->
<!-- PENGECEKAN ROLE (HANYA ADMIN) -->
<!-- ========================================== -->
@if(auth()->user()->role !== 'admin')
    @php
        abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    @endphp
@endif

<!-- ========================================== -->
<!-- HEADER -->
<!-- ========================================== -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">
            <i class="fas fa-pen me-2" style="color: #003366;"></i> Edit Surat Masuk
        </h1>
        <p class="text-muted small">Perbarui data surat masuk</p>
    </div>
    <a href="{{ route('surat-masuk.show', $surat->id) }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Detail
    </a>
</div>

<!-- ========================================== -->
<!-- FORM EDIT -->
<!-- ========================================== -->
<div class="dashboard-table">
    <div class="p-4">
        <form action="{{ route('surat-masuk.update', $surat->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <!-- KOLOM KIRI -->
                <div class="col-md-6">

                    <!-- Nomor Surat -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nomor Surat <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="no_surat" value="{{ old('no_surat', $surat->no_surat) }}" 
                               class="form-control @error('no_surat') is-invalid @enderror" required>
                        @error('no_surat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pengirim -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Pengirim <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="pengirim" value="{{ old('pengirim', $surat->pengirim) }}" 
                               class="form-control @error('pengirim') is-invalid @enderror" required>
                        @error('pengirim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Perihal -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Perihal
                        </label>
                        <input type="text" name="perihal" value="{{ old('perihal', $surat->perihal) }}" 
                               class="form-control @error('perihal') is-invalid @enderror"
                               placeholder="Judul/perihal surat">
                        @error('perihal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <!-- KOLOM KANAN -->
                <div class="col-md-6">

                    <!-- Tanggal Surat -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Tanggal Surat <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat', \Carbon\Carbon::parse($surat->tanggal_surat)->format('Y-m-d')) }}" 
                               class="form-control @error('tanggal_surat') is-invalid @enderror" required>
                        @error('tanggal_surat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal Diterima -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Tanggal Diterima <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tanggal_diterima" value="{{ old('tanggal_diterima', \Carbon\Carbon::parse($surat->tanggal_diterima)->format('Y-m-d')) }}" 
                               class="form-control @error('tanggal_diterima') is-invalid @enderror" required>
                        @error('tanggal_diterima')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ========================================== -->
                    <!-- UPLOAD FILE + TOMBOL × -->
                    <!-- ========================================== -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Upload File (Kosongkan jika tidak diubah)</label>

                        <div class="position-relative">
                            <input type="file" name="file" id="fileInput" 
                                   class="form-control @error('file') is-invalid @enderror"
                                   accept=".pdf,.doc,.docx"
                                   style="padding-right: 40px;">
                            <!-- Tombol × -->
                            <button type="button" id="btnRemoveFile" 
                                    class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-1"
                                    style="display: none; border: none; background: transparent; font-size: 16px; color: #dc3545; padding: 2px 6px;">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>

                        <div class="form-text text-muted small">Maksimal 5MB (PDF, DOC, DOCX)</div>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <!-- ========================================== -->
                <!-- TANDA TANGAN (SIGNATURE PAD + NAMA) -->
                <!-- ========================================== -->
                <div class="col-12 mt-5">
                    
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-pen me-2" style="color: #003366;"></i> Tanda Tangan Digital
                    </h5>
                    <div class="row g-3">

                        <!-- TTD Pengirim -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanda Tangan Pengirim</label>
                            
                            <!-- Tampilkan TTD yang sudah ada -->
                            @if($surat->ttd_pengirim_signature)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $surat->ttd_pengirim_signature) }}" 
                                         alt="TTD Pengirim Saat Ini" 
                                         style="max-height: 80px; border: 1px solid #dee2e6; border-radius: 4px;">
                                    <br>
                                    <small class="text-muted">TTD saat ini (kosongkan canvas jika ingin mengganti)</small>
                                </div>
                            @endif

                            <div class="border rounded p-2" style="background-color: #ffffff;">
                                <canvas id="signaturePadPengirim" style="width: 100%; height: 200px; border: 1px solid #dee2e6; border-radius: 4px;"></canvas>
                                <input type="hidden" name="ttd_pengirim_signature" id="ttdPengirimInput">
                                
                                <!-- NAMA DI BAWAH TTD -->
                                <div class="mt-2">
                                    <label class="form-label fw-semibold" style="font-size: 13px;">Nama Lengkap Pengirim</label>
                                    <input type="text" name="ttd_pengirim_nama" 
                                           value="{{ old('ttd_pengirim_nama', $surat->ttd_pengirim_nama) }}" 
                                           class="form-control form-control-sm" placeholder="Nama penanda tangan">
                                </div>
                                
                                <div class="mt-2 d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="clearSignature('pengirim')">
                                        <i class="fas fa-undo me-1"></i> Ulangi
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- TTD Penerima -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanda Tangan Penerima</label>
                            
                            <!-- Tampilkan TTD yang sudah ada -->
                            @if($surat->ttd_penerima_signature)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $surat->ttd_penerima_signature) }}" 
                                         alt="TTD Penerima Saat Ini" 
                                         style="max-height: 80px; border: 1px solid #dee2e6; border-radius: 4px;">
                                    <br>
                                    <small class="text-muted">TTD saat ini (kosongkan canvas jika ingin mengganti)</small>
                                </div>
                            @endif

                            <div class="border rounded p-2" style="background-color: #ffffff;">
                                <canvas id="signaturePadPenerima" style="width: 100%; height: 200px; border: 1px solid #dee2e6; border-radius: 4px;"></canvas>
                                <input type="hidden" name="ttd_penerima_signature" id="ttdPenerimaInput">
                                
                                <!-- NAMA DI BAWAH TTD -->
                                <div class="mt-2">
                                    <label class="form-label fw-semibold" style="font-size: 13px;">Nama Lengkap Penerima</label>
                                    <input type="text" name="ttd_penerima_nama" 
                                           value="{{ old('ttd_penerima_nama', $surat->ttd_penerima_nama) }}" 
                                           class="form-control form-control-sm" placeholder="Nama penanda tangan">
                                </div>
                                
                                <div class="mt-2 d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="clearSignature('penerima')">
                                        <i class="fas fa-undo me-1"></i> Ulangi
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ========================================== -->
                <!-- TOMBOL -->
                <!-- ========================================== -->
                <div class="col-12">
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="fas fa-save me-2"></i> Update
                        </button>
                        <a href="{{ route('surat-masuk.show', $surat->id) }}" class="btn btn-outline-secondary px-4">
                            Batal
                        </a>
                    </div>
                </div>

            </div> <!-- END row -->

        </form>
    </div>
</div>

<!-- SPACER -->
<div style="height: 40px;"></div>

<!-- ========================================== -->
<!-- SCRIPT SIGNATURE PAD + CLEAR FILE -->
<!-- ========================================== -->
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var SignaturePad = window.SignaturePad;

    // ==========================================
    // SIGNATURE PAD
    // ==========================================

    // Inisialisasi Signature Pad Pengirim
    var canvasPengirim = document.getElementById('signaturePadPengirim');
    var signaturePadPengirim = new SignaturePad(canvasPengirim, {
        backgroundColor: '#ffffff',
        penColor: '#003366',
        minWidth: 2,
        maxWidth: 4,
        dotSize: 2
    });

    // Inisialisasi Signature Pad Penerima
    var canvasPenerima = document.getElementById('signaturePadPenerima');
    var signaturePadPenerima = new SignaturePad(canvasPenerima, {
        backgroundColor: '#ffffff',
        penColor: '#003366',
        minWidth: 2,
        maxWidth: 4,
        dotSize: 2
    });

    // Resize Canvas
    function resizeCanvas(canvas) {
        var ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext('2d').scale(ratio, ratio);
    }

    resizeCanvas(canvasPengirim);
    resizeCanvas(canvasPenerima);

    // Clear Signature
    window.clearSignature = function(type) {
        if (type === 'pengirim') {
            signaturePadPengirim.clear();
            document.getElementById('ttdPengirimInput').value = '';
        } else {
            signaturePadPenerima.clear();
            document.getElementById('ttdPenerimaInput').value = '';
        }
    };

    // Saat form disubmit
    document.getElementById('editForm').addEventListener('submit', function(e) {
        if (!signaturePadPengirim.isEmpty()) {
            document.getElementById('ttdPengirimInput').value = signaturePadPengirim.toDataURL('image/png');
        }
        if (!signaturePadPenerima.isEmpty()) {
            document.getElementById('ttdPenerimaInput').value = signaturePadPenerima.toDataURL('image/png');
        }
    });

    // Responsive
    window.addEventListener('resize', function() {
        resizeCanvas(canvasPengirim);
        resizeCanvas(canvasPenerima);
    });

    // ==========================================
    // CLEAR FILE (×)
    // ==========================================

    const fileInput = document.getElementById('fileInput');
    const btnRemoveFile = document.getElementById('btnRemoveFile');

    if (fileInput) {
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
    }
});
</script>
@endpush

@endsection