<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi Karyawan | PayTato</title>
    <style>
        @page {
            margin: 15px;
            size: landscape;
        }
        body {
            font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;
            color: #1e293b;
            background-color: #ffffff;
            margin: 0;
            padding: 10px;
            font-size: 9px;
        }

        /* HEADER SECTION */
        .header-table {
            width: 100%;
            margin-bottom: 10px;
        }
        .brand-title {
            font-size: 20px;
            font-weight: 900;
            color: #0f172a;
            text-transform: uppercase;
            font-style: italic;
            margin: 0;
        }
        .brand-subtitle {
            font-size: 11px;
            font-weight: bold;
            color: #64748b;
            margin-top: 2px;
        }
        .brand-subtitle span { color: #f97316; }

        /* STATS CARDS (Dinamis) */
        .stats-grid {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: separate;
            border-spacing: 10px 0;
        }
        .stat-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 15px;
        }
        .stat-label {
            font-size: 8px;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .stat-value {
            font-size: 14px;
            font-weight: 900;
            color: #0f172a;
        }

        /* LEGEND */
        .legend-container {
            margin-bottom: 12px;
            padding-left: 10px;
        }
        .legend-item {
            display: inline-block;
            margin-right: 15px;
            font-size: 8px;
            font-weight: bold;
            color: #334155;
        }
        .legend-badge {
            display: inline-block;
            width: 14px;
            height: 14px;
            line-height: 14px;
            text-align: center;
            border-radius: 4px;
            color: #ffffff;
            font-size: 8px;
            font-weight: bold;
            margin-right: 4px;
        }

        /* TABLE MATRIX */
        .matrix-table {
            width: 100%;
            border-collapse: collapse;
        }
        .matrix-table th {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 5px 2px;
            font-weight: bold;
            color: #475569;
            text-align: center;
            text-transform: uppercase;
            font-size: 8px;
        }
        .matrix-table td {
            border: 1px solid #e2e8f0;
            padding: 4px 1px;
            text-align: center;
            vertical-align: middle;
        }

        /* KOLOM PROFIL & NO */
        .td-no { font-weight: bold; color: #64748b; width: 25px; }
        .td-profile {
            text-align: left !important;
            padding-left: 8px !important;
            white-space: nowrap;
            width: 180px;
        }
        .emp-avatar {
            display: inline-block;
            width: 20px;
            height: 20px;
            line-height: 20px;
            background-color: #fff7ed;
            border: 1px solid #ffedd5;
            border-radius: 6px;
            text-align: center;
            font-weight: 900;
            color: #ea580c;
            font-size: 9px;
            margin-right: 8px;
        }
        .emp-info {
            display: inline-block;
            vertical-align: middle;
        }
        .emp-name {
            font-weight: bold;
            color: #0f172a;
            font-size: 9px;
            text-transform: uppercase;
        }
        .emp-role {
            font-size: 7.5px;
            color: #94a3b8;
        }

        /* STATUS CIRCLE DOTS */
        .status-dot {
            display: inline-block;
            width: 14px;
            height: 14px;
            line-height: 14px;
            text-align: center;
            border-radius: 50%;
            font-weight: bold;
            font-size: 7px;
        }
        .dot-H  { background-color: #dcfce7; color: #166534; } /* Hadir */
        .dot-TL { background-color: #ffedd5; color: #9a3412; } /* Terlambat */
        .dot-I  { background-color: #dbeafe; color: #1e40af; } /* Izin */
        .dot-S  { background-color: #f3e8ff; color: #6b21a8; } /* Sakit */
        .dot-A  { background-color: #fee2e2; color: #991b1b; } /* Alpha */
        .dot-none { color: #cbd5e1; } /* Libur / Kosong */

        .bg-H  { background-color: #22c55e; }
        .bg-TL { background-color: #f97316; }
        .bg-I  { background-color: #3b82f6; }
        .bg-S  { background-color: #a855f7; }
        .bg-A  { background-color: #ef4444; }

        .th-total { background-color: #f1f5f9 !important; color: #0f172a !important; font-weight: 900 !important; }
        .td-total { font-weight: bold; color: #0f172a; background-color: #f8fafc; }
        .td-percent { font-weight: 900; color: #166534; background-color: #f0fdf4; }

        .footer-container {
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .footer-note {
            background-color: #fff7ed;
            border: 1px solid #ffedd5;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 8px;
            color: #9a3412;
            line-height: 1.4;
        }
    </style>
</head>
<body>

    <div class="header-container">
        <h1 class="brand-title"><b>Rekap Absensi Karyawan</b></h1>
        <p class="brand-subtitle">Periode: <span>{{ $periodeCarbon->translatedFormat('F Y') }}</span></p>
    </div>

    {{-- STATISTIK DINAMIS --}}
    <table class="stats-grid">
        <tr>
            <td class="stat-card">
                <div class="stat-label">Total Karyawan</div>
                <div class="stat-value">{{ $totalKaryawan }} Orang</div>
            </td>
            <td class="stat-card">
                <div class="stat-label">Rata-rata Kehadiran</div>
                <div class="stat-value">{{ number_format($rataRata, 2) }}%</div>
            </td>
            <td class="stat-card">
                <div class="stat-label">Total Hari Kerja</div>
                <div class="stat-value">{{ $totalHariKerja }} Hari</div>
            </td>
            <td class="stat-card">
                <div class="stat-label">Total Tidak Hadir</div>
                <div class="stat-value">{{ $totalTidakHadir }} Hari</div>
            </td>
        </tr>
    </table>

    <div class="legend-container">
        <span class="legend-item"><span class="legend-badge bg-H">H</span> Hadir</span>
        <span class="legend-item"><span class="legend-badge bg-TL">TL</span> Terlambat</span>
        <span class="legend-item"><span class="legend-badge bg-I">I</span> Izin</span>
        <span class="legend-item"><span class="legend-badge bg-S">S</span> Sakit</span>
        <span class="legend-item"><span class="legend-badge bg-A">A</span> Alpha (Tidak Hadir)</span>
    </div>

    <table class="matrix-table">
        <thead>
            <tr>
                <th rowspan="2" style="width: 20px;">NO</th>
                <th rowspan="2" class="th-main">KARYAWAN / JABATAN</th>
                <th colspan="{{ $totalHariKerja }}" style="background-color: #f1f5f9; italic: true;">
                    MEI 2026
                </th>
                <th colspan="2" class="th-total">TOTAL</th>
            </tr>
            <tr>
                @for($d = 1; $d <= $totalHariKerja; $d++)
                    @php 
                        $dateObj = \Carbon\Carbon::createFromDate($tahunPilihan, $bulanPilihan, $d);
                        $isWeekend = $dateObj->isWeekend();
                    @endphp
                    <th style="{{ $isWeekend ? 'color: #ef4444; background-color: #fef2f2;' : '' }}">
                        {{ $d }}<br>
                        <span style="font-size: 6px; font-weight: normal;">{{ substr($dateObj->translatedFormat('D'), 0, 3) }}</span>
                    </th>
                @endfor
                <th class="th-total">H</th>
                <th class="th-total">%</th>
            </tr>
        </thead>
        <tbody>
            @php $groupedAbsen = $dataAbsen->groupBy('nip'); @endphp
            @foreach($groupedAbsen as $nip => $records)
                @php 
                    $first = $records->first(); 
                    $inisial = strtoupper(substr($first->nama_pegawai, 0, 2));
                    $hadirCount = $records->whereIn('status', ['Hadir', 'Terlambat'])->count();
                @endphp
                <tr>
                    <td class="td-no">{{ $loop->iteration }}</td>
                    <td class="td-profile">
                        <div class="emp-avatar">{{ $inisial }}</div>
                        <div class="emp-info">
                            <div class="emp-name">{{ $first->nama_pegawai }}</div>
                            <div class="emp-role">{{ $first->profilPegawai->jabatan->nama_jabatan ?? 'Staf Bengkel' }}</div>
                        </div>
                    </td>

                    @for($d = 1; $d <= $totalHariKerja; $d++)
                        @php
                            $targetDate = sprintf('%04d-%02d-%02d', $tahunPilihan, $bulanPilihan, $d);
                            $absen = $records->firstWhere('tanggal', $targetDate);
                            $char = '-'; $class = 'dot-none';

                            if ($absen) {
                                $map = ['Hadir'=>'H', 'Terlambat'=>'TL', 'Izin'=>'I', 'Sakit'=>'S', 'Alpha'=>'A'];
                                $char = $map[$absen->status] ?? '-';
                                $class = 'dot-' . $char;
                            }
                            $isWeekend = \Carbon\Carbon::parse($targetDate)->isWeekend();
                        @endphp
                        <td style="{{ $isWeekend && $char == '-' ? 'background-color: #fff1f2;' : '' }}">
                            <span class="status-dot {{ $class }}">{{ $char }}</span>
                        </td>
                    @endfor

                    <td class="td-total">{{ $hadirCount }}</td>
                    <td class="td-percent">{{ $totalHariKerja > 0 ? round(($hadirCount / $totalHariKerja) * 100, 1) : 0 }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- FOOTER KETERANGAN DI PALING BAWAH --}}
    <div class="footer-container">
        <div class="footer-note">
            <strong>Keterangan:</strong><br>
            Rekap absensi berdasarkan data dari sistem fingerprint perusahaan PayTato. Data dapat berubah sesuai dengan penyesuaian absensi, lembur, atau kebijakan perusahaan. Dicetak otomatis oleh sistem.
        </div>
    </div>

</body>
</html>