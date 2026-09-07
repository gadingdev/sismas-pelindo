<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SuratExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = SuratMasuk::with(['creator']);

        // Filter tanggal (tanggal_diterima)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_diterima', [$request->start_date, $request->end_date]);
        }

        // Filter keyword (pengirim / perihal / no_surat)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_surat', 'LIKE', "%{$search}%")
                  ->orWhere('pengirim', 'LIKE', "%{$search}%")
                  ->orWhere('perihal', 'LIKE', "%{$search}%");
            });
        }

        $surats = $query->latest()->paginate(10)->withQueryString();

        // Statistik sederhana
        $total = SuratMasuk::count();
        $bulanIni = SuratMasuk::whereMonth('tanggal_diterima', now()->month)
                              ->whereYear('tanggal_diterima', now()->year)
                              ->count();
        $hariIni = SuratMasuk::whereDate('tanggal_diterima', today())->count();

        return view('laporan.index', compact('surats', 'total', 'bulanIni', 'hariIni'));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new SuratExport(
                $request->start_date,
                $request->end_date,
                $request->search
            ),
            'laporan-surat-masuk-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $query = SuratMasuk::with(['creator']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_diterima', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_surat', 'LIKE', "%{$search}%")
                  ->orWhere('pengirim', 'LIKE', "%{$search}%")
                  ->orWhere('perihal', 'LIKE', "%{$search}%");
            });
        }

        $surats = $query->latest()->get();

        $total = $surats->count();
        $bulanIni = $surats->whereBetween('tanggal_diterima', [now()->startOfMonth(), now()->endOfMonth()])->count();
        $hariIni = $surats->where('tanggal_diterima', today())->count();

        // ✅ Kirim filter tanggal ke view
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $pdf = Pdf::loadView('laporan.pdf', compact('surats', 'total', 'bulanIni', 'hariIni', 'start_date', 'end_date'));

        return $pdf->download('laporan-surat-masuk-' . now()->format('Y-m-d') . '.pdf');
    }
}