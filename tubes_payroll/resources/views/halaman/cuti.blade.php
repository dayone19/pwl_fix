{{-- resources/views/halaman/cuti.blade.php --}}
@extends('layouts.app')

@section('content')
    {{-- HEADER --}}
    <div class="flex items-center gap-4 mb-10">
        <div class="w-14 h-14 bg-slate-900 rounded-3xl flex items-center justify-center text-orange-500 shadow-2xl rotate-3">
            <i class="fas fa-calendar-day text-2xl"></i>
        </div>
        <div>
            <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tighter leading-none">Manajemen Cuti</h1>
            <p class="text-orange-600 text-[10px] font-black mt-1 uppercase tracking-[0.3em]">Atur Waktu Istirahat Kru</p>
        </div>
    </div>

    {{-- FLASH --}}
    @foreach(['success','warning','error'] as $msg)
    @if(session($msg))
    <div class="mb-6 px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-widest
        {{ $msg == 'success' ? 'bg-green-50 border border-green-200 text-green-700' : ($msg == 'warning' ? 'bg-yellow-50 border border-yellow-200 text-yellow-700' : 'bg-red-50 border border-red-200 text-red-700') }}">
        <i class="fas fa-{{ $msg == 'success' ? 'check-circle' : 'triangle-exclamation' }} mr-2"></i>{{ session($msg) }}
    </div>
    @endif
    @endforeach

    {{-- KARTU STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-slate-900 p-6 rounded-[35px] border-b-4 border-orange-500 shadow-xl">
            <p class="text-orange-500 text-[10px] font-black uppercase tracking-widest mb-2">Sisa Kuota Cuti</p>
            <h2 class="text-4xl font-black text-white tracking-tighter">{{ $sisaCuti }} <span class="text-sm">Hari</span></h2>
        </div>
        <div class="bg-white p-6 rounded-[35px] border border-slate-100 shadow-sm">
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-2">Cuti Terpakai</p>
            <h2 class="text-4xl font-black text-slate-900 tracking-tighter">{{ $totalCutiDiambil }} <span class="text-sm">Hari</span></h2>
        </div>
        <button onclick="document.getElementById('modalAjukanCuti').classList.remove('hidden')"
            class="bg-orange-500 hover:bg-orange-600 p-6 rounded-[35px] shadow-lg shadow-orange-200 transition-all group flex flex-col justify-center text-left">
            <p class="text-white text-[10px] font-black uppercase tracking-widest mb-1">Ajukan Sekarang</p>
            <h2 class="text-2xl font-black text-white tracking-tighter group-hover:translate-x-2 transition-transform">
                Request Cuti <i class="fas fa-arrow-right ml-2"></i>
            </h2>
        </button>
    </div>

    {{-- RIWAYAT --}}
    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tighter mb-6">Riwayat Pengajuan</h3>
    <div class="space-y-4">
        @forelse($riwayatCuti as $c)
        @php
            $durasi = \Carbon\Carbon::parse($c->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($c->tanggal_selesai)) + 1;
            $statusStyle = match($c->status_persetujuan) {
            'Disetujui' => 'bg-green-100 text-green-600',
            'Ditolak'   => 'bg-red-100 text-red-600',
            default     => 'bg-orange-100 text-orange-600', // Menunggu
            };
        @endphp
        <div class="bg-white p-6 rounded-[30px] border border-slate-100 flex items-center justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center gap-6">
                <div class="text-center bg-slate-50 px-4 py-2 rounded-2xl">
                    <p class="text-[10px] font-black text-slate-400 uppercase leading-none mb-1">Durasi</p>
                    <p class="text-lg font-black text-slate-900">{{ $durasi }} Hari</p>
                </div>
                <div>
                    <p class="text-sm font-black text-slate-900 uppercase tracking-tighter">{{ $c->alasan }}</p>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">
                        {{ \Carbon\Carbon::parse($c->tanggal_mulai)->format('d M Y') }}
                        s/d
                        {{ \Carbon\Carbon::parse($c->tanggal_selesai)->format('d M Y') }}
                    </p>
                    @if(auth()->user()->id_divisi == 2)
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">
                    <i class="fas fa-user mr-1"></i>
                    {{ optional(\App\Models\Pengguna::find($c->id_pegawai))->nama ?? 'Tidak diketahui' }}
                </p>
                @endif
                </div>
            </div>

            <div class="flex items-center gap-3">
                {{-- Badge status --}}
                <span class="px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest {{ $statusStyle }}">
                    {{ $c->status_persetujuan }}
                </span>

                {{-- Tombol approve/tolak: hanya admin (id_divisi == 2) dan status masih pending --}}
                @if(auth()->user()->id_divisi == 2 && $c->status_persetujuan == 'Menunggu')
                <form action="{{ route('cuti.approve', $c->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                        <i class="fas fa-check mr-1"></i> Setujui
                    </button>
                </form>
                <form action="{{ route('cuti.tolak', $c->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                        <i class="fas fa-xmark mr-1"></i> Tolak
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-10 opacity-30">
            <i class="fas fa-calendar-xmark text-4xl mb-3"></i>
            <p class="text-xs font-black uppercase tracking-widest">Belum ada data cuti</p>
        </div>
        @endforelse
    </div>

    {{-- MODAL AJUKAN CUTI --}}
    <div id="modalAjukanCuti" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div onclick="document.getElementById('modalAjukanCuti').classList.add('hidden')"
            class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative bg-white rounded-[40px] shadow-2xl border border-slate-100 p-8 w-full max-w-lg z-10">
            <div class="flex items-center justify-between mb-7">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-slate-900 rounded-2xl flex items-center justify-center text-orange-500">
                        <i class="fas fa-calendar-plus text-sm"></i>
                    </div>
                    <div>
                        <p class="font-black text-slate-800 uppercase tracking-tighter text-sm leading-none">Ajukan Cuti</p>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-0.5">Sisa kuota: {{ $sisaCuti }} hari</p>
                    </div>
                </div>
                <button onclick="document.getElementById('modalAjukanCuti').classList.add('hidden')"
                    class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 transition-all">
                    <i class="fas fa-xmark text-sm"></i>
                </button>
            </div>

            <form action="{{ route('cuti.store') }}" method="POST" class="flex flex-col gap-5">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[9px] font-black uppercase tracking-[0.3em] text-slate-400 mb-2">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" required
                            class="w-full bg-slate-50 border border-slate-200 text-slate-800 font-black text-xs rounded-xl px-4 py-3 focus:outline-none focus:border-orange-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-[9px] font-black uppercase tracking-[0.3em] text-slate-400 mb-2">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" required
                            class="w-full bg-slate-50 border border-slate-200 text-slate-800 font-black text-xs rounded-xl px-4 py-3 focus:outline-none focus:border-orange-500 transition-colors">
                    </div>
                </div>
                <div>
                    <label class="block text-[9px] font-black uppercase tracking-[0.3em] text-slate-400 mb-2">Alasan Cuti</label>
                    <textarea name="alasan" rows="3" required maxlength="255"
                        placeholder="Contoh: Keperluan keluarga, pernikahan, dll."
                        class="w-full bg-slate-50 border border-slate-200 text-slate-800 font-black text-xs rounded-xl px-4 py-3 focus:outline-none focus:border-orange-500 transition-colors resize-none"></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button"
                        onclick="document.getElementById('modalAjukanCuti').classList.add('hidden')"
                        class="flex-1 bg-white border border-slate-200 text-slate-600 py-3.5 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-50 transition-all">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 bg-orange-600 hover:bg-slate-900 text-white py-3.5 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-orange-100 flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection