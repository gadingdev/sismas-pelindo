@extends('layouts.app')

@section('title', 'Tambah Surat Masuk')

@section('content')

<!-- ========================================== -->
<!-- HEADER -->
<!-- ========================================== -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">
            <i class="fas fa-plus-circle me-2" style="color: #003366;"></i> Tambah Surat Masuk
        </h1>
        <p class="text-muted small">Input data surat yang diterima dari pihak eksternal</p>
    </div>
    <a href="{{ route('surat-masuk.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<!-- ========================================== -->
<!-- FORM -->
<!-- ========================================== -->
<div class="dashboard-table">
    <div class="p-4">
        <form action="{{ route('surat-masuk.store') }}" method="POST" enctype="multipart/form-data" id="suratForm">
            @csrf

            <div class="row g-3">
                <!-- ========================================== -->
                <!-- KOLOM KIRI -->
                <!-- ========================================== -->
                <div class="col-md-6">

                    <!-- Nomor Surat -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nomor Surat <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="no_surat" value="{{ old('no_surat') }}" 
                               class="form-control @error('no_surat') is-invalid @enderror">
                        @error('no_surat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pengirim -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Pengirim <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="pengirim" value="{{ old('pengirim') }}" 
                               class="form-control @error('pengirim') is-invalid @enderror" 
                               placeholder="Nama instansi/perusahaan" required>
                        @error('pengirim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Perihal -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Perihal
                        </label>
                        <input type="text" name="perihal" value="{{ old('perihal') }}" 
                               class="form-control @error('perihal') is-invalid @enderror" 
                               placeholder="Judul/perihal surat">
                        @error('perihal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <!-- ========================================== -->
                <!-- KOLOM KANAN -->
                <!-- ========================================== -->
                <div class="col-md-6">

                    <!-- Tanggal Surat -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Tanggal Surat <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat') }}" 
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
                        <input type="date" name="tanggal_diterima" value="{{ old('tanggal_diterima', date('Y-m-d')) }}" 
                               class="form-control @error('tanggal_diterima') is-invalid @enderror" required>
                        @error('tanggal_diterima')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ========================================== -->
                    <!-- UPLOAD FILE + TOMBOL × -->
                    <!-- ========================================== -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Upload File</label>

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
                <div class="col-12">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-pen me-2" style="color: #003366;"></i> Tanda Tangan Digital
                    </h5>
                    <div class="row g-3">

                        <!-- TTD Pengirim -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanda Tangan Pengirim</label>
                            <div class="border rounded p-2" style="background-color: #ffffff;">
                                <canvas id="signaturePadPengirim" style="width: 100%; height: 200px; border: 1px solid #dee2e6; border-radius: 4px;"></canvas>
                                <input type="hidden" name="ttd_pengirim_signature" id="ttdPengirimInput">
                                
                                <!-- NAMA DI BAWAH TTD -->
                                <div class="mt-2">
                                    <label class="form-label fw-semibold" style="font-size: 13px;">Nama Lengkap Pengirim</label>
                                    <input type="text" name="ttd_pengirim_nama" id="namaPengirim" 
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
                            <div class="border rounded p-2" style="background-color: #ffffff;">
                                <canvas id="signaturePadPenerima" style="width: 100%; height: 200px; border: 1px solid #dee2e6; border-radius: 4px;"></canvas>
                                <input type="hidden" name="ttd_penerima_signature" id="ttdPenerimaInput">
                                
                                <!-- NAMA DI BAWAH TTD -->
                                <div class="mt-2">
                                    <label class="form-label fw-semibold" style="font-size: 13px;">Nama Lengkap Penerima</label>
                                    <input type="text" name="ttd_penerima_nama" id="namaPenerima" 
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
                        <button type="submit" class="btn btn-primary px-5" id="btnSubmit">
                            <i class="fas fa-save me-2"></i> Simpan
                        </button>
                        <a href="{{ route('surat-masuk.index') }}" class="btn btn-outline-secondary px-4">
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
<!-- SCRIPT SIGNATURE PAD + FILE × -->
<!-- ========================================== -->
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var SignaturePad = window.SignaturePad;

    // ==========================================
    // SIGNATURE PAD
    // ==========================================

    var canvasPengirim = document.getElementById('signaturePadPengirim');
    var signaturePadPengirim = new SignaturePad(canvasPengirim, {
        backgroundColor: '#ffffff',
        penColor: '#003366',
        minWidth: 2,
        maxWidth: 4,
        dotSize: 2
    });

    var canvasPenerima = document.getElementById('signaturePadPenerima');
    var signaturePadPenerima = new SignaturePad(canvasPenerima, {
        backgroundColor: '#ffffff',
        penColor: '#003366',
        minWidth: 2,
        maxWidth: 4,
        dotSize: 2
    });

    function resizeCanvas(canvas) {
        var ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext('2d').scale(ratio, ratio);
    }

    resizeCanvas(canvasPengirim);
    resizeCanvas(canvasPenerima);

    window.clearSignature = function(type) {
        if (type === 'pengirim') {
            signaturePadPengirim.clear();
            document.getElementById('ttdPengirimInput').value = '';
        } else {
            signaturePadPenerima.clear();
            document.getElementById('ttdPenerimaInput').value = '';
        }
    };

    document.getElementById('suratForm').addEventListener('submit', function(e) {
        if (!signaturePadPengirim.isEmpty()) {
            document.getElementById('ttdPengirimInput').value = signaturePadPengirim.toDataURL('image/png');
        }
        if (!signaturePadPenerima.isEmpty()) {
            document.getElementById('ttdPenerimaInput').value = signaturePadPenerima.toDataURL('image/png');
        }
    });

    window.addEventListener('resize', function() {
        resizeCanvas(canvasPengirim);
        resizeCanvas(canvasPenerima);
    });

    // ==========================================
    // TOMBOL × UNTUK FILE
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