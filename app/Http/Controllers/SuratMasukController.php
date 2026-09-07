<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    // ==========================================
    // 1. DAFTAR SURAT
    // ==========================================
    public function index(Request $request)
    {
        $query = SuratMasuk::with(['creator']);

        if ($request->search) {
            $query->search($request->search);
        }

        if ($request->tanggal) {
            $query->whereDate('tanggal_diterima', $request->tanggal);
        }

        $surats = $query->latest()->paginate(10)->withQueryString();

        return view('surat_masuk.index', compact('surats'));
    }

    // ==========================================
    // 2. FORM TAMBAH SURAT
    // ==========================================
    public function create()
    {
        return view('surat_masuk.create');
    }

    // ==========================================
    // 3. SIMPAN SURAT
    // ==========================================
    public function store(Request $request)
    {
        $request->validate([
            'no_surat' => 'required|unique:surat_masuk',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'pengirim' => 'required|max:255',
            'penerima' => 'nullable|max:255',
            'perihal' => 'nullable|string',
            'file' => 'nullable|file|max:5120|mimes:pdf,doc,docx',
            'ttd_pengirim_signature' => 'nullable|string',
            'ttd_penerima_signature' => 'nullable|string',
            'ttd_pengirim_nama' => 'nullable|string|max:255',
            'ttd_penerima_nama' => 'nullable|string|max:255',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('surat_masuk', 'public');
        }

        // Simpan TTD Pengirim (base64)
        $ttdPengirimPath = null;
        if ($request->ttd_pengirim_signature) {
            $imageData = $request->ttd_pengirim_signature;
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = base64_decode($imageData);
            $filename = 'ttd_pengirim_' . time() . '.png';
            $path = 'ttd/' . $filename;
            Storage::disk('public')->put($path, $imageData);
            $ttdPengirimPath = $path;
        }

        // Simpan TTD Penerima (base64)
        $ttdPenerimaPath = null;
        if ($request->ttd_penerima_signature) {
            $imageData = $request->ttd_penerima_signature;
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = base64_decode($imageData);
            $filename = 'ttd_penerima_' . time() . '.png';
            $path = 'ttd/' . $filename;
            Storage::disk('public')->put($path, $imageData);
            $ttdPenerimaPath = $path;
        }

        SuratMasuk::create([
            'no_surat' => $request->no_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'tanggal_diterima' => $request->tanggal_diterima,
            'pengirim' => $request->pengirim,
            'penerima' => $request->penerima,
            'perihal' => $request->perihal,
            'file_path' => $filePath,
            'created_by' => Auth::id(),
            'ttd_pengirim_signature' => $ttdPengirimPath,
            'ttd_penerima_signature' => $ttdPenerimaPath,
            'ttd_pengirim_nama' => $request->ttd_pengirim_nama,
            'ttd_penerima_nama' => $request->ttd_penerima_nama,
        ]);

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat berhasil disimpan!');
    }

    // ==========================================
    // 4. DETAIL SURAT
    // ==========================================
    public function show($id)
    {
        $surat = SuratMasuk::with(['creator'])->findOrFail($id);
        return view('surat_masuk.show', compact('surat'));
    }

    // ==========================================
    // 5. FORM EDIT SURAT (HANYA ADMIN)
    // ==========================================
    public function edit($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki izin untuk mengedit surat.');
        }

        $surat = SuratMasuk::findOrFail($id);
        return view('surat_masuk.edit', compact('surat'));
    }

    // ==========================================
    // 6. UPDATE SURAT (HANYA ADMIN)
    // ==========================================
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki izin untuk mengupdate surat.');
        }

        $surat = SuratMasuk::findOrFail($id);

        $request->validate([
            'no_surat' => 'required|unique:surat_masuk,no_surat,' . $id,
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'pengirim' => 'required|max:255',
            'penerima' => 'nullable|max:255',
            'perihal' => 'nullable|string',
            'file' => 'nullable|file|max:5120|mimes:pdf,doc,docx',
            'ttd_pengirim_signature' => 'nullable|string',
            'ttd_penerima_signature' => 'nullable|string',
            'ttd_pengirim_nama' => 'nullable|string|max:255',
            'ttd_penerima_nama' => 'nullable|string|max:255',
        ]);

        // Update file
        if ($request->hasFile('file')) {
            if ($surat->file_path) {
                Storage::disk('public')->delete($surat->file_path);
            }
            $filePath = $request->file('file')->store('surat_masuk', 'public');
            $surat->file_path = $filePath;
        }

        // Update TTD Pengirim
        if ($request->ttd_pengirim_signature) {
            if ($surat->ttd_pengirim_signature) {
                Storage::disk('public')->delete($surat->ttd_pengirim_signature);
            }
            $imageData = $request->ttd_pengirim_signature;
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = base64_decode($imageData);
            $filename = 'ttd_pengirim_' . time() . '.png';
            $path = 'ttd/' . $filename;
            Storage::disk('public')->put($path, $imageData);
            $surat->ttd_pengirim_signature = $path;
        }

        // Update TTD Penerima
        if ($request->ttd_penerima_signature) {
            if ($surat->ttd_penerima_signature) {
                Storage::disk('public')->delete($surat->ttd_penerima_signature);
            }
            $imageData = $request->ttd_penerima_signature;
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = base64_decode($imageData);
            $filename = 'ttd_penerima_' . time() . '.png';
            $path = 'ttd/' . $filename;
            Storage::disk('public')->put($path, $imageData);
            $surat->ttd_penerima_signature = $path;
        }

        // UPDATE MANUAL (TANPA KOLOM TTD LAMA)
        $surat->no_surat = $request->no_surat;
        $surat->tanggal_surat = $request->tanggal_surat;
        $surat->tanggal_diterima = $request->tanggal_diterima;
        $surat->pengirim = $request->pengirim;
        $surat->penerima = $request->penerima;
        $surat->perihal = $request->perihal;
        $surat->ttd_pengirim_nama = $request->ttd_pengirim_nama;
        $surat->ttd_penerima_nama = $request->ttd_penerima_nama;
        $surat->save();

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat berhasil diupdate!');
    }

    // ==========================================
    // 7. HAPUS SURAT (HANYA ADMIN)
    // ==========================================
    public function destroy($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki izin untuk menghapus surat.');
        }

        $surat = SuratMasuk::findOrFail($id);

        if ($surat->file_path) {
            Storage::disk('public')->delete($surat->file_path);
        }
        if ($surat->ttd_pengirim_signature) {
            Storage::disk('public')->delete($surat->ttd_pengirim_signature);
        }
        if ($surat->ttd_penerima_signature) {
            Storage::disk('public')->delete($surat->ttd_penerima_signature);
        }

        $surat->delete();

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat berhasil dihapus!');
    }

    // ==========================================
    // 8. DOWNLOAD FILE
    // ==========================================
    public function download($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        if (!$surat->file_path) {
            abort(404, 'File tidak ditemukan.');
        }

        $path = storage_path('app/public/' . $surat->file_path);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan di server.');
        }

        $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $surat->no_surat) . '.pdf';

        return response()->download($path, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    // ==========================================
    // 9. LACAK SURAT
    // ==========================================
    public function lacak(Request $request)
    {
        $query = SuratMasuk::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_surat', 'LIKE', "%{$search}%")
                    ->orWhere('pengirim', 'LIKE', "%{$search}%")
                    ->orWhere('penerima', 'LIKE', "%{$search}%")
                    ->orWhere('perihal', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_diterima', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_diterima', '<=', $request->tanggal_akhir);
        }

        $surats = $query->latest()->paginate(10)->withQueryString();

        return view('surat_masuk.lacak', compact('surats'));
    }

    // ==========================================
    // 10. CETAK SURAT
    // ==========================================
    public function cetak($id)
    {
        $surat = SuratMasuk::with(['creator'])->findOrFail($id);
        return view('surat_masuk.cetak', compact('surat'));
    }
}