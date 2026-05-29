@extends('layouts.app')

@push('loading')

<div class="space-y-8 animate-pulse">

    <div class="flex justify-between items-center">
        <div class="space-y-3">
            <div class="h-10 w-64 skeleton rounded-2xl"></div>
            <div class="h-4 w-40 skeleton rounded-xl"></div>
        </div>

        <div class="h-14 w-36 skeleton rounded-2xl"></div>
    </div>

    <div class="bg-white rounded-[40px] p-8 space-y-4">
        <div class="h-16 skeleton rounded-2xl"></div>
        <div class="h-16 skeleton rounded-2xl"></div>
        <div class="h-16 skeleton rounded-2xl"></div>
        <div class="h-16 skeleton rounded-2xl"></div>
    </div>

</div>

@endpush

@section('content')
    <div class="flex items-center gap-4 mb-10">
        <div class="w-14 h-14 bg-slate-900 rounded-3xl flex items-center justify-center text-orange-500 shadow-2xl rotate-3">
            <i class="fas fa-calendar-day text-2xl"></i>
        </div>
        <div>
            <h1 class="text-3xl font-black text-slate-900 italic uppercase tracking-tighter leading-none">Manajemen Cuti</h1>
            <p class="text-orange-600 text-[10px] font-black mt-1 uppercase tracking-[0.3em] italic">Atur Waktu Istirahat Kru</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-slate-900 p-6 rounded-[35px] border-b-4 border-orange-500 shadow-xl">
            <p class="text-orange-500 text-[10px] font-black uppercase tracking-widest mb-2 italic">Sisa Kuota Cuti</p>
            <h2 class="text-4xl font-black text-white italic tracking-tighter">{{ $sisaCuti }} <span class="text-sm">Hari</span></h2>
        </div>
        
        <div class="bg-white p-6 rounded-[35px] border border-slate-100 shadow-sm">
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-2 italic">Cuti Terpakai</p>
            <h2 class="text-4xl font-black text-slate-900 italic tracking-tighter">{{ $totalCutiDiambil }} <span class="text-sm">Hari</span></h2>
        </div>

        <button class="bg-orange-500 hover:bg-orange-600 p-6 rounded-[35px] shadow-lg shadow-orange-200 transition-all group flex flex-col justify-center">
            <p class="text-white text-[10px] font-black uppercase tracking-widest mb-1 italic">Ajukan Sekarang</p>
            <h2 class="text-2xl font-black text-white italic tracking-tighter group-hover:translate-x-2 transition-transform">Request Cuti <i class="fas fa-arrow-right ml-2"></i></h2>
        </button>
    </div>

    <h3 class="text-xl font-black text-slate-900 italic uppercase tracking-tighter mb-6">Riwayat Pengajuan</h3>
    <div class="space-y-4">
        @forelse($riwayatCuti as $c)
        <div class="bg-white p-6 rounded-[30px] border border-slate-100 flex items-center justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center gap-6">
                <div class="text-center bg-slate-50 px-4 py-2 rounded-2xl">
                    <p class="text-[10px] font-black text-slate-400 uppercase italic leading-none mb-1">Durasi</p>
                    <p class="text-lg font-black text-slate-900 italic">{{ $c->durasi }} Hari</p>
                </div>
                <div>
                    <p class="text-sm font-black text-slate-900 uppercase italic tracking-tighter">{{ $c->alasan }}</p>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">
                        {{ $c->tanggal_mulai }} s/d {{ $c->tanggal_selesai }}
                    </p>
                </div>
            </div>

            <div class="text-right">
                <span class="px-4 py-2 rounded-full text-[10px] font-black uppercase italic tracking-widest 
                    {{ $c->status == 'disetujui' ? 'bg-green-100 text-green-600' : ($c->status == 'ditolak' ? 'bg-red-100 text-red-600' : 'bg-orange-100 text-orange-600') }}">
                    {{ $c->status }}
                </span>
            </div>
        </div>
        @empty
        <div class="text-center py-10 opacity-30 italic">
            <i class="fas fa-calendar-xmark text-4xl mb-3"></i>
            <p class="text-xs font-black uppercase tracking-widest">Belum ada data cuti</p>
        </div>
        @endforelse
    </div>

@endsection