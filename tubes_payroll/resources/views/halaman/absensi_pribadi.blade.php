@extends('layouts.app')

@section('title', 'PayTato | Rekap Absensi Pribadi')

@push('loading')

<div class="space-y-6 animate-pulse">

    <div class="h-10 w-72 skeleton rounded-2xl"></div>

    <div class="h-32 skeleton rounded-[35px]"></div>

    <div class="bg-slate-900 rounded-[35px] p-6 space-y-4">

        @for($i = 0; $i < 8; $i++)

        <div class="grid grid-cols-7 gap-4">

            <div class="h-10 skeleton rounded-xl"></div>
            <div class="h-10 skeleton rounded-xl"></div>
            <div class="h-10 skeleton rounded-xl"></div>
            <div class="h-10 skeleton rounded-xl"></div>
            <div class="h-10 skeleton rounded-xl"></div>
            <div class="h-10 skeleton rounded-xl"></div>
            <div class="h-10 skeleton rounded-xl"></div>

        </div>

        @endfor

    </div>

</div>

@endpush

@section('content')
<div class="max-w-6xl mx-auto bg-white p-8 md:p-12 rounded-[30px] border border-slate-100 shadow-sm relative overflow-hidden">
    
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-6">
        <div>
            <h2 class="text-2xl md:text-3xl font-black text-slate-900 uppercase tracking-tight">
                Rekap Absensi Individu Karyawan
            </h2>
            <p class="text-sm font-bold text-orange-500 uppercase mt-1">
                Periode {{ $periodeCarbon->translatedFormat('F Y') }}
            </p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto justify-start lg:justify-end">
            
            <form action="{{ route('absensi.pribadi') }}" method="GET" class="flex items-center gap-2 bg-slate-50 p-1.5 rounded-xl border border-slate-100">
                <select name="bulan" onchange="this.form.submit()" class="bg-white border-0 text-xs font-bold text-slate-700 px-3 py-2 rounded-lg focus:ring-2 focus:ring-orange-500 shadow-sm cursor-pointer uppercase">
                    @for ($m=1; $m<=12; $m++)
                        <option value="{{ sprintf('%02d', $m) }}" {{ $bulanPilihan == sprintf('%02d', $m) ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>

                <select name="tahun" onchange="this.form.submit()" class="bg-white border-0 text-xs font-bold text-slate-700 px-3 py-2 rounded-lg focus:ring-2 focus:ring-orange-500 shadow-sm cursor-pointer">
                    @for ($y = date('Y'); $y >= date('Y')-3; $y--)
                        <option value="{{ $y }}" {{ $tahunPilihan == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </form>

            <a href="{{ route('absensi.pribadi.pdf', ['bulan' => $bulanPilihan, 'tahun' => $tahunPilihan]) }}" 
               class="flex items-center gap-2.5 px-5 py-2.5 bg-slate-900 hover:bg-orange-600 text-white rounded-xl text-xs font-black uppercase tracking-wider transition-all duration-300 shadow-sm hover:shadow-orange-500/20 group">
                <i class="fas fa-file-pdf text-sm text-orange-500 group-hover:text-white transition-colors"></i>
                Cetak Rekap (PDF)
            </a>

            <!-- <div class="flex items-center gap-2 bg-green-50 px-4 py-2.5 rounded-xl border border-green-100 hidden sm:flex">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <p class="text-[10px] font-black text-green-700 uppercase tracking-wider">Online</p>
            </div> -->
        </div>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-slate-50/60 p-6 rounded-2xl border border-slate-100/80 mb-8 gap-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 font-black text-lg border border-orange-200 shadow-sm">
                {{ strtoupper(substr($user->nama, 0, 2)) }}
            </div>
            <div>
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight mb-1">
                    {{ $user->nama }}
                </h3>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                        NIP. {{ $user->nip ?? '-' }}
                    </span>
                    <span class="text-[10px] font-black text-slate-500 uppercase bg-slate-200 px-2 py-0.5 rounded-md tracking-wide">
                        {{ $namaJabatan }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="flex items-center gap-3.5 bg-white p-3.5 px-5 rounded-xl border border-slate-100 shadow-sm w-full md:w-auto">
            <div class="w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center text-red-500 border border-red-100">
                <i class="far fa-calendar-alt text-base"></i>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Periode Absensi</p>
                <p class="text-xs font-black text-slate-800 tracking-tight">
                    1 - {{ $periodeCarbon->endOfMonth()->translatedFormat('d F Y') }}
                </p>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap gap-4 md:gap-6 border-b border-slate-100 pb-6 mb-6 text-[11px] font-bold uppercase tracking-wider text-slate-600">
        <div class="flex items-center gap-2"><span class="w-5 h-5 rounded-md bg-green-500 text-white flex items-center justify-center text-[9px] font-black">H</span> Hadir</div>
        <div class="flex items-center gap-2"><span class="w-5 h-5 rounded-md bg-orange-500 text-white flex items-center justify-center text-[9px] font-black">TL</span> Terlambat</div>
        <div class="flex items-center gap-2"><span class="w-5 h-5 rounded-md bg-blue-500 text-white flex items-center justify-center text-[9px] font-black">I</span> Izin</div>
        <div class="flex items-center gap-2"><span class="w-5 h-5 rounded-md bg-purple-500 text-white flex items-center justify-center text-[9px] font-black">S</span> Sakit</div>
        <div class="flex items-center gap-2"><span class="w-5 h-5 rounded-md bg-red-500 text-white flex items-center justify-center text-[9px] font-black">A</span> Alpha (Tidak Hadir)</div>
        <div class="flex items-center gap-2"><span class="w-5 h-5 rounded-md bg-slate-200 text-slate-400 flex items-center justify-center text-[9px] font-black">-</span> Libur / Tidak Ada Jadwal</div>
    </div>

    <div class="overflow-x-auto rounded-xl border border-slate-100">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-wider border-b border-slate-100">
                    <th class="py-4 px-4 text-center w-12">No</th>
                    <th class="py-4 px-4">Tanggal</th>
                    <th class="py-4 px-4">Hari</th>
                    <th class="py-4 px-4">Jam Datang</th>
                    <th class="py-4 px-4">Jam Keluar</th>
                    <th class="py-4 px-4 text-center w-20">Status</th>
                    <th class="py-4 px-4">Keterangan</th>
                </tr>
            </thead>
            <tbody class="text-xs font-bold text-slate-700 divide-y divide-slate-100/70">
               @forelse($dataAbsensi as $index => $absensi)

    @php
        $statusUpper = strtoupper($absensi->status_kehadiran);

        $badgeClass = 'bg-slate-200 text-slate-400';
        $statusInisial = '-';

        if ($statusUpper == 'HADIR') {
            $badgeClass = 'bg-green-500 text-white';
            $statusInisial = 'H';

        } elseif ($statusUpper == 'TERLAMBAT') {
            $badgeClass = 'bg-orange-500 text-white';
            $statusInisial = 'TL';

        } elseif ($statusUpper == 'IZIN') {
            $badgeClass = 'bg-blue-500 text-white';
            $statusInisial = 'I';

        } elseif ($statusUpper == 'SAKIT') {
            $badgeClass = 'bg-purple-500 text-white';
            $statusInisial = 'S';

        } elseif ($statusUpper == 'ALPHA') {
            $badgeClass = 'bg-red-500 text-white';
            $statusInisial = 'A';
        }
    @endphp

    <tr class="hover:bg-slate-50/40 transition-colors">

        <td class="py-3.5 px-4 text-center text-slate-400 font-normal">
            {{ $index + 1 }}
        </td>

        <td class="py-3.5 px-4 text-slate-600">
            {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d/m/Y') }}
        </td>

        <td class="py-3.5 px-4 text-slate-800">
            {{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('l') }}
        </td>

        <td class="py-3.5 px-4 text-slate-900 font-mono">
            {{ $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') : '-' }}
        </td>

        <td class="py-3.5 px-4 text-slate-900 font-mono">
            {{ $absensi->jam_keluar ? \Carbon\Carbon::parse($absensi->jam_keluar)->format('H:i') : '-' }}
        </td>

        <td class="py-3.5 px-4 text-center">
            <span class="w-6 h-6 rounded-md inline-flex items-center justify-center text-[10px] font-black {{ $badgeClass }}">
                {{ $statusInisial }}
            </span>
        </td>

        <td class="py-3.5 px-4 text-slate-500">
            @if($absensi->status_kehadiran == 'Terlambat')
    Terlambat {{ $absensi->menit_terlambat }} menit
@else
    {{ $absensi->status_kehadiran }}
@endif
        </td>

    </tr>

@empty
                    <tr>
                        <td colspan="7" class="py-12 px-4 text-center text-slate-400 uppercase tracking-widest font-black text-[10px]">
                            Belum ada riwayat absensi di bulan ini
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- <div class="mt-12 text-center opacity-40">
        <p class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-500">
            © {{ date('Y') }} PAYTATO PAY SYSTEM
        </p>
    </div> -->
</div>
@endsection