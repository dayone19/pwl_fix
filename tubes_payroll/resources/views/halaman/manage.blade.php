@extends('layouts.app')

@section('title', 'PayTato | Kelola Gaji Akuntan')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-900 uppercase italic tracking-tighter">Pengelolaan Payroll</h2>
            <p class="text-[11px] text-slate-500 font-bold uppercase tracking-[0.2em]">Otoritas Akuntan • Periode {{ now()->format('F Y') }}</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.print()" class="px-5 py-3 bg-white border border-slate-200 rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-600 hover:bg-slate-50 transition">
                <i class="fas fa-print mr-2"></i> Print Laporan
            </button>
            <button class="px-5 py-3 bg-orange-600 rounded-2xl text-[10px] font-black uppercase tracking-widest text-white shadow-lg shadow-orange-900/20 hover:bg-orange-700 transition">
                <i class="fas fa-check-double mr-2"></i> Finalisasi Gaji
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[32px] border border-slate-200 shadow-sm relative overflow-hidden group">
            <i class="fas fa-money-bill-wave absolute -right-4 -bottom-4 text-6xl text-slate-50 opacity-10 group-hover:text-orange-500 transition-all"></i>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Estimasi Keluar</p>
            <h3 class="text-2xl font-black text-slate-900">Rp {{ number_format($totalEstimasiGaji, 0, ',', '.') }}</h3>
        </div>
        
        <div class="bg-white p-6 rounded-[32px] border border-slate-200 shadow-sm relative overflow-hidden group">
            <i class="fas fa-users absolute -right-4 -bottom-4 text-6xl text-slate-50 opacity-10 group-hover:text-blue-500 transition-all"></i>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Kru & Personel</p>
            <h3 class="text-2xl font-black text-slate-900">{{ $jumlahKaryawan }} <span class="text-sm text-slate-400 italic">Orang</span></h3>
        </div>

        <div class="bg-white p-6 rounded-[32px] border border-slate-200 shadow-sm relative overflow-hidden group">
            <i class="fas fa-calendar-check absolute -right-4 -bottom-4 text-6xl text-slate-50 opacity-10 group-hover:text-green-500 transition-all"></i>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Pembayaran</p>
            <h3 class="text-2xl font-black text-orange-600 uppercase italic">Drafting</h3>
        </div>
    </div>

    <div class="bg-white rounded-[32px] border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/30">
            <h3 class="text-[12px] font-black text-slate-900 uppercase tracking-widest italic flex items-center gap-2">
                <i class="fas fa-list-ul text-orange-600"></i> Rincian Gaji Per Karyawan
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Karyawan</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Jabatan</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Gaji Pokok</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Tunjangan (10%)</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Total Terima</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($karyawan as $k)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-slate-900 flex items-center justify-center text-white font-black text-[10px] italic border-2 border-orange-500/20">
                                    {{ strtoupper(substr($k->nama, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-xs font-black text-slate-900 uppercase italic leading-none mb-1">{{ $k->nama }}</p>
                                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">NIP. {{ $k->nip }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-orange-50 text-orange-600 border border-orange-100 rounded-full text-[9px] font-black uppercase tracking-tighter">
                                {{ $k->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-xs font-bold text-slate-700">
                                Rp {{ number_format($k->gaji_pokok ?? 4500000, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-xs font-bold text-orange-500">
                            + Rp {{ number_format($k->tunjangan, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-black">
                                Rp {{ number_format($k->total_gaji, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                <button title="Edit Rincian" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:bg-white hover:text-orange-600 hover:shadow-sm transition-all">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <i class="fas fa-user-slash text-4xl text-slate-100 mb-4 block"></i>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Data Karyawan Belum Tersedia</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection