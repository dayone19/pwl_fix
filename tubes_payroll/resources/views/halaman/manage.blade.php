@extends('layouts.app')

@section('title', 'PayTato | Kelola Gaji Meja Kerja')

@push('loading')
<div class="space-y-8 animate-pulse">
    {{-- Header Skeleton --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="space-y-3">
            <div class="h-8 w-72 skeleton rounded-2xl"></div>
            <div class="h-3 w-52 skeleton rounded-xl"></div>
        </div>
        <div class="flex gap-3">
            <div class="h-12 w-40 skeleton rounded-2xl"></div>
            <div class="h-12 w-44 skeleton rounded-2xl"></div>
        </div>
    </div>

    {{-- Panel Ringkasan Informasi Statistik Skeleton --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @for($i = 0; $i < 3; $i++)
        <div class="bg-white p-6 rounded-[32px] border border-slate-200">
            <div class="h-3 w-32 skeleton rounded mb-4"></div>
            <div class="h-8 w-40 skeleton rounded-xl"></div>
        </div>
        @endfor
    </div>

    {{-- Table Skeleton --}}
    <div class="bg-white rounded-[32px] border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <div class="h-4 w-56 skeleton rounded-xl"></div>
        </div>
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-6 gap-4 mb-2">
                <div class="h-10 skeleton rounded-xl"></div>
                <div class="h-10 skeleton rounded-xl"></div>
                <div class="h-10 skeleton rounded-xl"></div>
                <div class="h-10 skeleton rounded-xl"></div>
                <div class="h-10 skeleton rounded-xl"></div>
                <div class="h-10 skeleton rounded-xl"></div>
            </div>
            @for($i = 0; $i < 6; $i++)
            <div class="grid grid-cols-6 gap-4">
                <div class="h-16 skeleton rounded-2xl"></div>
                <div class="h-16 skeleton rounded-2xl"></div>
                <div class="h-16 skeleton rounded-2xl"></div>
                <div class="h-16 skeleton rounded-2xl"></div>
                <div class="h-16 skeleton rounded-2xl"></div>
                <div class="h-16 skeleton rounded-2xl"></div>
            </div>
            @endfor
        </div>
    </div>
</div>
@endpush

@section('content')
<div class="w-full min-w-0 space-y-8 px-1">
    
    {{-- Header Utama --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-900 uppercase  tracking-tighter">Pengelolaan Payroll</h2>
            <p class="text-[11px] text-slate-500 font-bold uppercase tracking-[0.2em]">
                • DIVISI {{ auth()->user()->profilPegawai?->divisi?->nama_divisi ?? '-' }}
                • JABATAN {{ auth()->user()->profilPegawai?->jabatan?->nama_jabatan ?? '-' }}
            </p>
        </div>
        <div class="flex flex-wrap gap-3">
            <button onclick="window.print()" class="px-5 py-3 bg-white border border-slate-200 rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-600 hover:bg-slate-50 transition">
                <i class="fas fa-print mr-2"></i> Print Laporan
            </button>
            
            {{-- Tombol Mass Approve Hanya Muncul untuk MANAJEMEN (ID = 1) --}}
            @if(auth()->user()->id_divisi == 1)
            <form action="{{ route('payroll.mass-action') }}"
                method="POST"
                class="inline flex gap-2"
                id="form-mass-action">
                @csrf

                {{-- MASS ACTION --}}
                <div class="relative" x-data="{ open:false }">
                    <button type="button"
                            @click="open = !open"
                            class="px-5 py-3 bg-emerald-600 rounded-2xl text-[10px] font-black uppercase tracking-widest text-white shadow-lg hover:bg-emerald-700 transition">
                        <i class="fas fa-layer-group mr-2"></i>
                        Mass Action
                    </button>

                    <div x-show="open"
                        @click.away="open = false"
                        class="absolute right-0 mt-3 w-72 bg-white rounded-3xl border border-slate-200 shadow-2xl overflow-hidden z-50">

                        <button type="submit"
                                name="action"
                                value="approve_all"
                                class="w-full flex items-center gap-3 px-4 py-3 text-left text-emerald-700 hover:bg-emerald-50 transition">

                            <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                                <i class="fas fa-check-double text-emerald-600"></i>
                            </div>

                            <div>
                                <p class="font-bold">Approve All</p>
                                <p class="text-xs text-slate-400">Set semua payroll menjadi Dibayar</p>
                            </div>
                        </button>

                        <div class="border-t border-slate-100"></div>

                        <button type="submit"
                                name="action"
                                value="reject_all"
                                onclick="return confirm('Yakin ingin menolak seluruh payroll berstatus Terbit?')"
                                class="w-full flex items-center gap-3 px-4 py-3 text-left text-red-700 hover:bg-red-50 transition">

                            <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center">
                                <i class="fas fa-ban text-red-600"></i>
                            </div>

                            <div>
                                <p class="font-bold">Reject All</p>
                                <p class="text-xs text-slate-400">Tolak seluruh payroll</p>
                            </div>
                        </button>
                    </div>
                </div>
                
                {{-- SELECTED ACTION --}}
                <div class="relative" x-data="{ open:false }">
                    <button type="button"
                            @click="open = !open"
                            class="px-5 py-3 bg-blue-600 rounded-2xl text-[10px] font-black uppercase tracking-widest text-white shadow-lg hover:bg-blue-700 transition">
                        <i class="fas fa-list-check mr-2"></i>
                        Selected Action
                    </button>

                    <div x-show="open"
                        @click.away="open = false"
                        class="absolute right-0 mt-3 w-72 bg-white rounded-3xl border border-slate-200 shadow-2xl overflow-hidden z-50">
                        <button type="submit"
                                name="action"
                                value="approve"
                                class="w-full flex items-center gap-3 px-4 py-3 text-left text-green-700 hover:bg-green-50 transition">
                            <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-bold">Approve Selected</p>
                                <p class="text-xs text-slate-400">Set status menjadi Dibayar</p>
                            </div>
                        </button>

                        <div class="border-t border-slate-100"></div>
                        <button type="submit"
                                name="action"
                                value="reject"
                                class="w-full flex items-center gap-3 px-4 py-3 text-left text-rose-700 hover:bg-rose-50 transition">
                            <div class="w-8 h-8 rounded-lg bg-rose-100 flex items-center justify-center">
                                <i class="fas fa-times text-rose-600"></i>
                            </div>
                            <div>
                                <p class="font-bold">Reject Selected</p>
                                <p class="text-xs text-slate-400">Set status menjadi Ditolak</p>
                            </div>
                        </button>
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>

    {{-- Panel Ringkasan Informasi Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[32px] border border-slate-200 shadow-sm relative overflow-hidden group">
            <i class="fas fa-money-bill-wave absolute -right-4 -bottom-4 text-6xl text-slate-50 opacity-10 group-hover:text-orange-500 transition-all"></i>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Dana Cair (Dibayar)</p>
            <h3 class="text-2xl font-black text-slate-900">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
        </div>
        
        <div class="bg-white p-6 rounded-[32px] border border-slate-200 shadow-sm relative overflow-hidden group">
            <i class="fas fa-users absolute -right-4 -bottom-4 text-6xl text-slate-50 opacity-10 group-hover:text-blue-500 transition-all"></i>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Kru & Personel</p>
            <h3 class="text-2xl font-black text-slate-900">{{ $totalPegawai }} <span class="text-sm text-slate-400 ">Orang</span></h3>
        </div>
        
        @if(in_array(Str::upper(Auth::user()->divisi?->nama_divisi), ['FINANCE', 'MANAJEMEN'])) 
        <div class="bg-white p-6 rounded-[32px] border border-slate-200 shadow-sm relative overflow-hidden group">
            <i class="fas fa-shield-alt absolute -right-4 -bottom-4 text-6xl text-slate-50 opacity-10 group-hover:text-green-500 transition-all"></i>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">
                Progress Payroll
            </p>

            <h3 class="text-2xl font-black text-orange-600">
                {{ $progressPayroll }}%
            </h3>

            <p class="text-[10px] text-slate-400 mt-1">
                {{ $dibayar }} Dibayar • {{ $terbit }} Terbit • {{ $draft }} Draft
            </p>
        </div>
        @endif
    </div>

    {{-- Form Hitung Gaji Hanya Muncul untuk FINANCE (ID = 3) --}}
    @if(auth()->user()->id_divisi == 3)
        <div class="bg-white p-6 rounded-[32px] border border-slate-200 shadow-sm">
            <h3 class="text-[12px] font-black text-slate-900 uppercase tracking-widest  mb-4 flex items-center gap-2">
                <i class="fas fa-plus-circle text-orange-600"></i> Generate Draf Penggajian Otomatis
            </h3>
            <form action="{{ route('payroll.generate') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Pilih Personel Karyawan</label>
                    <select name="nip" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-xs font-bold text-slate-700 focus:outline-none focus:border-orange-500 transition-all" required>
                        <option value="" disabled selected>-- Pilih Karyawan --</option>
                        @foreach($karyawan as $k)
                            <option value="{{ $k->nip }}">{{ $k->nama }} (NIP. {{ $k->nip }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Pilih Rekap Bulan & Tahun</label>
                    <select name="bulan" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-xs font-bold text-slate-700 focus:outline-none focus:border-orange-500 transition-all" required>
                        <option value="" disabled selected>-- Pilih Periode --</option>
                        @php $tahunSekarang = date('Y'); @endphp
                        @for($m = 1; $m <= 12; $m++)
                            @php 
                                $value = sprintf('%02d-%s', $m, $tahunSekarang); 
                            @endphp
                            <option value="{{ $value }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }} {{ $tahunSekarang }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <button type="submit" class="w-full px-5 py-3.5 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-800 transition shadow-md">
                        <i class="fas fa-cog mr-2"></i> Hitung & Buat Draf
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- Tabel Kendali Transaksi Penggajian --}}
    <div class="bg-white rounded-[32px] border border-slate-200 shadow-sm overflow-hidden w-full max-w-full">
        <div class="p-6 border-b border-slate-100 flex flex-wrap justify-between items-center gap-3 bg-slate-50/30">
            <h3 class="text-[12px] font-black text-slate-900 uppercase tracking-widest  flex items-center gap-2">
                <i class="fas fa-list-ul text-orange-600"></i>
                Daftar Kendali Log Kerja Gaji
            </h3>
            <form method="GET" action="{{ route('payroll.manage') }}" class="flex flex-wrap gap-2">
                <input
                    type="text"
                    name="nama"
                    value="{{ request('nama') }}"
                    placeholder="Nama"
                    class="px-3 py-2 border border-slate-200 rounded-xl text-xs">
                <input
                    type="text"
                    name="nip"
                    value="{{ request('nip') }}"
                    placeholder="NIP"
                    class="px-3 py-2 border border-slate-200 rounded-xl text-xs">
                <select
                    name="bulan"
                    class="px-3 py-2 border border-slate-200 rounded-xl text-xs">
                    <option value="">Bulan</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}"
                            {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
                <input
                    type="number"
                    name="tahun"
                    value="{{ request('tahun') }}"
                    placeholder="Tahun"
                    class="px-3 py-2 border border-slate-200 rounded-xl text-xs w-24">
                <button
                    type="submit"
                    class="px-4 py-2 bg-orange-600 text-white rounded-xl text-xs font-bold">
                    Filter
                </button>
                <a href="{{ route('payroll.manage') }}"
                    class="px-4 py-2 bg-slate-200 rounded-xl text-xs font-bold">
                    Reset
                </a>
            </form>
        </div>
        <div class="w-full overflow-x-auto">
            <table class="min-w-full text-left table-auto">
                <thead>
                    <tr class="bg-slate-50/50">
                        @if(auth()->user()->id_divisi == 1)
                            <th class="px-6 py-4 w-12 text-center">
                                <input type="checkbox" id="check-all-payroll" class="rounded bg-slate-50 border-slate-300 text-orange-600 focus:ring-orange-500">
                            </th>
                        @endif
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Karyawan</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Periode</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Gaji Pokok</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Tunjangan</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Bonus</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Total Potongan</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Total Terima (Bersih)</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($riwayatGaji as $gaji)
                    @php
                        $gapokRow = $gaji->gaji_pokok;
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        @if(auth()->user()->id_divisi == 1)
                            <td class="px-6 py-4 text-center">
                                @if($gaji->status_bayar === 'Terbit')
                                    <input type="checkbox" name="ids[]" value="{{ $gaji->id }}" form="form-mass-action" class="payroll-item-checkbox rounded bg-slate-50 border-slate-300 text-orange-600 focus:ring-orange-500">
                                @else
                                    <i class="fas fa-lock text-slate-200 text-[10px]"></i>
                                @endif
                            </td>
                        @endif
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-slate-900 flex items-center justify-center text-white font-black text-[10px]  border-2 border-orange-500/20">
                                    {{ strtoupper(substr($gaji->pegawai->nama ?? 'NN', 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-xs font-black text-slate-900 uppercase  leading-none mb-1">
                                        {{ $gaji->pegawai->nama_lengkap ?? 'Tidak Diketahui' }}
                                    </p>
                                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">NIP. {{ $gaji->nip }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center text-xs font-bold text-slate-600 uppercase">
                            {{ $gaji->bulan }}
                        </td>
                        <td class="px-6 py-4 text-right text-xs font-bold text-slate-700">
                            Rp {{ number_format($gapokRow, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right text-xs font-bold text-emerald-600">
                            + Rp {{ number_format($gaji->total_tunjangan, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right text-xs font-bold text-blue-600">
                            + Rp {{ number_format($gaji->bonus, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right text-xs font-bold text-rose-500">
                            - Rp {{ number_format($gaji->total_potongan, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="px-3 py-1 bg-slate-100 text-slate-900 rounded-lg text-xs font-black">
                                Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($gaji->status_bayar === 'Draft')
                                <span class="px-3 py-1 bg-slate-100 text-slate-600 border border-slate-200 rounded-full text-[9px] font-black uppercase tracking-tighter">Drafting</span>
                            @elseif($gaji->status_bayar === 'Terbit')
                                <span class="px-3 py-1 bg-amber-50 text-amber-600 border border-amber-100 rounded-full text-[9px] font-black uppercase tracking-tighter">Terbit</span>
                            @elseif($gaji->status_bayar === 'Ditolak')
                                <span class="px-3 py-1 bg-rose-50 text-rose-600 border border-rose-100 rounded-full text-[9px] font-black uppercase tracking-tighter">Ditolak</span>
                            @else
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-full text-[9px] font-black uppercase tracking-tighter">Dibayar</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                {{-- KONDISI A: FINANCE (ID = 3) --}}
                                @if(in_array($gaji->status_bayar, ['Draft', 'Ditolak']) && auth()->user()->id_divisi == 3)
                                    {{-- Tombol Edit terbuka untuk status Draft & Ditolak --}}
                                    <button
                                    onclick="bukaModalEdit('{{ $gaji->id }}', '{{ $gapokRow }}', '{{ $gaji->total_tunjangan }}', '{{ $gaji->bonus }}', '{{ $gaji->total_potongan }}')"
                                    title="Edit Komponen"
                                    class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center text-blue-600 hover:bg-blue-50 transition-all">
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>
                                    
                                    {{-- Tombol Submit Terbuka untuk Mengajukan Ulang Berkas Draft & Ditolak --}}
                                    <form action="/payroll/submit/{{ $gaji->id }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" title="Ajukan Ke Manajer" class="w-8 h-8 rounded-lg bg-orange-50 border border-orange-100 flex items-center justify-center text-orange-600 hover:bg-orange-100 transition-all">
                                            <i class="fas fa-paper-plane text-xs"></i>
                                        </button>
                                    </form>

                                    {{-- Tombol Hapus Hanya Tersedia Saat Benar-benar Berstatus Draft --}}
                                    @if($gaji->status_bayar === 'Draft')
                                    <form action="/payroll/delete/{{ $gaji->id }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus draf payroll karyawan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Berkas Draf" class="w-8 h-8 rounded-lg bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 hover:bg-rose-100 transition-all">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                    @endif
                                @endif

                                {{-- KONDISI B: MANAJEMEN (ID = 1) --}}
                                @if($gaji->status_bayar === 'Terbit' && auth()->user()->id_divisi == 1)
                                    <form action="/payroll/aksi/{{ $gaji->id }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="aksi" value="approve">
                                        <button type="submit" title="Setujui Cair" class="w-8 h-8 rounded-lg bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 hover:bg-emerald-100 transition-all">
                                            <i class="fas fa-check text-xs"></i>
                                        </button>
                                    </form>
                                    
                                    <form action="/payroll/aksi/{{ $gaji->id }}" method="POST" class="inline"> 
                                        @csrf
                                        <input type="hidden" name="aksi" value="reject">
                                        <button type="submit" title="Tolak Berkas" class="w-8 h-8 rounded-lg bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 hover:bg-rose-100 transition-all">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- KONDISI C: DATA TERKUNCI PERMANEN (Hanya Saat Sudah Dibayar, Atau Akses Silang Otoritas) --}}
                                @if($gaji->status_bayar === 'Dibayar' || ($gaji->status_bayar === 'Terbit' && auth()->user()->id_divisi == 3) || (in_array($gaji->status_bayar, ['Draft', 'Ditolak']) && auth()->user()->id_divisi == 1))
                                    <span class="text-[10px] text-slate-400 font-bold  uppercase tracking-tighter">Data Terkunci</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->id_divisi == 1 ? 10 : 9 }}" class="px-6 py-12 text-center">
                            <i class="fas fa-receipt text-4xl text-slate-100 mb-4 block"></i>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Belum Ada Transaksi Penggajian Terbuat</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

        {{-- PAGINATION --}}
            <div class="mt-10 flex justify-center items-center gap-4">

                {{-- PREV --}}
                @if ($riwayatGaji->onFirstPage())
                    <span class="text-slate-300 text-[10px] font-black uppercase  cursor-not-allowed">Prev</span>
                @else
                    <a href="{{ $riwayatGaji->appends(request()->query())->previousPageUrl() }}"
                        class="text-slate-600 text-[10px] font-black uppercase  hover:text-orange-600 transition-colors">
                        Prev
                    </a>
                @endif

                {{-- NOMOR HALAMAN --}}
                <div class="flex items-center gap-2">
                    @php
                        $curr = $riwayatGaji->currentPage();
                        $last = $riwayatGaji->lastPage();
                        $start = max($curr - 1, 1);
                        $end = min($start + 2, $last);

                        if ($end - $start < 2 && $start > 1) {
                            $start = max($end - 2, 1);
                        }
                    @endphp

                    @if($start > 1)
                        <a href="{{ $riwayatGaji->appends(request()->query())->url(1) }}"
                            class="w-10 h-10 flex items-center justify-center bg-white border border-slate-100 text-slate-600 font-bold rounded-xl hover:border-orange-500 shadow-sm text-xs">
                            1
                        </a>

                        @if($start > 2)
                            <span class="text-slate-400 font-bold px-1">...</span>
                        @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $curr)
                            <span class="w-10 h-10 flex items-center justify-center bg-slate-900 text-orange-500 font-black rounded-xl shadow-lg  text-xs border-b-2 border-orange-600">
                                {{ $i }}
                            </span>
                        @else
                            <a href="{{ $riwayatGaji->appends(request()->query())->url($i) }}"
                                class="w-10 h-10 flex items-center justify-center bg-white border border-slate-100 text-slate-600 font-bold rounded-xl hover:border-orange-500 hover:text-orange-600 transition-all shadow-sm text-xs">
                                {{ $i }}
                            </a>
                        @endif
                    @endfor

                    @if($end < $last)
                        @if($end < $last - 1)
                            <span class="text-slate-400 font-bold px-1">...</span>
                        @endif

                        <a href="{{ $riwayatGaji->appends(request()->query())->url($last) }}"
                            class="w-10 h-10 flex items-center justify-center bg-white border border-slate-100 text-slate-600 font-bold rounded-xl hover:border-orange-500 shadow-sm text-xs">
                            {{ $last }}
                        </a>
                    @endif
                </div>

                {{-- NEXT --}}
                @if ($riwayatGaji->hasMorePages())
                    <a href="{{ $riwayatGaji->appends(request()->query())->nextPageUrl() }}"
                        class="text-slate-600 text-[10px] font-black uppercase  hover:text-orange-600 transition-colors">
                        Next
                    </a>
                @else
                    <span class="text-slate-300 text-[10px] font-black uppercase  cursor-not-allowed">
                        Next
                    </span>
                @endif

            </div>
        {{-- END PAGINATION --}}
</div>

{{-- POPUP MODAL EDIT DRAF --}}
@if(auth()->user()->id_divisi == 3)
<div id="modal-edit-draft" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden animate-fade-in">
    <div class="bg-white rounded-[32px] border border-slate-200 shadow-2xl p-6 w-full max-w-md mx-4">
        <h3 class="text-sm font-black text-slate-900 uppercase  tracking-wider mb-4 border-b pb-2 flex items-center gap-2">
            <i class="fas fa-sliders-h text-orange-600"></i> Modifikasi Nilai Draf Gaji
        </h3>
        <form id="form-edit-draft" action="" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Gaji Pokok (Standar Jabatan)</label>
                <input type="number" id="modal-gapok" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-3 py-2.5 text-xs font-bold text-slate-400 cursor-not-allowed focus:outline-none" readonly>
            </div>
            <div>
                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Tunjangan</label>
                <input type="number" id="modal-tunjangan" name="total_tunjangan" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs font-bold text-slate-700 focus:outline-none" required>
            </div>
            <div>
                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Bonus Mekanik</label>
                <input type="number" id="modal-bonus" name="bonus" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs font-bold text-slate-700 focus:outline-none" required>
            </div>
            <div>
                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Potongan</label>
                <input type="number" id="modal-potongan" name="total_potongan" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs font-bold text-slate-700 focus:outline-none" required>
            </div>
            <div class="flex gap-2 justify-end pt-2">
                <button type="button" onclick="tutupModalEdit()" class="px-4 py-2 bg-slate-100 rounded-xl text-[9px] font-black uppercase text-slate-600 hover:bg-slate-200 transition">Batal</button>
                <button type="submit" class="px-4 py-2 bg-slate-900 rounded-xl text-[9px] font-black uppercase text-white hover:bg-slate-800 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endif

<script>
    const checkAll = document.getElementById('check-all-payroll');
    if(checkAll) {
        checkAll.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.payroll-item-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    }

    function bukaModalEdit(id, gapok, tunjangan, bonus, potongan)
    {
        const modal = document.getElementById('modal-edit-draft');
        const form = document.getElementById('form-edit-draft');

        if (modal && form) {
            form.action = "{{ url('/payroll/update-draft') }}/" + id;

            document.getElementById('modal-gapok').value = gapok;
            document.getElementById('modal-tunjangan').value = tunjangan;
            document.getElementById('modal-bonus').value = bonus;
            document.getElementById('modal-potongan').value = potongan;

            modal.classList.remove('hidden');
        }
    }

    function tutupModalEdit() {
        const modal = document.getElementById('modal-edit-draft');
        if(modal) modal.classList.add('hidden');
    }

    window.addEventListener('beforeunload', function () {
        sessionStorage.setItem('payrollScroll', window.scrollY);
    });

    window.addEventListener('load', function () {
        const scrollPosition = sessionStorage.getItem('payrollScroll');

        if (scrollPosition) {
            window.scrollTo(0, parseInt(scrollPosition));
        }
    });
</script>
@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Generate Gagal',
        text: '{{ session('error') }}',
        confirmButtonColor: '#ef4444'
    });
</script>
@endif
@endsection