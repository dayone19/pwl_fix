@extends('layouts.app')

@section('title', 'Rincian Payroll | PayTato')

@push('loading')
<div class="space-y-8 animate-pulse">
    {{-- Header Skeleton --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 skeleton rounded-2xl"></div>
            <div class="space-y-2">
                <div class="h-6 w-48 skeleton rounded-xl"></div>
                <div class="h-3 w-32 skeleton rounded-lg"></div>
            </div>
        </div>
        <div class="h-11 w-40 skeleton rounded-xl"></div>
    </div>

    {{-- Card Skeleton Group --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @for($i = 0; $i < 4; $i++)
        <div class="bg-white rounded-[28px] border border-slate-100 p-6 space-y-4">
            <div class="flex justify-between items-start">
                <div class="space-y-2">
                    <div class="h-5 w-28 skeleton rounded-lg"></div>
                    <div class="h-3 w-36 skeleton rounded-md"></div>
                </div>
                <div class="h-6 w-16 skeleton rounded-full"></div>
            </div>
            <div class="h-16 skeleton rounded-2xl"></div>
            <div class="space-y-2">
                <div class="h-4 w-full skeleton rounded-md"></div>
                <div class="h-4 w-full skeleton rounded-md"></div>
            </div>
        </div>
        @endfor
    </div>
</div>
@endpush

@section('content')
<div class="w-full min-w-0 space-y-8 px-1">
    
    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-6">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 bg-slate-900 rounded-2xl flex items-center justify-center text-orange-500 shadow-md transform transition group-hover:rotate-6">
                <i class="fas fa-wallet text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-950 uppercase tracking-tighter leading-none">Individu Payroll</h1>
                <p class="text-orange-600 text-[10px] font-black uppercase tracking-[0.25em] mt-1">Data Gaji Kru per Personel</p>
            </div>
        </div>                 
    </div>

    {{-- Grid Cards Payroll --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($bulanLalu as $pay)
        <div class="bg-white border border-slate-200/80 rounded-[28px] overflow-hidden hover:border-blue-400 hover:shadow-xl hover:shadow-blue-900/5 transition-all duration-300 flex flex-col justify-between group">
            
            {{-- Bagian Atas: Metadata & Status --}}
            <div class="p-6 pb-4">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        {{-- AKSEN OREN: Menyoroti teks bulan rekap berjalan --}}
                        <h3 class="text-base font-black text-orange-600 uppercase tracking-tight group-hover:scale-105 origin-left transition-transform">
                            {{ $pay->bulan }}
                        </h3>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">
                            NIP. {{ $pay->nip }} • <span class="text-slate-500 font-medium lowercase first-letter:uppercase">{{ $pay->pegawai->divisi->nama_divisi ?? 'Staff' }}</span>
                        </p>
                    </div>

                    <a href="{{ route('payroll.slip', $pay->id) }}"
                    title="Download Slip Gaji"
                    class="w-10 h-10 rounded-xl bg-white border border-blue-100 flex items-center justify-center text-blue-600 shadow-sm hover:bg-blue-600 hover:text-white transition-all">
                        <i class="fas fa-receipt text-xl"></i>
                    </a>
                </div>
            </div>

            {{-- Bagian Tengah: Informasi Gaji Bersih --}}
            <div class="mx-6 p-4 bg-gradient-to-br from-blue-50/50 to-indigo-50/20 rounded-2xl border border-blue-50/80 flex items-center justify-between">
                <div>
                    <p class="text-[9px] font-black text-blue-500/80 uppercase tracking-widest">
                        Gaji Bersih Diterima
                    </p>
                    <h2 class="text-xl font-black text-slate-950 mt-0.5 tracking-tight">
                        Rp {{ number_format($pay->gaji_bersih, 0, ',', '.') }}
                    </h2>
                </div>
                @php
                    $status = strtolower($pay->status_bayar);
                    $statusClasses = [
                        'dibayar' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                        'ditolak' => 'bg-rose-50 text-rose-700 border-rose-100',
                    ];
                    $currentClass = $statusClasses[$status] ?? 'bg-amber-50 text-amber-700 border-amber-100';
                @endphp
                <span class="px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-wider border {{ $currentClass }}">
                        {{ $pay->status_bayar }}
                </span>
            </div>

            {{-- Bagian Bawah: Rincian Runtutan Dana --}}
            <div class="p-6 pt-4 space-y-2.5 text-xs">
                <div class="flex justify-between items-center py-1.5 border-b border-slate-50">
                    <span class="font-medium text-slate-400 uppercase text-[10px] tracking-wider">Periode Mulai</span>
                    {{-- AKSEN BIRU: Label tag tanggal --}}
                    <span class="font-bold text-blue-700 bg-blue-50/60 border border-blue-100 px-2 py-0.5 rounded-md text-[10px] uppercase">
                        {{ date('d M Y', strtotime($pay->periode_mulai)) }}
                    </span>
                </div>

                <div class="flex justify-between items-center py-1.5 border-b border-slate-50">
                    <span class="font-medium text-slate-400 uppercase text-[10px] tracking-wider">Tunjangan & Bonus</span>
                    <span class="font-bold text-emerald-600">
                        + Rp {{ number_format($pay->total_tunjangan + $pay->bonus, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex justify-between items-center py-1.5">
                    <span class="font-medium text-slate-400 uppercase text-[10px] tracking-wider">Total Potongan</span>
                    <span class="font-bold text-rose-600">
                        - Rp {{ number_format($pay->total_potongan, 0, ',', '.') }}
                    </span>
                </div>
            </div>

        </div>
        @empty
        {{-- Sisi Kosong Tanpa Log Transaksi --}}
        <div class="col-span-full py-16 bg-white border border-dashed border-slate-200 rounded-[32px] flex flex-col items-center justify-center text-center">
            <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mb-3">
                <i class="fas fa-file-invoice-dollar text-xl"></i>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">
                Belum ada rekap riwayat penggajian
            </p>
        </div>
        @endforelse
    </div>

</div>
@endsection