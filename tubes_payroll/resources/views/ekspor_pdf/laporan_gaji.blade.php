<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penggajian Karyawan - PayTato</title>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        @page {
            size: a4 landscape;
            margin: 12mm;
        }

        .container {
            background: #ffffff;
            border-radius: 16px;
            padding: 25px;
            position: relative;
        }

        /* --- HEADER LAYOUT (TABEL MURNI) --- */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .header-table td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }

        /* Logo Brand Manual Tanpa SVG Eksternal agar Stabil */
        .logo-box {
            background: #ff6b00;
            padding: 8px;
            border-radius: 8px;
            text-align: center;
            width: 24px;
            height: 24px;
            display: inline-block;
            vertical-align: middle;
        }

        /* Membuat Kunci Pas Sederhana Menggunakan Teks Tebal Putih */
        .logo-icon-fallback {
            color: #ffffff;
            font-size: 18px;
            font-weight: bold;
            line-height: 22px;
            font-family: Arial, sans-serif;
        }

        .logo-text-wrapper {
            display: inline-block;
            vertical-align: middle;
            margin-left: 8px;
        }

        .logo-text {
            font-size: 26px;
            font-weight: bold;
            color: #0f172a;
            line-height: 1;
        }

        .logo-text span {
            color: #ff6b00;
        }

        .logo-sub {
            font-size: 8px;
            color: #64748b;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-top: 1px;
        }

        /* Judul Dokumen */
        .doc-title {
            font-size: 22px;
            font-weight: bold;
            color: #090d16;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }

        .badge-periode {
            display: inline-block;
            background: #fff5f0;
            border: 1px dashed #ff6b00;
            border-radius: 8px;
            padding: 4px 12px;
            font-size: 10px;
            font-weight: bold;
            color: #64748b;
            margin-top: 4px;
        }

        .badge-periode span {
            color: #ff6b00;
        }

        /* Box Info Waktu Kanan (Menggunakan CSS Murni Pengganti Jam) */
        .info-cetak-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 8px 12px;
            width: 185px;
            float: right;
        }

        /* Pengganti Ikon Emoji Jam */
        .clock-css-replacement {
            width: 14px;
            height: 14px;
            border: 2px solid #ff6b00;
            border-radius: 50px;
            display: inline-block;
            position: relative;
            vertical-align: middle;
            text-align: center;
        }
        
        .clock-pointer {
            position: absolute;
            background: #ff6b00;
            width: 2px;
            height: 5px;
            top: 2px;
            left: 6px;
        }

        .cetak-label {
            font-size: 8px;
            color: #94a3b8;
            font-weight: bold;
        }

        .cetak-time {
            font-size: 10px;
            font-weight: bold;
            color: #0f172a;
        }

        /* FIX: Menggunakan warna Solid Hex agar terbaca 100% oleh DomPDF */
        .orange-line-divider {
            height: 4px;
            background-color: #ff6b00; 
            border-radius: 4px;
            margin-top: 15px;
            margin-bottom: 20px;
            clear: both;
            font-size: 1px; /* mencegah ketebalan tambahan di beberapa versi browser */
        }

        /* --- DATA TABLE SECTION --- */
        .main-data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .main-data-table th {
            background-color: #f8fafc;
            padding: 10px 6px;
            font-size: 9px;
            font-weight: bold;
            color: #0f172a;
            border-bottom: 2px solid #edf2f7;
            text-transform: uppercase;
        }

        .main-data-table td {
            padding: 10px 6px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-size: 11px;
            color: #334155;
        }

        .karyawan-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .karyawan-table td {
            border: none !important;
            padding: 0 !important;
        }

        .box-avatar-nn {
            width: 28px;
            height: 28px;
            background-color: #090d16;
            color: #ffffff;
            border-radius: 6px;
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            line-height: 28px;
        }

        .nama-text {
            font-weight: bold;
            color: #090d16;
            font-size: 11px;
            text-transform: uppercase;
        }

        .nip-text {
            font-size: 9px;
            color: #94a3b8;
        }

        .val-primary-bold { font-weight: bold; color: #090d16; }
        .val-tunjangan-green { color: #10b981; font-weight: bold; }
        .val-bonus-blue { color: #2563eb; font-weight: bold; }
        .val-potongan-red { color: #ef4444; font-weight: bold; }

        .status-pill-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }

        .badge-terbit { background-color: #fff7ed; color: #f97316; border: 1px solid #ffedd5; }
        .badge-dibayar { background-color: #f0fdf4; color: #10b981; border: 1px solid #dcfce7; }
        .badge-draft { background-color: #fef2f2; color: #ef4444; border: 1px solid #fee2e2; }

        /* --- FOOTER SECTION --- */
        .footer-table-layout {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .footer-table-layout td {
            border: none;
            padding: 0;
            vertical-align: top;
        }

        .system-quote-box {
            border-left: 3px solid #ff6b00;
            padding-left: 10px;
        }

        .system-quote-text {
            font-size: 10px;
            color: #475569;
            line-height: 1.4;
        }

        .signature-area-box {
            text-align: center;
            width: 180px;
            float: right;
        }

        .signature-location-date {
            font-size: 11px;
            color: #475569;
            font-weight: bold;
            margin-bottom: 45px; 
        }

        .signature-line-name {
            font-weight: bold;
            color: #0f172a;
            font-size: 11px;
            border-top: 1px dashed #cbd5e1;
            padding-top: 4px;
        }

        .dot-pattern-decor {
            position: absolute;
            left: 25px;
            bottom: 15px;
            opacity: 0.12;
            font-size: 18px;
            letter-spacing: 4px;
            color: #64748b;
            line-height: 0.4;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

<div class="container">
    
    <table class="header-table">
        <tr>
            <td width="32%">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="42">
                            <div class="logo-box">
                                <!-- <div class="logo-icon-fallback">&#9881;</div> -->
                            </div>
                        </td>
                        <td>
                            <div class="logo-text-wrapper">
                                <div class="logo-text">Pay<span>Tato</span></div>
                                <div class="logo-sub">WORKSHOP MANAGEMENT SYSTEM</div>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>

            <td width="43%" class="text-center">
                <div class="doc-title">Laporan Penggajian Karyawan</div>
                <div class="badge-periode">
                    PERIODE : <span>{{ strtoupper($namaBulan) }} {{ $tahun }}</span>
                </div>
            </td>

            <td width="25%">
                <div class="info-cetak-box">
                    <table width="100%">
                        <tr>
                            <td width="22">
                                <div class="clock-css-replacement">
                                    <div class="clock-pointer"></div>
                                </div>
                            </td>
                            <td>
                                <div class="cetak-label">Dicetak pada</div>
                                <div class="cetak-time">
                                    {{ now()->translatedFormat('d F Y') }} | {{ now()->format('H:i') }} WIB
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <div class="orange-line-divider"></div>

    <table class="main-data-table">
        <thead>
            <tr>
                <th width="4%" class="text-center">NO</th>
                <th width="24%">KARYAWAN</th>
                <th width="10%" class="text-center">PERIODE</th>
                <th width="12%" class="text-right">GAJI POKOK</th>
                <th width="12%" class="text-right">TUNJANGAN</th>
                <th width="10%" class="text-right">BONUS</th>
                <th width="12%" class="text-right">TOTAL POTONGAN</th>
                <th width="16%" class="text-right">TOTAL TERIMA (BERSIH)</th>
                <th width="10%" class="text-center">STATUS</th>
            </tr>
        </thead>
        <tbody>
            @php $totalPengeluaran = 0; @endphp
            @forelse($data as $key => $gaji)
                @php $totalPengeluaran += $gaji->gaji_clean ?? $gaji->gaji_bersih; @endphp
                <tr>
                    <td class="text-center" style="font-weight: bold; color: #64748b;">
                        {{ sprintf("%02d", $key + 1) }}
                    </td>
                    
                    <td>
                        <table class="karyawan-table">
                            <tr>
                                <!-- <td width="34">
                                    <div class="box-avatar-nn">NN</div>
                                </td> -->
                                <td style="padding-left: 8px !important;">
                                    <div class="nama-text">{{ $gaji->pegawai->nama_lengkap ?? '-' }}</div>
                                    <div class="nip-text">NIP. {{ $gaji->nip }}</div>
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td class="text-center" style="font-weight: bold; color: #475569; text-transform: uppercase;">
                        {{ \Carbon\Carbon::parse($gaji->periode_mulai)->translatedFormat('M Y') }}
                    </td>

                    <td class="text-right val-primary-bold">
                        Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}
                    </td>
                    <td class="text-right val-tunjangan-green">
                        + Rp {{ number_format($gaji->total_tunjangan, 0, ',', '.') }}
                    </td>
                    <td class="text-right val-bonus-blue">
                        + Rp {{ number_format($gaji->bonus, 0, ',', '.') }}
                    </td>
                    <td class="text-right val-potongan-red">
                        - Rp {{ number_format($gaji->total_potongan, 0, ',', '.') }}
                    </td>
                    <td class="text-right val-primary-bold" style="font-size: 12px;">
                        Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}
                    </td>

                    <td class="text-center">
                        @if($gaji->status_bayar == 'Draft')
                            <span class="status-pill-badge badge-draft">DRAFT</span>
                        @elseif($gaji->status_bayar == 'Terbit')
                            <span class="status-pill-badge badge-terbit">TERBIT</span>
                        @else
                            <span class="status-pill-badge badge-dibayar">DIBAYAR</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 30px; color: #94a3b8;">
                        Tidak ditemukan data rekaman payroll pada periode aktif ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="footer-table-layout">
        <tr>
            <td width="60%">
                <div class="system-quote-box">
                    <div class="system-quote-text">
                        Laporan ini dicetak secara otomatis oleh sistem PayTato.<br>
                        Terima kasih atas dedikasi terbaik Anda. Total akumulasi bersih: <strong>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </td>

            <td width="40%">
                <div class="signature-area-box">
                    <div class="signature-location-date">
                        Medan, {{ now()->translatedFormat('d F Y') }}
                    </div>
                    <div class="signature-line-name">
                        Manager
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <div class="dot-pattern-decor">•••••<br>•••••</div>
</div>

</body>
</html>