<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji {{ $pay->pegawai->nama ?? 'Karyawan' }} - {{ $pay->bulan }}</title>
    <style>
        @page {
            size: a4 portrait;
            margin: 18mm;
        }
        body {
            font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;
            color: #1e293b;
            line-height: 1.4;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        .table-layout {
            width: 100%;
            border-collapse: collapse;
        }
        .table-layout td {
            padding: 0;
            vertical-align: top;
        }

        
        .container {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            overflow: hidden;
        }

        
        .header-row {
            border-bottom: 1px solid #f1f5f9;
        }

        
        .logo-badge {
            background: #0f172a;
            padding: 15px 20px;
            border-radius: 0 0 0 0;
            display: inline-block;
        }
        .logo-inner {
            display: inline-block;
            vertical-align: middle;
        }
        .logo-icon-box {
            display: inline-block;
            width: 42px;
            height: 42px;
            background: #f97316;
            border-radius: 10px;
            text-align: center;
            line-height: 42px;
            vertical-align: middle;
        }
        .logo-text {
            display: inline-block;
            font-size: 22px;
            font-weight: 900;
            color: #ffffff;
            font-style: italic;
            vertical-align: middle;
            margin-left: 10px;
            letter-spacing: -0.5px;
        }
        .logo-text .orange { color: #f97316; }

        .company-title {
            font-size: 10px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding-left: 14px;
            vertical-align: middle;
        }

        
        .doc-title {
            font-size: 30px;
            font-weight: 900;
            color: #0f172a;
            text-transform: uppercase;
            margin: 0;
            letter-spacing: -1px;
            text-align: right;
        }
        .doc-period {
            font-size: 15px;
            font-weight: 800;
            color: #2563eb;
            text-align: right;
            margin-top: 2px;
        }

        
        .info-box {
            background: #f8faff;
            border-radius: 18px;
            padding: 20px 24px;
            margin: 20px;
        }
        
        .info-label {
            font-size: 10px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }
        .info-value {
            font-size: 15px;
            font-weight: 900;
            color: #0f172a;
            margin-top: 2px;
        }
        .info-divider {
            border-left: 1px solid #e2e8f0;
            padding-left: 24px;
        }
        .info-cell { padding-right: 24px; }
        .info-bottom { padding-top: 14px; }

        
        .fin-section { padding: 0 20px; }
        .fin-card { border-radius: 18px; overflow: hidden; }
        .fin-card-blue  { border: 1.5px solid #bfdbfe; }
        .fin-card-orange { border: 1.5px solid #fed7aa; }

        .fin-head { padding: 13px 20px; }
        .fin-head-blue   { background: #eff6ff; }
        .fin-head-orange { background: #fff7ed; }

        .fin-head-title { font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.8px; }
        .fin-head-title-blue   { color: #1d4ed8; }
        .fin-head-title-orange { color: #c2410c; }

        .fin-body { padding: 16px 20px; min-height: 112px; }
        .fin-row td { padding: 7px 0; border-bottom: 1px solid #f1f5f9; font-size: 13px; }
        .fin-row-last td { padding: 7px 0; font-size: 13px; }
        .fin-label  { color: #475569; font-weight: 500; }
        .fin-value  { text-align: right; font-weight: 800; color: #0f172a; }

        .fin-foot { padding: 12px 20px; }
        .fin-foot-blue   { background: #eff6ff; border-top: 1px solid #bfdbfe; }
        .fin-foot-orange { background: #fff7ed; border-top: 1px solid #fed7aa; }

        .fin-total-label { font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.6px; }
        .fin-total-label-blue   { color: #1d4ed8; }
        .fin-total-label-orange { color: #c2410c; }
        .fin-total-value { font-size: 15px; font-weight: 900; text-align: right; }
        .fin-total-value-blue   { color: #2563eb; }
        .fin-total-value-orange { color: #ea580c; }

        
        .banner-total {
            margin: 20px;
            background: #f5f0ff;
            border-radius: 18px;
            padding: 22px 28px;
        }
        .banner-title { font-size: 15px; font-weight: 900; color: #6b21a8; text-transform: uppercase; letter-spacing: 0.8px; }
        .banner-spell { font-size: 12px; color: #64748b; font-style: italic; margin-top: 4px; }
        .banner-amount { font-size: 25px; font-weight: 900; color: #6b21a8; text-align: right; vertical-align: middle; }

       
        .footer-row { padding: 20px 28px 28px; }
        .note-text { font-size: 11px; color: #94a3b8; max-width: 280px; line-height: 1.6; }
        .sig-date    { font-size: 12px; color: #64748b; text-align: right; margin-bottom: 4px; }
        .sig-company { font-size: 12px; font-weight: 900; color: #0f172a; text-transform: uppercase; text-align: right; }
        .sig-name    { font-size: 13px; font-weight: 900; color: #0f172a; text-align: right; }
        .sig-role    { font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; text-align: right; margin-top: 2px; }

    </style>
</head>
<body>

    @php
        $gajiPokok = ($pay->gaji_bersih - $pay->total_tunjangan - $pay->bonus) + $pay->total_potongan;

        function terbilangRupiah($angka) {
            $bilangan = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
            if ($angka == 0) return "Nol Rupiah";
            $text = "";
            if ($angka < 12)         { $text = $bilangan[$angka]; }
            elseif ($angka < 20)     { $text = terbilangRupiah($angka - 10) . " Belas"; }
            elseif ($angka < 100)    { $text = $bilangan[floor($angka/10)] . " Puluh " . $bilangan[$angka%10]; }
            elseif ($angka < 200)    { $text = "Seratus " . terbilangRupiah($angka - 100); }
            elseif ($angka < 1000)   { $text = $bilangan[floor($angka/100)] . " Ratus " . terbilangRupiah($angka%100); }
            elseif ($angka < 2000)   { $text = "Seribu " . terbilangRupiah($angka - 1000); }
            elseif ($angka < 1000000){ $text = terbilangRupiah(floor($angka/1000)) . " Ribu " . terbilangRupiah($angka%1000); }
            elseif ($angka < 1000000000) { $text = terbilangRupiah(floor($angka/1000000)) . " Juta " . terbilangRupiah($angka%1000000); }
            return trim($text);
        }
    @endphp

    <table class="container" style="width:100%;">
        <tr><td>

            {{-- ══ HEADER ══ --}}
            <table class="table-layout header-row" style="padding:0 0 0 0;">
                <tr>
                    <td style="width:60%; vertical-align:middle;">
                        <table class="table-layout">
                            <tr>
                                <td>
                                    <div class="logo-badge">
                                        {{-- Ikon oranye: silang/bintang ala foto --}}
                                        <div class="logo-icon-box" style="display:inline-block; vertical-align:middle;">
                                            <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="7"  cy="7"  r="3.5" fill="white"/>
                                                <circle cx="19" cy="7"  r="3.5" fill="white"/>
                                                <circle cx="7"  cy="19" r="3.5" fill="white"/>
                                                <circle cx="19" cy="19" r="3.5" fill="white"/>
                                                <line x1="4" y1="13" x2="22" y2="13" stroke="#f97316" stroke-width="2.5" stroke-linecap="round"/>
                                                <line x1="13" y1="4"  x2="13" y2="22" stroke="#f97316" stroke-width="2.5" stroke-linecap="round"/>
                                            </svg>
                                        </div>
                                        <span class="logo-text">PAY<span class="orange">TATO</span></span>
                                    </div>
                                </td>
                                <td style="vertical-align:middle;">
                                    <span class="company-title">PT Paytato Solusi Digital</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="text-align:right; vertical-align:middle; padding-right:28px; padding-top:16px; padding-bottom:16px;">
                        <div class="doc-title">Slip Gaji</div>
                        <div class="doc-period">{{ $pay->bulan }}</div>
                    </td>
                </tr>
            </table>

           
            <div class="info-box">
                <table class="table-layout">
                    <tr>
                       
                        <td class="info-cell" style="width:50%;">
                            {{-- Ikon user --}}
                            <div class="info-icon-box">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                     stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     style="display:inline-block; vertical-align:middle;">
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                                </svg>
                            </div>
                            <div class="info-label">Nama Karyawan</div>
                            <div class="info-value">{{ $pay->pegawai->nama_lengkap ?? 'Tidak Diketahui' }}</div>
                        </td>
                       
                        <td class="info-cell info-divider" style="width:50%;">
                            <div class="info-icon-box">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                     stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     style="display:inline-block; vertical-align:middle;">
                                    <rect x="2" y="7" width="20" height="14" rx="2"/>
                                    <path d="M16 7V5a2 2 0 0 0-4 0v2M8 7V5a2 2 0 0 0-4 0v2"/>
                                </svg>
                            </div>
                            <div class="info-label">Jabatan</div>
                            <div class="info-value">{{ $pay->pegawai->jabatan->nama_jabatan ?? '-' }}</div>
                        </td>
                    </tr>
                    <tr>
                     
                        <td class="info-cell info-bottom" style="width:50%;">
                            <div class="info-icon-box">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                     stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     style="display:inline-block; vertical-align:middle;">
                                    <rect x="3" y="4" width="18" height="16" rx="2"/>
                                    <line x1="7" y1="9" x2="17" y2="9"/>
                                    <line x1="7" y1="13" x2="13" y2="13"/>
                                </svg>
                            </div>
                            <div class="info-label">ID Karyawan / NIP</div>
                            <div class="info-value">{{ $pay->nip }}</div>
                        </td>
                        {{-- Periode --}}
                        <td class="info-cell info-divider info-bottom" style="width:50%;">
                            <div class="info-icon-box">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                     stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     style="display:inline-block; vertical-align:middle;">
                                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8"  y1="2" x2="8"  y2="6"/>
                                    <line x1="3"  y1="10" x2="21" y2="10"/>
                                </svg>
                            </div>
                            <div class="info-label">Periode Gaji</div>
                            <div class="info-value">{{ $pay->bulan }}</div>
                        </td>
                    </tr>
                </table>
            </div>

            
            <table class="table-layout fin-section" style="margin-top:0; padding-bottom:0;">
                <tr>
                    {{-- Penghasilan --}}
                    <td style="width:48%;">
                        <div class="fin-card fin-card-blue">
                            <div class="fin-head fin-head-blue">
                                <div class="fin-head-title fin-head-title-blue">Penghasilan</div>
                            </div>
                            <div class="fin-body">
                                <table class="table-layout">
                                    <tr class="fin-row">
                                        <td class="fin-label">Gaji Pokok</td>
                                        <td class="fin-value">Rp {{ number_format($gajiPokok, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="fin-row">
                                        <td class="fin-label">Tunjangan Jabatan</td>
                                        <td class="fin-value">Rp {{ number_format($pay->total_tunjangan, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="fin-row-last">
                                        <td class="fin-label">Bonus Target / Kerja</td>
                                        <td class="fin-value">Rp {{ number_format($pay->bonus, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="fin-foot fin-foot-blue">
                                <table class="table-layout">
                                    <tr>
                                        <td class="fin-total-label fin-total-label-blue">Total Penghasilan</td>
                                        <td class="fin-total-value fin-total-value-blue">
                                            Rp {{ number_format($gajiPokok + $pay->total_tunjangan + $pay->bonus, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>

                    <td style="width:4%;"></td>

                   
                    <td style="width:48%;">
                        <div class="fin-card fin-card-orange">
                            <div class="fin-head fin-head-orange">
                                <div class="fin-head-title fin-head-title-orange">Potongan</div>
                            </div>
                            <div class="fin-body">
                                <table class="table-layout">
                                    <tr class="fin-row">
                                        <td class="fin-label">
                                            Alpha ({{ $alpha }}x)
                                        </td>
                                        <td class="fin-value">
                                            Rp {{ number_format($potonganAlpha,0,',','.') }}
                                        </td>
                                    </tr>
                                    <tr class="fin-row">
                                        <td class="fin-label">
                                            Terlambat ({{ $telat }}x)
                                        </td>
                                        <td class="fin-value">
                                            Rp {{ number_format($potonganTerlambat,0,',','.') }}
                                        </td>
                                    </tr>
                                    <tr class="fin-row-last">
                                        <td class="fin-label">
                                            PPh21
                                        </td>
                                        <td class="fin-value">
                                            Rp {{ number_format($potonganPph21,0,',','.') }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="fin-foot fin-foot-orange">
                                <table class="table-layout">
                                    <tr>
                                        <td class="fin-total-label fin-total-label-orange">Total Potongan</td>
                                        <td class="fin-total-value fin-total-value-orange">
                                            Rp {{ number_format($pay->total_potongan, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

           
            <div class="banner-total">
                <table class="table-layout">
                    <tr>
                        <td style="vertical-align:middle;">
                            <div class="banner-title">Gaji Bersih Diterima</div>
                        </td>
                        <td class="banner-amount">
                            Rp {{ number_format($pay->gaji_bersih, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="banner-spell">{{ terbilangRupiah($pay->gaji_bersih) }} Rupiah</div>
                        </td>
                    </tr>
                </table>
            </div>

           
            <table class="table-layout footer-row">
                <tr>
                    <td style="width:55%; vertical-align:bottom;">
                        <div class="note-text">
                            Slip gaji ini adalah dokumen resmi dan dibuat secara otomatis oleh sistem PayTato.
                        </div>
                    </td>
                    <td style="width:45%; text-align:right;">
                        <div class="sig-date">Medan, {{ now()->translatedFormat('d F Y') }}</div>
                        <div class="sig-company">PT Paytato Solusi Digital</div>
                        <div style="text-align:right; padding: 6px 0; margin-bottom: 55px;">
                            <svg width="120" height="50" viewBox="0 0 100 50" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 35 C 25 10, 30 45, 45 20 C 55 5, 60 40, 75 25 C 80 20, 85 15, 95 20 M20 25 L85 30"
                                      fill="none" stroke="#0f172a" stroke-width="1.5"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="sig-name">Zerlina Adelide Aqila</div>
                        <div class="sig-role">Manager</div>
                    </td>
                </tr>
            </table>
        </td></tr>
    </table>
</body>
</html>
