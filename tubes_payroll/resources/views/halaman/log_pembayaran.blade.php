@extends('layouts.app')
@section('title', 'Log Pembayaran Gaji')
@section('content')


<header class="mb-10">
    <p class="text-[10px] font-black text-orange-500 uppercase tracking-[0.3em] mb-1">HRD · Payroll</p>
    <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tighter">Log Pembayaran Gaji</h1>
    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Riwayat transaksi pembayaran oleh Finance</p>
</header>

{{-- FILTER BULAN & TAHUN --}}
<form method="GET" action="{{ route('payroll.log') }}" class="flex flex-wrap gap-3 mb-8">
    <select name="bulan" class="text-[11px] font-black uppercase tracking-widest bg-white border border-slate-200 rounded-2xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400">
        @foreach(range(1, 12) as $m)
            <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
            </option>
        @endforeach
    </select>

    <select name="tahun" class="text-[11px] font-black uppercase tracking-widest bg-white border border-slate-200 rounded-2xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400">
        @foreach(range(date('Y'), date('Y') - 3, -1) as $y)
            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
        @endforeach
    </select>

    <button type="submit" class="bg-orange-500 text-white text-[11px] font-black uppercase tracking-widest px-6 py-3 rounded-2xl hover:bg-orange-600 transition-all">
        <i class="fas fa-filter mr-1"></i> Filter
    </button>
</form>

<div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-100">
                <th class="text-left px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Karyawan</th>
                <th class="text-left px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">NIP</th>
                <th class="text-left px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Periode</th>
                <th class="text-left px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Dibayar Oleh</th>
                <th class="text-left px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu Pembayaran</th>
                <th class="text-left px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Gaji Bersih</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($log as $item)
            @php
                $dibayarPada = $item->dibayar_pada 
                    ? \Carbon\Carbon::parse($item->dibayar_pada) 
                    : null;
            @endphp
            <tr class="hover:bg-slate-50 transition-colors">
                {{-- Nama --}}
                <td class="px-8 py-5">
                    <p class="font-black text-slate-900 uppercase tracking-tight text-sm">
                        {{ $item->pegawai->nama_lengkap ?? '-' }}
                    </p>
                </td>
                {{-- NIP --}}
                <td class="px-6 py-5">
                    <span class="text-[11px] font-black text-slate-500 bg-slate-100 px-3 py-1 rounded-lg">
                        {{ $item->nip }}
                    </span>
                </td>
                {{-- Periode --}}
                <td class="px-6 py-5">
                    <p class="text-[11px] font-bold text-slate-600 uppercase">{{ $item->bulan }}</p>
                </td>
                {{-- Dibayar oleh --}}
                <td class="px-6 py-5">
                    <p class="text-[11px] font-black text-orange-600 uppercase">
                        {{ $item->dibayar_oleh ?? '-' }}
                    </p>
                </td>
                {{-- Waktu --}}
                <td class="px-6 py-5">
                    @if($dibayarPada)
                    <p class="text-[13px] font-black text-slate-900">
                        {{ $dibayarPada->format('H:i:s') }}
                    </p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mt-0.5">
                        {{ $dibayarPada->translatedFormat('d F Y') }}
                    </p>
                    @else
                    <span class="text-slate-300 text-xs">—</span>
                    @endif
                </td>
                {{-- Nominal --}}
                <td class="px-6 py-5">
                    <p class="font-black text-slate-900">
                        Rp {{ number_format($item->gaji_bersih, 0, ',', '.') }}
                    </p>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-8 py-16 text-center text-slate-400 text-sm font-bold uppercase tracking-widest">
                    Belum ada data pembayaran
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    @if($log->hasPages())
    <div class="px-8 py-5 border-t border-slate-100">
        {{ $log->links() }}
    </div>
    @endif
</div>

@endsection