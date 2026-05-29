@extends('layouts.app')

@section('title', 'User Management | PayTato')

@section('content')
    {{-- CSS Pemaksa Matikan Loader Khusus Halaman Ini --}}
    <style>
        #global-loader, #page-skeleton, .loading-skeleton {
            display: none !important;
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
        }
        #main-content, main, .content-body {
            opacity: 1 !important;
            visibility: visible !important;
        }
    </style>

    {{-- NOTIFIKASI SWEETALERT --}}
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'BERHASIL!',
                        text: "{{ session('success') }}",
                        timer: 3000,
                        showConfirmButton: false,
                        background: '#ffffff',
                        iconColor: '#ea580c',
                        customClass: {
                            title: 'font-black text-slate-900 uppercase italic tracking-tighter',
                            popup: 'rounded-[30px] border-none shadow-2xl'
                        }
                    });
                }
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'WADUH!',
                        text: "{{ session('error') }}",
                        confirmButtonColor: '#ea580c',
                        customClass: {
                            title: 'font-black text-slate-900 uppercase italic tracking-tighter',
                            popup: 'rounded-[30px]'
                        }
                    });
                }
            });
        </script>
    @endif

    {{-- HEADER SECTION --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
        <div>
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-slate-900 rounded-3xl flex items-center justify-center text-orange-500 shadow-2xl rotate-3">
                    <i class="fas fa-user-shield text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 italic uppercase tracking-tighter leading-none">User Management</h1>
                    <p class="text-orange-600 text-[10px] font-black mt-1 uppercase tracking-[0.3em] italic">Kontrol Akses Sistem</p>
                </div>
            </div>
        </div>
        
        <a href="{{ route('karyawan.create') }}" class="bg-orange-600 hover:bg-slate-900 text-white px-8 py-4 rounded-2xl font-black transition-all shadow-xl shadow-orange-100 flex items-center gap-3 text-[10px] uppercase tracking-widest leading-none group inline-flex">
            <i class="fas fa-user-plus group-hover:scale-110 transition-transform"></i> Tambah User
        </a>
    </div>

    {{-- TABLE SECTION --}}
    <div class="bg-white rounded-[50px] shadow-sm border border-slate-100 overflow-hidden p-6">
        <table class="w-full text-left border-separate border-spacing-y-4">
            <thead>
                <tr class="bg-slate-900">
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.3em] text-white rounded-l-[30px] border-y border-l border-slate-900">
                        Nama & NIP
                    </th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.3em] text-green-400 text-center border-y border-slate-900">
                        Email Address
                    </th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.3em] text-blue-400 text-center border-y border-slate-900">
                        Role Access
                    </th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.3em] text-orange-500 text-right rounded-r-[30px] border-y border-r border-slate-900 bg-slate-800/50">
                        Aksi Kontrol
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($data_karyawan as $user)
                <tr class="group hover:scale-[1.01] transition-all duration-300">
                    {{-- User Identity --}}
                    <td class="px-8 py-6 bg-slate-50 rounded-l-[35px] border-y border-l border-slate-100 group-hover:bg-white group-hover:border-orange-200 transition-colors">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('img/profil/' . ($user->foto ?? 'default.jpg')) }}" 
                                 class="w-10 h-10 rounded-xl object-cover border border-slate-200 shadow-sm group-hover:rotate-3 transition-transform"
                                 onerror="this.src='{{ asset('img/profil/default.jpg') }}'">
                            <div>
                                <p class="font-black text-slate-800 uppercase italic tracking-tighter leading-none mb-1">{{ $user->nama_lengkap ?? $user->nama }}</p>
                                <span class="font-mono text-[9px] text-slate-400 font-bold tracking-widest uppercase">NIP: #{{ $user->nip }}</span>
                            </div>
                        </div>
                    </td>

                    {{-- Email --}}
                    <td class="px-8 py-6 border-y border-slate-100 text-center group-hover:bg-white group-hover:border-orange-200 transition-colors italic font-bold text-slate-600 text-sm">
                        {{ $user->email }}
                    </td>

                    {{-- Role --}}
                    <td class="px-8 py-6 border-y border-slate-100 text-center group-hover:bg-white group-hover:border-orange-200 transition-colors">
                        <span class="px-4 py-1.5 bg-blue-50 text-blue-600 border border-blue-100 rounded-full font-black italic text-[9px] uppercase tracking-widest">
                            {{ $user->role ?? 'Pegawai' }}
                        </span>
                    </td>

                    {{-- Controls --}}
                    <td class="px-8 py-6 bg-slate-50 rounded-r-[35px] border-y border-r border-slate-100 text-right group-hover:bg-white group-hover:border-orange-200 transition-colors">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('karyawan.show', $user->nip) }}" class="w-9 h-9 flex items-center justify-center bg-white text-slate-400 rounded-xl border border-slate-200 hover:text-orange-600 hover:shadow-md transition-all">
                                <i class="fas fa-eye text-xs"></i>
                            </a>
                            <button class="w-9 h-9 flex items-center justify-center bg-white text-slate-400 rounded-xl border border-slate-200 hover:text-red-600 hover:shadow-md transition-all">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-20 text-center">
                        <div class="flex flex-col items-center gap-2 opacity-20">
                            <i class="fas fa-users-slash text-5xl mb-2"></i>
                            <p class="font-black uppercase italic tracking-widest text-xs">Belum ada user terdaftar</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION SECTION --}}
    <div class="mt-10 flex justify-center items-center gap-4">
        {{-- Previous --}}
        @if ($data_karyawan->onFirstPage())
            <span class="text-slate-300 text-[10px] font-black uppercase italic cursor-not-allowed">Prev</span>
        @else
            <a href="{{ $data_karyawan->previousPageUrl() }}" class="text-slate-600 text-[10px] font-black uppercase italic hover:text-orange-600 transition-colors">Prev</a>
        @endif

        {{-- Page Numbers --}}
        <div class="flex items-center gap-2">
            @php
                $curr = $data_karyawan->currentPage();
                $last = $data_karyawan->lastPage();
                $start = max($curr - 1, 1);
                $end = min($start + 2, $last);
                if ($end - $start < 2 && $start > 1) { $start = max($end - 2, 1); }
            @endphp

            @if($start > 1)
                <a href="{{ $data_karyawan->url(1) }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-100 text-slate-600 font-bold rounded-xl hover:border-orange-500 shadow-sm text-xs">1</a>
                @if($start > 2) <span class="text-slate-400 font-bold px-1">...</span> @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $curr)
                    <span class="w-10 h-10 flex items-center justify-center bg-slate-900 text-orange-500 font-black rounded-xl shadow-lg italic text-xs border-b-2 border-orange-600">
                        {{ $i }}
                    </span>
                @else
                    <a href="{{ $data_karyawan->url($i) }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-100 text-slate-600 font-bold rounded-xl hover:border-orange-500 hover:text-orange-600 transition-all shadow-sm text-xs">
                        {{ $i }}
                    </a>
                @endif
            @endfor

            @if($end < $last)
                @if($end < $last - 1) <span class="text-slate-400 font-bold px-1">...</span> @endif
                <a href="{{ $data_karyawan->url($last) }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-100 text-slate-600 font-bold rounded-xl hover:border-orange-500 shadow-sm text-xs">{{ $last }}</a>
            @endif
        </div>

        {{-- Next --}}
        @if ($data_karyawan->hasMorePages())
            <a href="{{ $data_karyawan->nextPageUrl() }}" class="text-slate-600 text-[10px] font-black uppercase italic hover:text-orange-600 transition-colors">Next</a>
        @else
            <span class="text-slate-300 text-[10px] font-black uppercase italic cursor-not-allowed">Next</span>
        @endif
    </div>
@endsection