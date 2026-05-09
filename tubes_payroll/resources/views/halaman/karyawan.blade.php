@extends('layouts.app')

@section('title', 'Data Kru | PayTato')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
        <div>
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-slate-900 rounded-3xl flex items-center justify-center text-orange-500 shadow-2xl rotate-3">
                    <i class="fas fa-screwdriver-wrench text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 italic uppercase tracking-tighter leading-none">Database Kru</h1>
                    <p class="text-orange-600 text-[10px] font-black mt-1 uppercase tracking-[0.3em] italic">Workshop Management System</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[50px] shadow-sm border border-slate-100 overflow-hidden p-6">
        <table class="w-full text-left border-separate border-spacing-y-4">
            <thead>
                <tr class="bg-slate-900">
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.3em] text-white rounded-l-[30px] border-y border-l border-slate-900">
                        Identitas teknisi
                    </th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.3em] text-purple-400 text-center border-y border-slate-900">
                        Jabatan & Role
                    </th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.3em] text-orange-500 text-right rounded-r-[30px] border-y border-r border-slate-900 bg-slate-800/50">
                        Kontrol Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data_karyawan as $p)
                <tr class="group hover:scale-[1.01] transition-all duration-300">
                    <td class="px-8 py-6 bg-slate-50 rounded-l-[35px] border-y border-l border-slate-100 group-hover:bg-white group-hover:border-orange-200 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center font-black text-slate-900 border border-slate-200 italic shadow-sm group-hover:bg-orange-600 group-hover:text-white transition-all">
                                {{ strtoupper(substr($p->nama_lengkap, 0, 2)) }}
                            </div>
                            <div>
                                <p class="font-black text-slate-800 uppercase italic tracking-tighter leading-none mb-1">{{ $p->nama_lengkap }}</p>
                                <span class="font-mono text-[10px] text-orange-600 font-bold tracking-widest bg-orange-50 px-2 py-0.5 rounded border border-orange-100">
                                    #{{ $p->nip }}
                                </span>
                            </div>
                        </div>
                    </td>

                    <td class="px-8 py-6 border-y border-slate-100 text-center group-hover:bg-white group-hover:border-orange-200 transition-colors">
                        <span class="px-5 py-2 bg-white text-slate-800 text-[9px] font-black rounded-xl uppercase italic border border-slate-200 shadow-sm group-hover:text-orange-600 transition-colors">
                            {{ $p->jabatan ?? 'General Crew' }}
                        </span>
                    </td>

                    <td class="px-8 py-6 bg-slate-50 rounded-r-[35px] border-y border-r border-slate-100 text-right group-hover:bg-white group-hover:border-orange-200 transition-colors">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('karyawan.show', $p->id) }}" class="w-10 h-10 flex items-center justify-center bg-white text-slate-400 rounded-2xl border border-slate-200 hover:text-blue-600 hover:shadow-md transition-all group/btn">
                                <i class="fas fa-eye text-xs group-hover/btn:scale-110 transition-transform"></i>
                                </a>

                                <button class="w-10 h-10 flex items-center justify-center bg-white text-slate-400 rounded-2xl border border-slate-200 hover:text-orange-600 hover:shadow-md transition-all">
                                    <i class="fas fa-pen-nib text-xs"></i>
                                </button>
    
                                <button class="w-10 h-10 flex items-center justify-center bg-white text-slate-400 rounded-2xl border border-slate-200 hover:text-red-600 hover:shadow-md transition-all">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-8 py-20 text-center">
                        <div class="flex flex-col items-center gap-2 opacity-20">
                            <i class="fas fa-box-open text-5xl mb-2"></i>
                            <p class="font-black uppercase italic tracking-widest text-xs">Garasi Kosong / Tidak Ada Data</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-10 flex justify-center items-center gap-4">
        @if ($data_karyawan->onFirstPage())
            <span class="text-slate-300 text-[10px] font-black uppercase italic cursor-not-allowed">Prev</span>
        @else
            <a href="{{ $data_karyawan->previousPageUrl() }}" class="text-slate-600 text-[10px] font-black uppercase italic hover:text-orange-600 transition-colors">Prev</a>
        @endif

        <div class="flex items-center gap-2">
            @php
                $currentPage = $data_karyawan->currentPage();
                $lastPage = $data_karyawan->lastPage();
                $start = max($currentPage - 1, 1);
                $end = min($start + 2, $lastPage);
                if ($end - $start < 2 && $start > 1) { $start = max($end - 2, 1); }
            @endphp

            @if($start > 1)
                <a href="{{ $data_karyawan->url(1) }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-100 text-slate-600 font-bold rounded-xl hover:border-orange-500 shadow-sm text-xs">1</a>
                @if($start > 2) <span class="text-slate-400 font-bold px-1">...</span> @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $currentPage)
                    <span class="w-10 h-10 flex items-center justify-center bg-slate-900 text-orange-500 font-black rounded-xl shadow-lg italic text-xs border-b-2 border-orange-600">
                        {{ $i }}
                    </span>
                @else
                    <a href="{{ $data_karyawan->url($i) }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-100 text-slate-600 font-bold rounded-xl hover:border-orange-500 hover:text-orange-600 transition-all shadow-sm text-xs">
                        {{ $i }}
                    </a>
                @endif
            @endfor

            @if($end < $lastPage)
                @if($end < $lastPage - 1) <span class="text-slate-400 font-bold px-1">...</span> @endif
                <a href="{{ $data_karyawan->url($lastPage) }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-100 text-slate-600 font-bold rounded-xl hover:border-orange-500 shadow-sm text-xs">{{ $lastPage }}</a>
            @endif
        </div>

        @if ($data_karyawan->hasMorePages())
            <a href="{{ $data_karyawan->nextPageUrl() }}" class="text-slate-600 text-[10px] font-black uppercase italic hover:text-orange-600 transition-colors">Next</a>
        @else
            <span class="text-slate-300 text-[10px] font-black uppercase italic cursor-not-allowed">Next</span>
        @endif
    </div>
@endsection