<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\FotoDashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSurat = SuratMasuk::count();
        $bulanIni = SuratMasuk::whereMonth('tanggal_diterima', now()->month)
                              ->whereYear('tanggal_diterima', now()->year)
                              ->count();
        $hariIni = SuratMasuk::whereDate('tanggal_diterima', today())->count();
        $suratTerbaru = SuratMasuk::latest()->take(5)->get();
        $foto = FotoDashboard::orderBy('urutan')->get();
        $alamatKantor = 'Jl. Sultan Syarif Kasim No.1, Tlk. Binjai, Kec. Dumai Tim., Kota Dumai, Riau 28826';

        return view('dashboard', compact(
            'totalSurat',
            'bulanIni',
            'hariIni',
            'suratTerbaru',
            'foto',
            'alamatKantor'
        ));
    }

    public function kelolaFoto()
    {
        $foto = FotoDashboard::orderBy('urutan')->get();
        return view('dashboard.foto', compact('foto'));
    }

    public function uploadFoto(Request $request)
    {
        // Cek jumlah foto (maksimal 7)
        $jumlahFoto = FotoDashboard::count();
        if ($jumlahFoto >= 7) {
            return redirect()->back()->with('error', 'Maksimal 7 foto yang dapat diupload.');
        }

        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $file = $request->file('foto');
        $nama = $file->getClientOriginalName();
        $path = $file->store('foto_dashboard', 'public');

        $maxUrutan = FotoDashboard::max('urutan') ?? -1;

        FotoDashboard::create([
            'nama' => $nama,
            'path' => $path,
            'urutan' => $maxUrutan + 1,
        ]);

        return redirect()->route('dashboard.foto')->with('success', 'Foto berhasil ditambahkan!');
    }

    public function hapusFoto($id)
    {
        $foto = FotoDashboard::findOrFail($id);
        Storage::disk('public')->delete($foto->path);
        $foto->delete();

        return redirect()->route('dashboard.foto')->with('success', 'Foto berhasil dihapus!');
    }
}