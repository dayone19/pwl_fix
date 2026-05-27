    @extends('layouts.app')

    @section('title', 'Pekerjaan Bengkel')

 @push('loading')

<div class="space-y-8 animate-pulse">

    {{-- HEADER --}}
    <div class="space-y-3">
        <div class="h-10 w-72 skeleton rounded-2xl"></div>
        <div class="h-4 w-56 skeleton rounded-xl"></div>
    </div>

    {{-- ADMIN SERVICE FORM --}}
    <div class="bg-white rounded-[45px] p-8 border border-slate-100 space-y-6">

        <div class="h-8 w-64 skeleton rounded-2xl"></div>

        <div class="space-y-3">
            <div class="h-4 w-32 skeleton rounded-lg"></div>
            <div class="h-12 skeleton rounded-xl"></div>
        </div>

        <div class="space-y-3">
            <div class="h-4 w-32 skeleton rounded-lg"></div>
            <div class="h-12 skeleton rounded-xl"></div>
        </div>

        <div class="space-y-3">
            <div class="h-4 w-32 skeleton rounded-lg"></div>
            <div class="h-12 skeleton rounded-xl"></div>
        </div>

        <div class="space-y-3">
            <div class="h-4 w-40 skeleton rounded-lg"></div>
            <div class="h-32 skeleton rounded-2xl"></div>
        </div>

        <div class="h-12 w-48 skeleton rounded-xl"></div>
    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">

        @for($i = 0; $i < 5; $i++)
        <div class="bg-white rounded-[30px] p-5 border border-slate-100 space-y-4">
            <div class="h-3 w-20 skeleton rounded-lg"></div>
            <div class="h-10 w-16 skeleton rounded-xl"></div>
        </div>
        @endfor

    </div>

    {{-- LIST PEKERJAAN --}}
    <div class="bg-white rounded-[40px] p-6 border border-slate-100 space-y-6">

        <div class="flex justify-between items-center">
            <div class="space-y-3">
                <div class="h-7 w-56 skeleton rounded-xl"></div>
                <div class="h-3 w-40 skeleton rounded-lg"></div>
            </div>
        </div>

        <div class="space-y-4">

            @for($i = 0; $i < 4; $i++)
            <div class="border border-slate-200 rounded-[28px] p-5">

                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">

                    <div class="flex-1 space-y-4">

                        <div class="flex gap-3">
                            <div class="h-6 w-40 skeleton rounded-xl"></div>
                            <div class="h-6 w-24 skeleton rounded-xl"></div>
                        </div>

                        <div class="flex gap-4">
                            <div class="h-4 w-28 skeleton rounded-lg"></div>
                            <div class="h-4 w-24 skeleton rounded-lg"></div>
                        </div>

                        <div class="space-y-2">
                            <div class="h-4 w-full skeleton rounded-lg"></div>
                            <div class="h-4 w-5/6 skeleton rounded-lg"></div>
                        </div>

                    </div>

                    <div class="flex flex-col gap-3 min-w-[140px]">
                        <div class="h-10 skeleton rounded-2xl"></div>
                        <div class="h-12 skeleton rounded-2xl"></div>
                    </div>

                </div>

            </div>
            @endfor

        </div>

    </div>

</div>

@endpush
    @section('content')

    <!-- @php
        $divisi = Str::upper(Auth::user()->divisi?->nama_divisi);
        $jabatan = Str::upper(Auth::user()->profilPegawai?->jabatan?->nama_jabatan);
    @endphp -->

    <div class="mb-10">
        <h1 class="text-3xl font-black italic uppercase tracking-tighter text-slate-900">
            Pekerjaan Bengkel
        </h1>

        <p class="text-sm text-slate-500 font-bold uppercase tracking-widest mt-2">
            Monitoring pekerjaan teknisi workshop
        </p>
    </div>

    {{-- KHUSUS ADMIN SERVICE --}}
    @if($divisi == 'TEKNIS' && $jabatan == 'Admin Service')

    <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 mb-12">

        <h3 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter mb-8">
            Form Keluhan Pelanggan
        </h3>

        <form action="{{ route('keluhan.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Plat Nomor
                </label>

                <input type="text"
                    name="plat_nomor"
                    class="w-full border rounded-xl px-4 py-3"
                    required>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Kendaraan
                </label>

                <input type="text"
                    name="kendaraan"
                    class="w-full border rounded-xl px-4 py-3"
                    required>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Keluhan
                </label>

                <select name="keluhan_id"
                        class="w-full border rounded-xl px-4 py-3"
                        required>

                    <option value="">-- Pilih Keluhan --</option>

                    @foreach($keluhanList as $keluhan)
                        <option value="{{ $keluhan->keluhan_id }}">
                            {{ $keluhan->kategori }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Detail Keluhan
                </label>

                <textarea name="detail_keluhan"
                        rows="4"
                        class="w-full border rounded-xl px-4 py-3"
                        placeholder="Masukkan detail kerusakan kendaraan..."
                        required></textarea>
            </div>

            <button type="submit"
                    class="bg-orange-600 hover:bg-orange-700 transition text-white px-6 py-3 rounded-xl font-black uppercase tracking-widest text-sm">
                Simpan Keluhan
            </button>
        </form>
    </div>

    @endif


    {{-- KHUSUS TEKNISI --}}
    @if($divisi == 'TEKNIS' && $jabatan != 'Admin Service')

    <div class="space-y-6">

        {{-- STATISTIK ATAS --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">

            <div class="bg-white rounded-[30px] p-5 border border-slate-100 shadow-sm">
                <p class="text-[10px] uppercase font-black tracking-widest text-slate-400 mb-2">
                    Total
                </p>

                <h2 class="text-3xl font-black text-slate-900">
                    {{ $totalPekerjaan }}
                </h2>
            </div>

            <div class="bg-yellow-50 rounded-[30px] p-5 border border-yellow-100 shadow-sm">
                <p class="text-[10px] uppercase font-black tracking-widest text-yellow-500 mb-2">
                    Waiting
                </p>

                <h2 class="text-3xl font-black text-yellow-600">
                    {{ $belumDiambil }}
                </h2>
            </div>

            <div class="bg-blue-50 rounded-[30px] p-5 border border-blue-100 shadow-sm">
                <p class="text-[10px] uppercase font-black tracking-widest text-blue-500 mb-2">
                    Progress
                </p>

                <h2 class="text-3xl font-black text-blue-600">
                    {{ $sedangDikerjakan }}
                </h2>
            </div>

            <div class="bg-green-50 rounded-[30px] p-5 border border-green-100 shadow-sm">
                <p class="text-[10px] uppercase font-black tracking-widest text-green-500 mb-2">
                    Selesai
                </p>

                <h2 class="text-3xl font-black text-green-600">
                    {{ $selesai }}
                </h2>
            </div>

            <div class="bg-orange-600 rounded-[30px] p-5 shadow-sm text-white">
                <p class="text-[10px] uppercase font-black tracking-widest text-orange-100 mb-2">
                    Bonus
                </p>

                <h2 class="text-2xl font-black">
                    Rp {{ number_format($bonus, 0, ',', '.') }}
                </h2>
            </div>

        </div>


        {{-- LIST PEKERJAAN --}}
        <div class="bg-white rounded-[40px] p-6 border border-slate-100 shadow-sm">

            <div class="flex justify-between items-center mb-6">

                <div>
                    <h3 class="text-xl font-black uppercase italic tracking-tighter text-slate-900">
                        Daftar Pekerjaan
                    </h3>

                    <p class="text-[10px] uppercase tracking-widest font-black text-slate-400 mt-1">
                        Target Harian : {{ $targetHarian }} kendaraan
                    </p>
                </div>

            </div>

            <div class="space-y-4">

                @forelse($pekerjaanList as $job)

                <div class="border border-slate-200 rounded-[28px] p-5 hover:border-orange-300 transition">

                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">

                        {{-- KIRI --}}
                        <div class="flex-1">

                            <div class="flex flex-wrap items-center gap-3 mb-3">

                                <h4 class="text-lg font-black uppercase text-slate-900">
                                    {{ $job->kendaraan }}
                                </h4>

                                <span class="bg-orange-100 text-orange-700 text-[10px] font-black px-3 py-1 rounded-xl uppercase">
                                    {{ $job->keluhan->kategori }}
                                </span>

                            </div>

                            <div class="flex flex-wrap gap-4 text-xs font-bold text-slate-500 uppercase tracking-wide">

                                <span>
                                    Plat : {{ $job->plat_nomor }}
                                </span>

                                <span>
                                    {{ $job->created_at->format('d M Y') }}
                                </span>

                            </div>

                            <p class="text-sm text-slate-600 mt-4 leading-relaxed">
                                {{ $job->detail_keluhan }}
                            </p>

                        </div>


                        {{-- KANAN --}}
                        <div class="flex flex-col gap-3 min-w-[140px]">

                            @if($job->status == 'waiting')

                                <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-2xl text-xs font-black uppercase text-center">
                                    Waiting
                                </span>

                                <form action="{{ route('pekerjaan.ambil', $job->pekerjaan_id) }}" method="POST">
                                    @csrf

                                    <button class="bg-blue-600 hover:bg-blue-700 transition text-white px-4 py-3 rounded-2xl text-xs font-black uppercase w-full">
                                        Ambil
                                    </button>
                                </form>

                            @elseif($job->status == 'in_progress')

                                <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-2xl text-xs font-black uppercase text-center">
                                    Progress
                                </span>

                                <form action="{{ route('pekerjaan.selesai', $job->pekerjaan_id) }}" method="POST">
                                    @csrf

                                    <button class="bg-green-600 hover:bg-green-700 transition text-white px-4 py-3 rounded-2xl text-xs font-black uppercase w-full">
                                        Selesai
                                    </button>
                                </form>

                            @else

                                <span class="bg-green-100 text-green-700 px-4 py-3 rounded-2xl text-xs font-black uppercase text-center">
                                    Done
                                </span>

                            @endif

                        </div>

                    </div>

                </div>

                @empty

                <div class="text-center py-20">

                    <i class="fas fa-toolbox text-5xl text-slate-200 mb-5"></i>

                    <p class="text-slate-400 font-black uppercase tracking-widest">
                        Belum Ada Pekerjaan
                    </p>

                </div>

                @endforelse

            </div>

        </div>

    </div>
    <!-- dd($jabatanId);
    dd($user->profilPegawai); -->

    @endif

    @endsection