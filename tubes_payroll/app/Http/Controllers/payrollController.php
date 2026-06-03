<?php

namespace App\Http\Controllers;

use App\Models\Penggajian; 
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollController extends Controller
{
    /**
     * INDIVIDU: Menampilkan data payroll/slip gaji milik masing-masing karyawan yang login
     */
    public function dataPayroll()
    {
        $userId = auth()->id(); 
        
        // Mengambil data pengguna beserta relasi departemennya
        $user = Pengguna::with(['divisi'])->find($userId);

        $bulanSekarang = date('m'); 
        $periodeSekarang = date('F Y'); 

        // Menampilkan draf/slip bulan terbaru milik pengguna tersebut berdasarkan id_pegawai
        $bulanTerbaru = Penggajian::where('id_pegawai', $userId)
                                    ->where('bulan', $bulanSekarang)
                                    ->first();
                                    
        // Riwayat seluruh penggajian bulan-bulan lalu milik karyawan terkait
        $bulanLalu = Penggajian::where('id_pegawai', $userId)
                                ->orderBy('id', 'desc')
                                ->get();
                                        
        return view('halaman.payroll', compact('bulanTerbaru', 'bulanLalu', 'user'));
    }

    /**
     * FINANCE & MANAGEMENT: Dashboard utama kelola manajemen gaji seluruh karyawan (Meja Kerja)
     */
    public function manage(Request $request)
    {
        $query = Penggajian::with('pegawai');

        // Filter Nama
        if ($request->filled('nama')) {
            $query->whereHas('pegawai', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        // Filter NIP
        if ($request->filled('nip')) {
            $query->where('nip', 'like', '%' . $request->nip . '%');
        }

        // Filter Tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('periode_mulai', $request->tanggal);
        }

        // Filter Bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('periode_mulai', $request->bulan);
        }

        // Filter Tahun
        if ($request->filled('tahun')) {
            $query->whereYear('periode_mulai', $request->tahun);
        }

        $riwayatGaji = $query
            ->orderBy('id', 'desc')
            ->paginate(7)
            ->withQueryString();

        $karyawan = Pengguna::all();

        $totalPengeluaran = Penggajian::where('status_bayar', 'Dibayar')
            ->sum('gaji_bersih');

        $draft = Penggajian::where('status_bayar', 'Draft')->count();
        $terbit = Penggajian::where('status_bayar', 'Terbit')->count();
        $dibayar = Penggajian::where('status_bayar', 'Dibayar')->count();

        $totalPayroll = $draft + $terbit + $dibayar;

        $progressPayroll = $totalPayroll > 0
            ? round(($dibayar / $totalPayroll) * 100)
            : 0;

        return view('halaman.manage', [
            'riwayatGaji'      => $riwayatGaji,
            'karyawan'         => $karyawan,
            'totalPengeluaran' => $totalPengeluaran,
            'totalPegawai'     => $karyawan->count(),

            'draft'            => $draft,
            'terbit'           => $terbit,
            'dibayar'          => $dibayar,
            'progressPayroll'  => $progressPayroll,
        ]);
    }

    /**
     * FINANCE: Otomatisasi generate draf hitungan payroll awal (Status: Draft)
     */
    public function generateGaji(Request $request)
    {
        $request->validate([
            'nip'   => 'required|exists:pengguna,nip',
            'bulan' => 'required|string', 
        ]);

        $periodeInput = $request->bulan; // Menerima format "MM-YYYY" (Contoh: "05-2026")
        
        // Memecah string rekap untuk memisahkan bulan dan tahun agar format SQL datetime valid
        $pecahPeriode  = explode('-', $periodeInput);
        $bulanInput    = $pecahPeriode[0]; 
        $tahunSekarang = $pecahPeriode[1]; 

        $periodeDipilih = strtotime($tahunSekarang . '-' . $bulanInput . '-01');
        $periodeSaatIni = strtotime(date('Y-m-01'));

        if ($periodeDipilih < $periodeSaatIni) {
            return back()->with(
                'error',
                'Tidak dapat membuat draft payroll untuk periode yang sudah lewat.'
            );
        }

        // 1. Ambil data pengguna murni berdasarkan NIP
        $karyawan = DB::table('pengguna')->where('nip', $request->nip)->first();
        if (!$karyawan) {
            return redirect()->back()->with('error', 'Karyawan tidak ditemukan.');
        }

        // 2. Tarik data dari tabel profil_pegawai menggunakan NIP
        $profil = DB::table('profil_pegawai')->where('nip', $karyawan->nip)->first();
        $statusKerja = $profil ? $profil->status_kerja : 'Tetap';

        $periodeMulai = $tahunSekarang . '-' . $bulanInput . '-01';
        $periodeSelesai = date('Y-m-t', strtotime($periodeMulai));

        // JIKA STATUSNYA PKL, LANGSUNG SET SEMUA NOMINAL KE 0 DAN SIMPAN
        if (strtoupper($statusKerja) === 'PKL') {
            Penggajian::create([
                'id_pegawai'       => $karyawan->id,
                'nip'              => $karyawan->nip,
                'gaji_pokok'       => 0,
                'periode_mulai'    => $periodeMulai,
                'periode_selesai'  => $periodeSelesai,
                'total_tunjangan'  => 0,
                'total_potongan'   => 0,
                'bonus'            => 0,
                'gaji_bersih'      => 0,
                'status_bayar'     => 'Draft',
                'bulan'            => $periodeInput, 
            ]);

            return redirect()->back()->with('success', 'Draf payroll anak PKL berhasil dibuat dengan nominal Rp 0.');
        }

        // 3. ALUR BERANTAI JABATAN & GAJI:
        // a. Ambil id_jabatan dari tabel profil_pegawai
        $idJabatan = $profil ? $profil->id_jabatan : null;

        // b. Cari ke tabel jabatan berdasarkan id_jabatan untuk mengambil id_gaji
        $jabatan = DB::table('jabatan')->where('id', $idJabatan)->first();
        $idGaji = $jabatan ? $jabatan->id_gaji : null;

        // c. Cari ke master tabel gaji berdasarkan id_gaji untuk mendapatkan nilai pokok
        $gajiMaster = DB::table('gaji')->where('id', $idGaji)->first();
        $gapok = $gajiMaster ? $gajiMaster->gaji : 0;

        // 4. Hitung otomatis tunjangan (15% dari Gaji Pokok master jabatan)
        $tunjangan = 0.15 * $gapok;

        // ==========================================
        // HITUNG LOG ABSENSI MENTAH BULANAN
        // ==========================================
        $alpha = DB::table('absensi')
            ->where('nip', $karyawan->nip)
            ->whereMonth('tanggal', $bulanInput)
            ->whereYear('tanggal', $tahunSekarang)
            ->where('status_kehadiran', 'Alpha')
            ->count();

        $telat = DB::table('absensi')
            ->where('nip', $karyawan->nip)
            ->whereMonth('tanggal', $bulanInput)
            ->whereYear('tanggal', $tahunSekarang)
            ->where('status_kehadiran', 'Terlambat')
            ->count();

        $hariHadir = DB::table('absensi')
            ->where('nip', $karyawan->nip)
            ->whereMonth('tanggal', $bulanInput)
            ->whereYear('tanggal', $tahunSekarang)
            ->where('status_kehadiran', 'Hadir')
            ->count();

        // ==========================================
        // KALKULASI DEBIT / KREDIT PAYROLL
        // ==========================================
        
        // Potongan harian alpha
        $potonganAlpha = ($gapok / 30) * $alpha;

        $dendaPerTelat = (strtoupper($statusKerja) === 'TETAP') ? 50000 : 15000;
        $potonganTerlambat = $dendaPerTelat * $telat;

        $bonusTarget = 0;
        if ($hariHadir >= 5) {
            $kelipatan = floor($hariHadir / 5);
            $bonusTarget = $kelipatan * 35000;
        }

        $pendapatanKotorSebulan = $gapok + $tunjangan + $bonusTarget;
        $pendapatanKotorSetahun = $pendapatanKotorSebulan * 12;

        // Biaya jabatan (5% max 500rb/bulan)
        $biayaJabatan = min($pendapatanKotorSebulan * 0.05, 500000) * 12;

        // Penghasilan neto
        $penghasilanNeto = $pendapatanKotorSetahun - $biayaJabatan;

        // PTKP (TK/0)
        $ptkp = 54000000;

        // PKP
        $pkp = max(0, $penghasilanNeto - $ptkp);

        // Pajak progresif
        $pph21Setahun = $this->hitungPph21Progresif($pkp);
        $potonganPph21 = round($pph21Setahun / 12);

        // Akumulasi total potongan
        $totalPotongan = $potonganAlpha + $potonganTerlambat + $potonganPph21;

        // Hitung akhir Gaji Bersih
        $gajiBersih = ($gapok + $tunjangan + $bonusTarget) - $totalPotongan;

        // 5. Masukkan ke database penggajian
        Penggajian::create([
            'id_pegawai'       => $karyawan->id,
            'nip'              => $karyawan->nip,
            'gaji_pokok'       => $gapok,
            'periode_mulai'    => $periodeMulai,
            'periode_selesai'  => $periodeSelesai,
            'total_tunjangan'  => $tunjangan,
            'total_potongan'   => $totalPotongan,
            'bonus'            => $bonusTarget,
            'gaji_bersih'      => $gajiBersih,
            'status_bayar'     => 'Draft',
            'bulan'            => $periodeInput, 
        ]);

        return redirect()->back()->with('success', 'Draf payroll berhasil dibuat murni menggunakan NIP!');
    }

    /**
     * FINANCE: Update komponen draf selama proses pengerjaan (sebelum submit final)
     */
    public function updateDraft(Request $request, $id)
    {
        $request->validate([
            'total_tunjangan' => 'required|numeric|min:0',
            'bonus'           => 'required|numeric|min:0',
            'total_potongan'  => 'required|numeric|min:0',
        ]);

        $gaji = Penggajian::find($id);

        if (!$gaji) {
            return back()->with('error', 'Data payroll tidak ditemukan.');
        }

        if (!in_array($gaji->status_bayar, ['Draft', 'Ditolak'])) {
            return back()->with('error', 'Data payroll tidak dapat diedit.');
        }

        $gapok = $gaji->gaji_pokok;

        $gajiBersihBaru =
            ($gapok + $request->total_tunjangan + $request->bonus)
            - $request->total_potongan;

        $gaji->update([
            'total_tunjangan' => $request->total_tunjangan,
            'bonus'           => $request->bonus,
            'total_potongan'  => $request->total_potongan,
            'gaji_bersih'     => $gajiBersihBaru,
        ]);

        return back()->with('success', 'Draft payroll berhasil diperbarui.');
    }

    /**
     * FINANCE: Menghapus data draf payroll milik karyawan berdasarkan ID Gaji yang Unik
     */
    public function destroyDraft($id)
    {
        $gaji = Penggajian::find($id);

        if (!$gaji) {
            return back()->with('error', 'Data tidak ditemukan.');
        }

        if ($gaji->status_bayar !== 'Draft') {
            return back()->with('error', 'Status bukan Draft.');
        }

        $gaji->delete();

        return back()->with('success', 'Draft berhasil dihapus.');
    }

    /**
     * FINANCE: Mengirim draf ke pihak Manajemen (Status: Draft -> Terbit)
     */
    public function submitGaji(Request $request, $id)
    {
        $payroll = Penggajian::find($id);
        
        if (!$payroll) {
            return redirect()->back()->with('error', 'Data draf payroll dengan NIP tersebut tidak ditemukan.');
        }

        $payroll->update([
            'status_bayar' => 'Terbit'
        ]);

        return redirect()->back()->with('success', 'Draf payroll berhasil diajukan ke Manajer!');
    }

    /**
     * MANAGEMENT: Menolak atau Menyetujui Berkas Gaji Satuan (Status: Terbit -> Dibayar / Ditolak)
     */
    public function keputusanManajemen(Request $request, $id)
    {
        $request->validate([
            'aksi' => 'required|in:approve,reject'
        ]);

        $gaji = Penggajian::findOrFail($id);

        if ($gaji->status_bayar !== 'Terbit') {
            return redirect()->back()->with('error', 'Berkas tidak dalam status menunggu persetujuan.');
        }

        $statusBaru = ($request->aksi === 'approve') ? 'Dibayar' : 'Ditolak';
        $gaji->update(['status_bayar' => $statusBaru]);

        return redirect()->back()->with('success', "Berkas payroll berhasil diperbarui menjadi: $statusBaru.");
    }

    /**
     * MANAGEMENT: Menyetujui banyak data sekaligus (Mass Approval & Selected Approval)
     */
    public function massAction(Request $request)
    {
        // MASS APPROVE
        if ($request->action === 'approve_all') {

            $jumlah = Penggajian::where('status_bayar', 'Terbit')
                ->update([
                    'status_bayar' => 'Dibayar'
                ]);

            return back()->with(
                'success',
                "$jumlah data payroll berhasil disetujui."
            );
        }

        // MASS REJECT
        if ($request->action === 'reject_all') {

            $jumlah = Penggajian::where('status_bayar', 'Terbit')
                ->update([
                    'status_bayar' => 'Ditolak'
                ]);

            return back()->with(
                'success',
                "$jumlah data payroll berhasil ditolak."
            );
        }

        // SELECTED ACTION
        $request->validate([
            'action' => 'required|in:approve,reject',
            'ids' => 'required|array',
            'ids.*' => 'exists:penggajian,id'
        ]);

        $statusBaru = $request->action === 'approve'
            ? 'Dibayar'
            : 'Ditolak';

        $jumlah = Penggajian::whereIn('id', $request->ids)
            ->where('status_bayar', 'Terbit')
            ->update([
                'status_bayar' => $statusBaru
            ]);

        return back()->with(
            'success',
            "$jumlah data payroll berhasil " .
            ($request->action === 'approve'
                ? 'disetujui'
                : 'ditolak')
            . '.'
        );
    }

    /**
     * Rumus kalkulasi tarif progresif PPh21 Pasal 17
     */
    private function hitungPph21Progresif($penghasilanSetahun)
    {
        $pajakTotal = 0;
        $sisa = $penghasilanSetahun;

        // Lapisan 1: 0 - 60 juta (5%)
        $lapisan1 = min($sisa, 60000000);
        $pajakTotal += $lapisan1 * 0.05;
        $sisa -= $lapisan1;

        // Lapisan 2: 60 - 250 juta (15%)
        if ($sisa > 0) {
            $lapisan2 = min($sisa, 190000000); // 250jt - 60jt
            $pajakTotal += $lapisan2 * 0.15;
            $sisa -= $lapisan2;
        }

        // Lapisan 3: 250 - 500 juta (25%)
        if ($sisa > 0) {
            $lapisan3 = min($sisa, 250000000); // 500jt - 250jt
            $pajakTotal += $lapisan3 * 0.25;
            $sisa -= $lapisan3;
        }

        // Lapisan 4: > 500 juta (30%)
        if ($sisa > 0) {
            $pajakTotal += $sisa * 0.30;
        }

        return $pajakTotal;
    }

    public function downloadSlip($id)
    {
        $pay = Penggajian::with(['pegawai.jabatan'])->findOrFail($id);

        // VALIDASI
        if ($pay->nip !== auth()->user()->nip) {
            abort(403, 'Akses ditolak');
        }

        $bulan = date('m', strtotime($pay->periode_mulai));
        $tahun = date('Y', strtotime($pay->periode_mulai));

        $profil = DB::table('profil_pegawai')
            ->where('nip', $pay->nip)
            ->first();

        $statusKerja = $profil ? $profil->status_kerja : 'Tetap';

        $alpha = DB::table('absensi')
            ->where('nip', $pay->nip)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status_kehadiran', 'Alpha')
            ->count();

        $telat = DB::table('absensi')
            ->where('nip', $pay->nip)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status_kehadiran', 'Terlambat')
            ->count();

        $potonganAlpha = ($pay->gaji_pokok / 30) * $alpha;

        $dendaPerTelat = ($statusKerja === 'Tetap')
            ? 50000
            : 15000;

        $potonganTerlambat = $dendaPerTelat * $telat;

        $potonganPph21 =
            $pay->total_potongan
            - $potonganAlpha
            - $potonganTerlambat;

        $pdf = Pdf::loadView(
            'ekspor_pdf.slip_gaji_pdf',
            compact(
                'pay',
                'potonganAlpha',
                'potonganTerlambat',
                'potonganPph21',
                'alpha',
                'telat'
            )
        );

        return $pdf->download(
            'Slip-Gaji-' . $pay->bulan . '.pdf'
        );
    }
}