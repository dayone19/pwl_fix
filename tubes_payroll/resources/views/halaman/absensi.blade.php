@extends('layouts.app')

@section('title', 'Absensi & Lembur | PayTato')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
        <div>
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-slate-900 rounded-3xl flex items-center justify-center text-orange-500 shadow-2xl rotate-3">
                    <i class="fas fa-clipboard-user text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 italic uppercase tracking-tighter leading-none">Absensi & Lembur</h1>
                    <p class="text-orange-600 text-[10px] font-black mt-1 uppercase tracking-[0.3em] italic">Log Kehadiran Kru Bengkel</p>
                </div>
            </div>
        </div>
        
        <div class="flex gap-3">
            <button class="bg-white border border-slate-200 text-slate-600 px-6 py-4 rounded-2xl font-black transition-all shadow-sm flex items-center gap-3 text-[10px] uppercase tracking-widest hover:bg-slate-50">
                <i class="fas fa-file-export"></i> Export PDF
            </button>
            <button class="bg-orange-600 hover:bg-slate-900 text-white px-8 py-4 rounded-2xl font-black transition-all shadow-xl shadow-orange-100 flex items-center gap-3 text-[10px] uppercase tracking-widest group">
                <i class="fas fa-clock"></i> Absen Manual
            </button>
        </div>
    </div>

    <div class="bg-white rounded-[50px] shadow-sm border border-slate-100 overflow-hidden p-6">
        <table class="w-full text-left border-separate border-spacing-y-4">
            <thead>
                {{-- HEADER DARK CAPSULE STYLE --}}
                <tr class="bg-slate-900">
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.3em] text-white rounded-l-[30px] border-y border-l border-slate-900">
                        Identitas Pegawai
                    </th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.3em] text-yellow-400 text-center border-y border-slate-900">
                        Tanggal
                    </th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.3em] text-green-400 text-center border-y border-slate-900">
                        Jam Masuk
                    </th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.3em] text-red-400 text-center border-y border-slate-900">
                        Jam Keluar
                    </th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.3em] text-blue-400 text-right rounded-r-[30px] border-y border-r border-slate-900 bg-slate-800/50">
                        Status Kehadiran
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataAbsen as $item)
                <tr class="group hover:scale-[1.01] transition-all duration-300">
                    <td class="px-8 py-6 bg-slate-50 rounded-l-[35px] border-y border-l border-slate-100 group-hover:bg-white group-hover:border-orange-200 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center font-black text-slate-400 border border-slate-200 italic group-hover:bg-slate-900 group-hover:text-orange-500 transition-all">
                                {{ strtoupper(substr($item->nama_pegawai, 0, 2)) }}
                            </div>
                            <div>
                                <p class="font-black text-slate-800 uppercase italic tracking-tighter leading-none mb-1">{{ $item->nama_pegawai }}</p>
                                <span class="font-mono text-[9px] text-slate-400 font-bold tracking-widest uppercase">NIP: {{ $item->nip }}</span>
                            </div>
                        </div>
                    </td>

                    <td class="px-8 py-6 border-y border-slate-100 text-center group-hover:bg-white group-hover:border-orange-200 transition-colors">
                        <span class="text-slate-600 font-black italic text-xs uppercase">{{ $item->date }}</span>
                    </td>

                    <td class="px-8 py-6 border-y border-slate-100 text-center group-hover:bg-white group-hover:border-orange-200 transition-colors">
                        <div class="font-mono font-black text-sm text-blue-600 bg-blue-50 py-1 px-3 rounded-lg border border-blue-100 inline-block">
                            {{ $item->check_in }}
                        </div>
                    </td>

                    <td class="px-8 py-6 border-y border-slate-100 text-center group-hover:bg-white group-hover:border-orange-200 transition-colors">
                        <div class="font-mono font-black text-sm text-orange-600 bg-orange-50 py-1 px-3 rounded-lg border border-orange-100 inline-block">
                            {{ $item->check_out }}
                        </div>
                    </td>

                    <td class="px-8 py-6 bg-slate-50 rounded-r-[35px] border-y border-r border-slate-100 text-right group-hover:bg-white group-hover:border-orange-200 transition-colors">
                        <span class="px-4 py-2 rounded-xl text-[9px] font-black uppercase italic border shadow-sm
                            {{ $item->status == 'Hadir' 
                                ? 'bg-green-500 text-white border-green-600' 
                                : 'bg-yellow-400 text-slate-900 border-yellow-500' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-20 text-center">
                        <div class="flex flex-col items-center gap-2 opacity-20">
                            <i class="fas fa-calendar-xmark text-5xl mb-2"></i>
                            <p class="font-black uppercase italic tracking-widest text-xs">Belum ada catatan absen hari ini</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-10 flex justify-center items-center gap-4">
        @if ($dataAbsen->onFirstPage())
            <span class="text-slate-300 text-[10px] font-black uppercase italic cursor-not-allowed">Prev</span>
        @else
            <a href="{{ $dataAbsen->previousPageUrl() }}" class="text-slate-600 text-[10px] font-black uppercase italic hover:text-orange-600 transition-colors">Prev</a>
        @endif

        <div class="flex items-center gap-2">
            @php
                $curr = $dataAbsen->currentPage();
                $last = $dataAbsen->lastPage();
                $start = max($curr - 1, 1);
                $end = min($start + 2, $last);
                if ($end - $start < 2 && $start > 1) { $start = max($end - 2, 1); }
            @endphp

            @if($start > 1)
                <a href="{{ $dataAbsen->url(1) }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-100 text-slate-600 font-bold rounded-xl hover:border-orange-500 shadow-sm text-xs">1</a>
                @if($start > 2) <span class="text-slate-400 font-bold px-1">...</span> @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $curr)
                    <span class="w-10 h-10 flex items-center justify-center bg-slate-900 text-orange-500 font-black rounded-xl shadow-lg italic text-xs border-b-2 border-orange-600">
                        {{ $i }}
                    </span>
                @else
                    <a href="{{ $dataAbsen->url($i) }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-100 text-slate-600 font-bold rounded-xl hover:border-orange-500 hover:text-orange-600 transition-all shadow-sm text-xs">
                        {{ $i }}
                    </a>
                @endif
            @endfor

            @if($end < $last)
                @if($end < $last - 1) <span class="text-slate-400 font-bold px-1">...</span> @endif
                <a href="{{ $dataAbsen->url($last) }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-100 text-slate-600 font-bold rounded-xl hover:border-orange-500 shadow-sm text-xs">{{ $last }}</a>
            @endif
        </div>

        @if ($dataAbsen->hasMorePages())
            <a href="{{ $dataAbsen->nextPageUrl() }}" class="text-slate-600 text-[10px] font-black uppercase italic hover:text-orange-600 transition-colors">Next</a>
        @else
            <span class="text-slate-300 text-[10px] font-black uppercase italic cursor-not-allowed">Next</span>
        @endif
    </div>
@endsection