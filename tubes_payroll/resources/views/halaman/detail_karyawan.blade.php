@extends('layouts.app')

@section('title', 'Profil Detail Pegawai | PayTato')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('karyawan.index') }}" class="w-10 h-10 bg-white border border-slate-100 rounded-xl flex items-center justify-center text-slate-400 hover:text-orange-600 transition-all shadow-sm">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter">Profil Detail teknisi</h1>
    </div>

    <div class="bg-white rounded-[50px] shadow-sm border border-slate-100 overflow-hidden relative">
        <div class="h-32 bg-gradient-to-r from-slate-900 to-slate-800 relative">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;"></div>
        </div>

        <div class="px-10 pb-12">
            <div class="flex flex-col md:flex-row items-end gap-6 -mt-16 mb-10 relative z-10">
                <div class="relative">
                    <div class="w-40 h-48 bg-slate-200 rounded-[35px] border-[6px] border-white shadow-2xl overflow-hidden shadow-orange-900/10">
                        <img src="{{ $p->foto ? asset('img/profil/' . $p->foto) : 'https://via.placeholder.com/400x500' }}" class="w-full h-full object-cover" alt="Foto Pegawai">
                    </div>
                    <div class="absolute -bottom-2 -right-2 bg-orange-600 text-white w-10 h-10 rounded-2xl flex items-center justify-center border-4 border-white shadow-lg">
                        <i class="fas fa-wrench text-xs"></i>
                    </div>
                </div>

                <div class="flex-1 pb-2">
                    <h2 class="text-4xl font-black text-slate-900 uppercase italic tracking-tighter leading-none mb-2">
                        {{ $p->nama_lengkap }}
                    </h2>
                    <div class="flex flex-wrap gap-3">
                        <span class="px-4 py-1.5 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg">
                            Divisi: {{ $p->nama_divisi }}
                        </span>
                        <span class="px-4 py-1.5 bg-orange-50 text-orange-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-orange-100 shadow-sm">
                            {{ $p->jabatan }}
                        </span>
                        @php
                            $status = strtolower($p->status_kerja);
                            $colorClass = 'bg-slate-100 text-slate-600 border-slate-200'; // Default

                            if ($status == 'tetap') {
                                $colorClass = 'bg-emerald-500 text-white shadow-md';
                            } elseif ($status == 'magang') {
                                $colorClass = 'bg-blue-500 text-white shadow-md';
                            } elseif ($status == 'pkl') {
                                $colorClass = 'bg-purple-500 text-white shadow-md';
                            } elseif ($status == 'kontrak') {
                                $colorClass = 'bg-orange-500 text-white shadow-md';
                            }
                        @endphp

                        <span class="px-4 py-1.5 {{ $colorClass }} rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                            {{ $p->status_kerja }}
                        </span>
                        
                    </div>
                </div>
            </div>

            <hr class="border-slate-100 mb-10">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                
                <div class="space-y-6">
                    <h3 class="text-[10px] font-black text-orange-600 uppercase tracking-[0.3em] italic mb-4 flex items-center gap-2">
                        <i class="fas fa-id-card"></i> Identitas Resmi
                    </h3>
                    
                    <div class="flex flex-col gap-1 border-l-4 border-slate-100 pl-4">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Nomor Induk Pegawai (NIP)</span>
                        <span class="text-sm font-bold text-slate-800 font-mono italic">#{{ $p->nip }}</span>
                    </div>

                    <div class="flex flex-col gap-1 border-l-4 border-slate-100 pl-4 text-slate-400">
                        <span class="text-[9px] font-black uppercase tracking-widest">Nomor Induk Kependudukan (NIK)</span>
                        <span class="text-sm font-bold text-slate-800">{{ $p->nik }}</span>
                    </div>

                    <div class="flex flex-col gap-1 border-l-4 border-slate-100 pl-4">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Tempat, Tanggal Lahir</span>
                        <span class="text-sm font-bold text-slate-800 italic uppercase">
                            {{ $p->tempat_tanggal_lahir ?? 'Data Tidak Tersedia' }}
                        </span>
                    </div>

                    <div class="flex flex-col gap-1 border-l-4 border-slate-100 pl-4">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Pendidikan Terakhir</span>
                        <span class="text-sm font-bold text-slate-800 uppercase italic">{{ $p->pendidikan }}</span>
                    </div>

                    <div class="flex flex-col gap-1 border-l-4 border-slate-100 pl-4">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Agama</span>
                        <span class="text-sm font-bold text-slate-800 uppercase italic">{{ $p->agama }}</span>
                    </div>
                </div>

                <div class="space-y-6">
                    <h3 class="text-[10px] font-black text-orange-600 uppercase tracking-[0.3em] italic mb-4 flex items-center gap-2">
                        <i class="fas fa-address-book"></i> Kontak & Sosial
                    </h3>

                    <div class="flex flex-col gap-1 border-l-4 border-slate-100 pl-4">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Alamat Email</span>
                        <span class="text-sm font-bold text-slate-800 lowercase">{{ $p->email }}</span>
                    </div>

                    <div class="flex flex-col gap-1 border-l-4 border-slate-100 pl-4">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Nomor Telepon(WhatsApp)</span>
                        <span class="text-sm font-bold text-slate-800 italic">{{ $p->nomor_telepon }}</span>
                    </div>

                    <div class="pt-6 flex gap-3">
                        <button class="flex-1 bg-slate-900 text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl hover:bg-orange-600 transition-all italic">
                            Cetak Kartu Pegawai
                        </button>
                        <button class="w-14 h-14 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center border border-orange-100 hover:bg-orange-600 hover:text-white transition-all shadow-sm">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection