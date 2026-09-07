<?php

namespace App\Exports;

use App\Models\SuratMasuk;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SuratExport implements 
    FromQuery, 
    WithHeadings, 
    WithMapping, 
    WithStyles, 
    ShouldAutoSize, 
    WithTitle,
    WithEvents
{
    protected $startDate;
    protected $endDate;
    protected $search;

    public function __construct($startDate = null, $endDate = null, $search = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->search = $search;
    }

    public function query()
    {
        $query = SuratMasuk::query();

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tanggal_diterima', [$this->startDate, $this->endDate]);
        }

        if ($this->search) {
            $search = $this->search;
            $query->where(function($q) use ($search) {
                $q->where('no_surat', 'LIKE', "%{$search}%")
                  ->orWhere('pengirim', 'LIKE', "%{$search}%")
                  ->orWhere('perihal', 'LIKE', "%{$search}%");
            });
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'NO',
            'NOMOR SURAT',
            'TANGGAL SURAT',
            'PENGIRIM',
            'PERIHAL',
            'TANGGAL DITERIMA',
        ];
    }

    public function map($surat): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $surat->no_surat,
            $surat->tanggal_surat ? date('d/m/Y', strtotime($surat->tanggal_surat)) : '-',
            $surat->pengirim,
            $surat->perihal ?? '-',
            $surat->tanggal_diterima ? date('d/m/Y', strtotime($surat->tanggal_diterima)) : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 11]],
        ];
    }

    public function title(): string
    {
        return 'Laporan Surat Masuk';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;

                // ==========================================
                // 1. SET FONT DEFAULT TIMES NEW ROMAN
                // ==========================================
                $sheet->getParent()->getDefaultStyle()->getFont()->setName('Times New Roman');

                // ==========================================
                // 2. HEADER (JUDUL + PERUSAHAAN + PERIODE)
                // ==========================================
                $sheet->insertNewRowBefore(1, 3);

                // Judul Utama
                $sheet->setCellValue('A1', 'LAPORAN SURAT MASUK');
                $sheet->mergeCells('A1:F1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                        'name' => 'Times New Roman',
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Nama Perusahaan
                $sheet->setCellValue('A2', 'PT PELABUHAN INDONESIA (PERSERO) REGIONAL 1 DUMAI');
                $sheet->mergeCells('A2:F2');
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                        'name' => 'Times New Roman',
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Periode
                if ($this->startDate && $this->endDate) {
                    if ($this->startDate == $this->endDate) {
                        $periode = date('d/m/Y', strtotime($this->startDate));
                    } else {
                        $periode = date('d/m/Y', strtotime($this->startDate)) . ' - ' . date('d/m/Y', strtotime($this->endDate));
                    }
                } else {
                    $periode = 'Semua Data';
                }

                $sheet->setCellValue('A3', 'Periode: ' . $periode);
                $sheet->mergeCells('A3:F3');
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => [
                        'size' => 11,
                        'name' => 'Times New Roman',
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // ==========================================
                // 3. HEADER TABEL
                // ==========================================
                $sheet->getStyle('A4:F4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 10,
                        'name' => 'Times New Roman',
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFE9ECEF'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // ==========================================
                // 4. DATA TABEL
                // ==========================================
                $rowCount = $sheet->getHighestRow();
                if ($rowCount > 4) {
                    $sheet->getStyle('A5:F' . $rowCount)->applyFromArray([
                        'font' => [
                            'size' => 10,
                            'name' => 'Times New Roman',
                        ],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => 'FF000000'],
                            ],
                        ],
                    ]);

                    $sheet->getStyle('A5:A' . $rowCount)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('C5:C' . $rowCount)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('F5:F' . $rowCount)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                // ==========================================
                // 5. TOTAL SURAT DI DALAM TABEL
                // ==========================================
                if ($rowCount > 4) {
                    $totalRow = $rowCount + 1;
                    $totalData = $rowCount - 4;

                    $sheet->setCellValue('A' . $totalRow, 'Total Surat: ' . $totalData);
                    $sheet->mergeCells('A' . $totalRow . ':F' . $totalRow);

                    $sheet->getStyle('A' . $totalRow . ':F' . $totalRow)->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'size' => 10,
                            'name' => 'Times New Roman',
                        ],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_LEFT,
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FFF2F2F2'],
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => 'FF000000'],
                            ],
                        ],
                    ]);
                }

                // ==========================================
                // 6. LEBAR KOLOM OTOMATIS
                // ==========================================
                foreach (range('A', 'F') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}