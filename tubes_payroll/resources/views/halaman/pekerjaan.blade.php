@extends('layouts.app')

@section('title', 'Pekerjaan Bengkel')

@push('loading')
<div class="space-y-8 animate-pulse">
    <div class="space-y-3">
        <div class="h-10 w-72 skeleton rounded-2xl"></div>
        <div class="h-4 w-56 skeleton rounded-xl"></div>
    </div>

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

    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        @for($i = 0; $i < 5; $i++)
        <div class="bg-white rounded-[30px] p-5 border border-slate-100 space-y-4">
            <div class="h-3 w-20 skeleton rounded-lg"></div>
            <div class="h-10 w-16 skeleton rounded-xl"></div>
        </div>
        @endfor
    </div>

    <div class="bg-white rounded-[40px] p-6 border border-slate-100 space-y-6">
        <div class="flex justify-between items-center">
            <div class="space-y-3">
                <div class="h-7 w-56 skeleton rounded-xl"></div>
                <div class="h-3 w-40 skeleton rounded-lg"></div>
            </div>
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            @for($i = 0; $i < 2; $i++)
            <div class="border border-slate-200 rounded-[28px] p-5 space-y-4">
                <div class="h-6 w-40 skeleton rounded-xl"></div>
                <div class="h-4 w-full skeleton rounded-lg"></div>
                <div class="h-4 w-5/6 skeleton rounded-lg"></div>
            </div>
            @endfor
        </div>
    </div>
</div>
@endpush

@section('content')

    <div class="mb-10">
        <h1 class="text-3xl font-black uppercase tracking-tighter text-slate-900">
            Pekerjaan Bengkel
        </h1>
        <p class="text-sm text-slate-500 font-bold uppercase tracking-widest mt-2">
            Monitoring pekerjaan teknisi workshop
        </p>
    </div>

    @if($divisi == 'TEKNIS' && $jabatan == 'ADMIN SERVICE')
    <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 mb-12">
        <h3 class="text-xl font-black text-slate-900 uppercase tracking-tighter mb-8">
            Form Keluhan Pelanggan
        </h3>

        <form action="{{ route('keluhan.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Plat Nomor</label>
                <input type="text" name="plat_nomor" class="w-full border rounded-xl px-4 py-3" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Kendaraan</label>
                <input type="text" name="kendaraan" class="w-full border rounded-xl px-4 py-3" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Keluhan</label>
                <select name="keluhan_id" class="w-full border rounded-xl px-4 py-3" required>
                    <option value="">-- Pilih Keluhan --</option>
                    @foreach($keluhanList as $keluhan)
                        <option value="{{ $keluhan->keluhan_id }}">{{ $keluhan->kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Detail Keluhan</label>
                <textarea name="detail_keluhan" rows="4" class="w-full border rounded-xl px-4 py-3" placeholder="Masukkan detail kerusakan kendaraan..." required></textarea>
            </div>

            <button type="submit" class="bg-orange-600 hover:bg-orange-700 transition text-white px-6 py-3 rounded-xl font-black uppercase tracking-widest text-sm">
                Simpan Keluhan
            </button>
        </form>
    </div>
    @endif

    <!-- untuk jabatan selain admin service -->
    @if($divisi == 'TEKNIS' && $jabatan != 'ADMIN SERVICE')
    <div class="space-y-6">

    <!-- statis atas -->
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="bg-white rounded-[30px] p-5 border border-slate-100 shadow-sm">
                <p class="text-[10px] uppercase font-black tracking-widest text-slate-400 mb-2">Total</p>
                <h2 class="text-3xl font-black text-slate-900">{{ $totalPekerjaan }}</h2>
            </div>

            <div class="bg-yellow-50 rounded-[30px] p-5 border border-yellow-100 shadow-sm">
                <p class="text-[10px] uppercase font-black tracking-widest text-yellow-500 mb-2">Waiting</p>
                <h2 class="text-3xl font-black text-yellow-600">{{ $belumDiambil }}</h2>
            </div>

            <div class="bg-blue-50 rounded-[30px] p-5 border border-blue-100 shadow-sm">
                <p class="text-[10px] uppercase font-black tracking-widest text-blue-500 mb-2">Progress</p>
                <h2 class="text-3xl font-black text-blue-600">{{ $sedangDikerjakan }}</h2>
            </div>

            <div class="bg-green-50 rounded-[30px] p-5 border border-green-100 shadow-sm">
                <p class="text-[10px] uppercase font-black tracking-widest text-green-500 mb-2">Selesai</p>
                <h2 class="text-3xl font-black text-green-600">{{ $selesai }}</h2>
            </div>

            <div class="bg-orange-600 rounded-[30px] p-5 shadow-sm text-white">
                <p class="text-[10px] uppercase font-black tracking-widest text-orange-100 mb-2">Bonus</p>
                <h2 class="text-2xl font-black">Rp {{ number_format($bonus, 0, ',', '.') }}</h2>
            </div>
        </div>

        <div class="bg-white rounded-[40px] p-6 border border-slate-100 shadow-sm">
            
            <div class="mb-6">
                <h3 class="text-xl font-black uppercase tracking-tighter text-slate-900">Daftar Pekerjaan</h3>
                <p class="text-[10px] uppercase tracking-widest font-black text-slate-400 mt-1">
                    Target Harian : {{ $targetHarian }} kendaraan
                </p>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 items-start">
                
            <!-- ini untuk nampilin 2 pekerjaan aja yg status=waiting. perPage: 2 itu -->
                <div class="space-y-4 bg-slate-50/50 p-4 rounded-[32px] border border-dashed border-slate-200"
                     x-data="{ page: 0, perPage: 2, total: {{ $pekerjaanList->where('status', 'waiting')->count() }} }">
                    <details class="w-full border border-slate-900 rounded-lg p-1 bg-white" open>
                        <summary class="flex justify-between items-center font-black uppercase tracking-widest text-xs text-slate-700 cursor-pointer p-2 select-none hover:bg-slate-50 transition rounded list-none">
                            <span class="flex items-center gap-2">📌 Antrean (Waiting)</span>
                            
                            <div class="flex items-center gap-1.5 ml-auto mr-2" @click.stop="">
                                <button 
                                    type="button"
                                    @click="if(page > 0) page--" 
                                    :class="page === 0 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-slate-200 active:scale-95'"
                                    class="w-6 h-6 flex items-center justify-center border border-slate-300 rounded-full bg-slate-50 text-slate-800 transition font-black text-sm select-none">
                                    ‹
                                </button>
                                <button 
                                    type="button"
                                    @click="if((page + 1) * perPage < total) page++" 
                                    :class="(page + 1) * perPage >= total ? 'opacity-30 cursor-not-allowed' : 'hover:bg-slate-200 active:scale-95'"
                                    class="w-6 h-6 flex items-center justify-center border border-slate-300 rounded-full bg-slate-50 text-slate-800 transition font-black text-sm select-none">
                                    ›
                                </button>
                            </div>

                            <span class="text-xs font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                                {{ $pekerjaanList->where('status', 'waiting')->count() }} Tugas
                            </span>
                        </summary>
                        
                        <!-- pagination <> we-->
                        <!-- ga dibuat di controller biar  ga ter reload halaman nya. karna kalo di controller klik <> bakal kena request lagi ke server-->
                        <div class="mt-4 space-y-4">
                            @php $indexWaiting = 0; @endphp
                            @forelse($pekerjaanList->where('status', 'waiting') as $job)
                                <div 
                                    x-show="Math.floor({{ $indexWaiting }} / perPage) === page"
                                    class="border border-slate-200 bg-white rounded-[24px] p-5 hover:border-orange-300 transition shadow-sm">
                                    <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                                        <div class="flex-1">
                                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                                <h4 class="text-base font-black uppercase text-slate-900">{{ $job->kendaraan }}</h4>
                                                <span class="bg-orange-100 text-orange-700 text-[9px] font-black px-2 py-0.5 rounded-lg uppercase">
                                                    {{ $job->keluhan->kategori }}
                                                </span>
                                            </div>
                                            <div class="flex gap-3 text-[11px] font-bold text-slate-400 uppercase">
                                                <span>Plat: {{ $job->plat_nomor }}</span>
                                                <span>{{ $job->created_at->format('d M') }}</span>
                                            </div>
                                            <p class="text-xs text-slate-600 mt-3 leading-relaxed bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                                {{ $job->detail_keluhan }}
                                            </p>
                                        </div>
                                        <div class="w-full sm:w-auto sm:min-w-[100px] mt-2 sm:mt-0">
                                            <form action="{{ route('pekerjaan.ambil', $job->pekerjaan_id) }}" method="POST">
                                                @csrf
                                                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-xs font-black uppercase w-full transition shadow-sm">
                                                    Ambil
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @php $indexWaiting++; @endphp
                            @empty
                                <div class="text-center py-12 bg-white rounded-[24px] border border-slate-100 shadow-sm">
                                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Antrean Kosong</p>
                                </div>
                            @endforelse
                        </div>
                    </details>
                </div>

                <!-- untuk status in progres -->
                <div class="space-y-4 bg-slate-50/50 p-4 rounded-[32px] border border-dashed border-slate-200">
                    <details class="w-full border border-slate-900 rounded-lg p-1 bg-white" open>
                        <summary class="flex justify-between items-center font-black uppercase tracking-widest text-xs text-slate-700 cursor-pointer p-2 select-none hover:bg-slate-50 transition rounded list-none">
                            <span class="flex items-center gap-2">⚡ Aktif (In Progress)</span>
                            <span class="text-xs font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded border border-slate-200 mr-2">{{ $pekerjaanList->where('status', 'in_progress')->count() }} Berjalan</span>
                        </summary>

                        <div class="mt-4 space-y-4">
                            @forelse($pekerjaanList->where('status', 'in_progress') as $job)
                                <div class="border border-slate-200 bg-white rounded-[24px] p-5 hover:border-orange-300 transition shadow-sm">
                                    <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                                        <div class="flex-1">
                                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                                <h4 class="text-base font-black uppercase text-slate-900">{{ $job->kendaraan }}</h4>
                                                <span class="bg-orange-100 text-orange-700 text-[9px] font-black px-2 py-0.5 rounded-lg uppercase">
                                                    {{ $job->keluhan->kategori }}
                                                </span>
                                            </div>
                                            <div class="flex gap-3 text-[11px] font-bold text-slate-400 uppercase">
                                                <span>Plat: {{ $job->plat_nomor }}</span>
                                                <span>{{ $job->created_at->format('d M') }}</span>
                                            </div>
                                            <p class="text-xs text-slate-600 mt-3 leading-relaxed bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                                {{ $job->detail_keluhan }}
                                            </p>
                                        </div>
                                        <div class="w-full sm:w-auto sm:min-w-[100px] mt-2 sm:mt-0">
                                            <form action="{{ route('pekerjaan.selesai', $job->pekerjaan_id) }}" method="POST">
                                                @csrf
                                                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-xl text-xs font-black uppercase w-full transition shadow-sm">
                                                    Selesai
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12 bg-white rounded-[24px] border border-slate-100 shadow-sm">
                                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Belum Ada Kerja Aktif</p>
                                </div>
                            @endforelse
                        </div>
                    </details>
                </div>

                <div class="space-y-4 bg-slate-50/50 p-4 rounded-[32px] border border-dashed border-slate-200">
                    <details class="border border-slate-900 rounded-lg p-1 bg-white">
                        <summary class="flex justify-between items-center font-black uppercase tracking-widest text-xs text-slate-700 cursor-pointer p-2 select-none hover:bg-slate-50 transition rounded list-none">
                            <span class="flex items-center gap-2">📋 LIHAT RIWAYAT PEKERJAAN SELESAI</span>
                            <span class="text-xs font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded border border-slate-200 mr-2">({{ $pekerjaanList->where('status', 'done')->count() }}) SELESAI</span>
                        </summary>

                        <div class="mt-4 grid grid-cols-1 gap-4">
                            @forelse($pekerjaanList->where('status', 'done') as $job)
                                <div class="border border-slate-100 bg-slate-50/50 rounded-2xl p-4 flex justify-between items-center opacity-70">
                                    <div>
                                        <h5 class="text-sm font-black uppercase text-slate-700">{{ $job->kendaraan }} - <span class="text-xs font-bold text-slate-400">{{ $job->plat_nomor }}</span></h5>
                                        <p class="text-[11px] font-bold text-slate-400 mt-1">Kategori: {{ $job->keluhan->kategori }}</p>
                                    </div>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-xl text-[10px] font-black uppercase">Done</span>
                                </div>
                            @empty
                                <div class="text-center py-12 bg-white rounded-[24px] border border-slate-100 shadow-sm">
                                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Belum Ada Riwayat</p>
                                </div>
                            @endforelse
                        </div>
                    </details>
                </div>

            </div>
        </div>
    </div>
    @endif
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '<span class="font-black uppercase tracking-tighter text-slate-900 text-xl">BERHASIL!</span>',
            html: '<span class="font-bold text-slate-600 text-sm">{{ session('success') }}</span>',
            confirmButtonText: 'OKE',
            confirmButtonColor: '#ea580c',
            customClass: {
                popup: 'rounded-[30px] p-6 border border-slate-100 shadow-xl',
                confirmButton: 'rounded-xl font-black uppercase tracking-widest text-xs px-6 py-3'
            }
        });
    </script>
    @endif

@endsection