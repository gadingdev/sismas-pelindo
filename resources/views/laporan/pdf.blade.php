<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Surat Masuk</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Times New Roman', Times, serif;
        }
        body {
            font-size: 12pt;
            padding: 30px 20px;
            color: #000000;
            background: #ffffff;
            line-height: 1.5;
        }

        /* ================================ */
        /* HEADER */
        /* ================================ */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 12px;
            margin-bottom: 0;
        }
        .header-left img {
            height: 50px;
            width: auto;
            object-fit: contain;
            margin-bottom: 12px;
        }
        .header-center {
            text-align: center;
            flex: 1;
        }
        .header-center .title {
            font-size: 14pt;
            font-weight: bold;
            color: #003366;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }
        .header-center .sub {
            font-size: 12pt;
            color: #333;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .header-center .periode {
            font-size: 11pt;
            color: #555;
            margin-bottom: 16px;
            font-family: 'Times New Roman', Times, serif;
        }

        /* ================================ */
        /* TABEL */
        /* ================================ */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
            font-size: 10pt;
        }
        table th {
            background-color: #f2f2f2;
            color: #000000;
            padding: 8px 8px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #000000;
            text-transform: uppercase;
            font-size: 10pt;
            letter-spacing: 0.5px;
        }
        table td {
            padding: 6px 8px;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;
            border-bottom: 1px solid #000000;
            border-top: none;
            color: #000000;
            text-align: center;
        }
        table tr:first-child td {
            border-top: none;
        }
        table tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        .total-row td {
            font-weight: bold;
            background-color: #f2f2f2;
            text-align: left;
        }

        .empty {
            text-align: center;
            padding: 30px 0;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>

    <!-- ========================================== -->
    <!-- HEADER -->
    <!-- ========================================== -->
    <div class="header">
        <div class="header-left">
            <img src="{{ public_path('images/logo-pelindo.png') }}" alt="Logo Pelindo">
        </div>
        <div class="header-center">
            <div class="title">LAPORAN SURAT MASUK</div>
            <div class="sub">PT PELABUHAN INDONESIA (PERSERO) REGIONAL 1 DUMAI</div>
            <div class="periode">
                Periode:
                @if(isset($start_date) && isset($end_date) && $start_date && $end_date)
                    @if($start_date == $end_date)
                        {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }}
                    @else
                        {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}
                    @endif
                @elseif(isset($start_date) && $start_date)
                    {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }}
                @elseif(isset($end_date) && $end_date)
                    {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}
                @else
                    Semua Data
                @endif
            </div>
        </div>
        <div style="width: 50px;"></div>
    </div>

    <!-- ========================================== -->
    <!-- TABEL -->
    <!-- ========================================== -->
    @if($surats->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 6%;">No</th>
                    <th style="width: 22%;">Nomor Surat</th>
                    <th style="width: 22%;">Pengirim</th>
                    <th style="width: 30%;">Perihal</th>
                    <th style="width: 20%;">Tanggal Diterima</th>
                </tr>
            </thead>
            <tbody>
                @foreach($surats as $index => $surat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $surat->no_surat }}</td>
                    <td>{{ $surat->pengirim }}</td>
                    <td>{{ $surat->perihal ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($surat->tanggal_diterima)->format('d/m/Y') }}</td>
                </tr>
                @endforeach

                <!-- Total Surat -->
                <tr class="total-row">
                    <td colspan="5"><strong>Total Surat:</strong> {{ $surats->count() }}</td>
                </tr>
            </tbody>
        </table>
    @else
        <div class="empty">
            <p>Tidak ada data surat masuk pada periode ini.</p>
        </div>
    @endif

</body>
</html>