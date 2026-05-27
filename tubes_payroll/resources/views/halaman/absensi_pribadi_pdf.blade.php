<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PayTato | Rekap Absensi Karyawan</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1e293b;
            font-size: 11px;
            line-height: 1.4;
            /* Margin bawah diset 35px agar konten tabel tidak menabrak footer fixed */
            margin: 10px 10px 35px 10px;
            padding: 0;
        }
        .header-container { width: 100%; margin-bottom: 20px; }
        .title { font-size: 22px; font-weight: 900; text-transform: uppercase; margin: 0; color: #0f172a; }
        .subtitle { font-size: 12px; color: #f97316; font-weight: bold; text-transform: uppercase; margin: 4px 0 0 0; }

        /* Kotak Identitas Karyawan */
        .identity-box {
            width: 100%;
            border-collapse: collapse;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            margin-bottom: 25px;
        }
        .avatar-cell {
            padding: 15px 5px 15px 15px;
            width: 50px;
        }
        .avatar-circle {
            width: 44px;
            height: 44px;
            background-color: #ffedd5;
            color: #ea580c;
            border: 1px solid #fed7aa;
            border-radius: 50%;
            text-align: center;
            line-height: 44px;
            font-weight: 900;
            font-size: 15px;
        }
        .info-cell { padding: 15px; vertical-align: middle; }
        .info-name { font-size: 15px; font-weight: 900; color: #0f172a; text-transform: uppercase; margin: 0 0 4px 0; }
        .info-nip { font-size: 11px; font-weight: bold; color: #94a3b8; }
        .info-role { 
            background-color: #e2e8f0; color: #475569; font-size: 9px; 
            font-weight: 900; padding: 2px 6px; border-radius: 4px; 
            text-transform: uppercase; margin-left: 5px;
        }
        .period-cell { padding: 15px; text-align: right; vertical-align: middle; }
        .period-title { font-size: 9px; font-weight: 900; color: #94a3b8; text-transform: uppercase; margin: 0 0 2px 0; }
        .period-value { font-size: 11px; font-weight: 900; color: #1e293b; }

        /* Struktur Tabel Elemen Keterangan/Legenda */
        .legend-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 25px;
        }
        .legend-cell {
            padding-bottom: 15px;
            vertical-align: middle;
            white-space: nowrap;
        }
        .legend-text {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: #475569;
            display: inline-block;
            vertical-align: middle;
        }
        
        /* Kotak Huruf Inisial Status */
        .badge-box { 
            display: inline-table; 
            width: 18px; 
            height: 18px; 
            text-align: center; 
            vertical-align: middle;
            color: white; 
            font-size: 9px; 
            font-weight: 900; 
            border-radius: 4px; 
            margin-right: 6px;
        }
        .badge-text {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }

        /* Tabel Utama Data Absensi */
        table.data-table { width: 100%; border-collapse: collapse; border: 1px solid #e2e8f0; }
        table.data-table th { background-color: #f8fafc; color: #94a3b8; font-size: 9px; font-weight: bold; text-transform: uppercase; padding: 12px 10px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        table.data-table td { padding: 10px; border-bottom: 1px solid #f1f5f9; color: #334155; font-weight: bold; vertical-align: middle; }
        .td-no { color: #94a3b8; font-weight: normal; text-align: center; }
        .td-jam { color: #0f172a; font-family: monospace; font-size: 11px; }
        .text-center { text-align: center; }

        /* Badge Status di Kolom Tabel */
        .status-badge { 
            display: inline-table; 
            width: 20px; 
            height: 20px; 
            margin: 0 auto; 
            color: white; 
            font-size: 9px; 
            font-weight: 900; 
            border-radius: 5px; 
            text-align: center;
            vertical-align: middle;
        }

        /* Pewarnaan Tema Status */
        .bg-hadir { background-color: #22c55e; }
        .bg-terlambat { background-color: #f97316; }
        .bg-izin { background-color: #3b82f6; }
        .bg-sakit { background-color: #a855f7; }
        .bg-alpha { background-color: #ef4444; }
        .bg-libur { background-color: #cbd5e1; color: #64748b; }
        
        /* Kunci Footer Tetap Di Paling Bawah Halaman PDF */
        .footer { 
            position: fixed;
            bottom: -15px; 
            left: 0px; 
            right: 0px;
            height: 20px;
            text-align: center; 
            font-size: 9px; 
            font-weight: bold; 
            color: #94a3b8; 
            letter-spacing: 2px;
        }
    </style>
</head>
<body>

    <div class="footer">© {{ date('Y') }} PAYTATO PAY SYSTEM</div>

    <div class="header-container">
        <h2 class="title">Rekap Absensi Individu Karyawan</h2>
        <div class="subtitle">Periode {{ $periodeCarbon->translatedFormat('F Y') }}</div>
    </div>

    <table class="identity-box">
        <tr>
            <td class="avatar-cell">
                <div class="avatar-circle">{{ strtoupper(substr($user->nama, 0, 2)) }}</div>
            </td>
            <td class="info-cell">
                <div class="info-name">{{ $user->nama }}</div>
                <span class="info-nip">NIP. {{ $user->nip ?? '-' }}</span>
                <span class="info-role">{{ $namaJabatan }}</span>
            </td>
            <td class="period-cell">
                <div class="period-title">Periode Absensi</div>
                <div class="period-value">1 - {{ $periodeCarbon->endOfMonth()->translatedFormat('d F Y') }}</div>
            </td>
        </tr>
    </table>

    <table class="legend-table">
        <tr>
            <td class="legend-cell" style="width: 12%;">
                <span class="badge-box bg-hadir"><span class="badge-text">H</span></span>
                <span class="legend-text">Hadir</span>
            </td>
            <td class="legend-cell" style="width: 15%;">
                <span class="badge-box bg-terlambat"><span class="badge-text">TL</span></span>
                <span class="legend-text">Terlambat</span>
            </td>
            <td class="legend-cell" style="width: 10%;">
                <span class="badge-box bg-izin"><span class="badge-text">I</span></span>
                <span class="legend-text">Izin</span>
            </td>
            <td class="legend-cell" style="width: 11%;">
                <span class="badge-box bg-sakit"><span class="badge-text">S</span></span>
                <span class="legend-text">Sakit</span>
            </td>
            <td class="legend-cell" style="width: 25%;">
                <span class="badge-box bg-alpha"><span class="badge-text">A</span></span>
                <span class="legend-text">Alpha (Tidak Hadir)</span>
            </td>
            <td class="legend-cell" style="width: 27%;">
                <span class="badge-box bg-libur"><span class="badge-text">-</span></span>
                <span class="legend-text">Libur / Tidak Ada Jadwal</span>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 6%;">No</th>
                <th style="width: 16%;">Tanggal</th>
                <th style="width: 14%;">Hari</th>
                <th style="width: 16%;">Jam Datang</th>
                <th style="width: 16%;">Jam Keluar</th>
                <th class="text-center" style="width: 12%;">Status</th>
                <th style="width: 20%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataAbsensi as $index => $absensi)
                @php
                    $statusUpper = strtoupper($absensi->status_kehadiran);
                    $badgeClass = 'bg-libur'; $statusInisial = '-';
                    if (in_array($statusUpper, ['H', 'HADIR'])) { $badgeClass = 'bg-hadir'; $statusInisial = 'H'; }
                    elseif (in_array($statusUpper, ['TL', 'TERLAMBAT'])) { $badgeClass = 'bg-terlambat'; $statusInisial = 'TL'; }
                    elseif (in_array($statusUpper, ['I', 'IZIN'])) { $badgeClass = 'bg-izin'; $statusInisial = 'I'; }
                    elseif (in_array($statusUpper, ['S', 'SAKIT'])) { $badgeClass = 'bg-sakit'; $statusInisial = 'S'; }
                    elseif (in_array($statusUpper, ['A', 'ALPHA', 'ALPA'])) { $badgeClass = 'bg-alpha'; $statusInisial = 'A'; }
                @endphp
                <tr>
                    <td class="td-no">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('l') }}</td>
                    <td class="td-jam">{{ $absensi->jam_datang ? \Carbon\Carbon::parse($absensi->jam_datang)->format('H:i') : '-' }}</td>
                    <td class="td-jam">{{ $absensi->jam_keluar ? \Carbon\Carbon::parse($absensi->jam_keluar)->format('H:i') : '-' }}</td>
                    <td class="text-center">
                        <span class="status-badge {{ $badgeClass }}">
                            <span class="badge-text">{{ $statusInisial }}</span>
                        </span>
                    </td>
                    <td style="color: #64748b; font-weight: normal;">
                        @if($absensi->status_kehadiran == 'Terlambat')
    Terlambat {{ $absensi->menit_terlambat }} menit
@else
    {{ $absensi->status_kehadiran }}
@endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 40px 0; color: #94a3b8; font-size: 10px;">
                        Belum ada riwayat absensi di bulan ini
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>