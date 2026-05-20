@extends('layouts.app')

@section('title', 'Rincian Payroll | PayTato')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
        <div>
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-slate-900 rounded-3xl flex items-center justify-center text-orange-500 shadow-2xl rotate-3">
                    <i class="fas fa-id-card-clip text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 italic uppercase tracking-tighter leading-none">Individu Payroll</h1>
                    <p class="text-orange-600 text-[10px] font-black mt-1 uppercase tracking-[0.3em] italic">Data Gaji Kru per Personel</p>
                </div>
            </div>
        </div>
        
        <div class="flex gap-3">
            <button class="bg-white border border-slate-200 text-slate-600 px-6 py-4 rounded-2xl font-black transition-all shadow-sm flex items-center gap-3 text-[10px] uppercase tracking-widest hover:bg-slate-50">
                <i class="fas fa-file-export"></i> Export Laporan
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        @forelse($bulanLalu as $pay)
        <div class="group bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden hover:shadow-2xl hover:shadow-orange-100 transition-all duration-500">
            <div class="p-8 flex justify-between items-start border-b border-slate-50 bg-slate-50/50 group-hover:bg-white transition-colors">
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 bg-slate-900 rounded-[24px] flex items-center justify-center text-orange-500 font-black text-xl italic shadow-lg group-hover:rotate-6 transition-transform uppercase">
                        {{-- Ambil inisial dari relasi pegawai atau default --}}
                        {{ substr($pay->pegawai->nama_lengkap ?? 'User', 0, 2) }}
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter leading-none mb-2">
                            {{ $pay->bulan }} {{-- Tampilkan bulannya, misal 2026-05 --}}
                        </h3>
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-600 font-black text-[9px] uppercase tracking-widest">
                                {{ $pay->pegawai->divisi->nama_divisi ?? 'STAFF' }}
                            </span>
                            <span class="font-mono text-[10px] text-slate-400 font-bold tracking-tighter">NIP: {{ $pay->nip }}</span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Status</p>
                    <span class="text-xs font-black italic uppercase {{ $pay->status_bayar == 'dibayar' ? 'text-green-600' : 'text-orange-500' }}">
                        {{ $pay->status_bayar }} <i class="fas {{ $pay->status_bayar == 'dibayar' ? 'fa-circle-check' : 'fa-clock' }} ml-1"></i>
                    </span>
                </div>
            </div>

            <div class="p-8 grid grid-cols-3 gap-4 bg-white">
                <div class="bg-slate-50 p-4 rounded-3xl border border-slate-100 group-hover:border-orange-100 transition-all">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">Periode Mulai</p>
                    <p class="text-[10px] font-bold text-slate-700 leading-none">{{ $pay->periode_mulai }}</p>
                </div>
                <div class="bg-slate-50 p-4 rounded-3xl border border-slate-100 group-hover:border-green-100 transition-all text-center">
                    <p class="text-[8px] font-black text-green-400 uppercase tracking-widest mb-2 italic">Tunjangan & Bonus</p>
                    <p class="text-xs font-bold text-green-600 leading-none">
                        + {{ number_format($pay->total_tunjangan + $pay->bonus, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-slate-50 p-4 rounded-3xl border border-slate-100 group-hover:border-red-100 transition-all text-right">
                    <p class="text-[8px] font-black text-red-400 uppercase tracking-widest mb-2 italic">Potongan</p>
                    <p class="text-xs font-bold text-red-600 leading-none">
                        - {{ number_format($pay->total_potongan, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="px-8 py-6 bg-slate-900 flex justify-between items-center group-hover:bg-orange-600 transition-colors duration-500">
                <div>
                    <p class="text-[10px] font-black text-white/50 uppercase tracking-[0.2em] italic mb-1">Gaji Bersih Diterima</p>
                    <p class="text-2xl font-black text-white italic tracking-tighter leading-none">
                        Rp {{ number_format($pay->gaji_bersih, 0, ',', '.') }}
                    </p>
                </div>
                <button class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-white hover:bg-white hover:text-slate-900 transition-all shadow-inner">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
        @empty
        <div class="lg:col-span-2 py-20 text-center opacity-20">
            <i class="fas fa-file-invoice-dollar text-6xl mb-4 text-slate-400"></i>
            <p class="font-black uppercase italic tracking-[0.3em] text-sm">Belum ada riwayat penggajian</p>
        </div>
        @endforelse
    </div>
@endsection