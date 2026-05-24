@extends('layouts.app')

@section('title', 'Dashboard | Workshop Overview')

@section('content')
    <style>
        .mesh-bg-workshop {
            background-color: #ea580c;
            background-image: 
                radial-gradient(at 0% 0%, hsla(20, 95%, 45%, 1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(10, 95%, 40%, 1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(30, 95%, 50%, 1) 0, transparent 50%);
        }
    </style>

    {{-- HEADER SECTION --}}
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
        <div class="flex items-start gap-5">
            <div class="relative">
                <div class="w-36 h-48 bg-slate-200 rounded-2xl overflow-hidden border-4 border-white shadow-xl ">
                    <img src="{{ asset('img/profil/' . ($user->foto ?? 'default.jpg')) }}" alt="foto" class="w-full h-full object-cover">
                </div>
                <div class="absolute -bottom-2 -right-2 bg-green-500 w-6 h-6 rounded-full border-4 border-white shadow-sm"></div>
            </div>

            <div class="flex flex-col gap-2">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 italic uppercase tracking-tighter leading-none">
                        {{ $user->nama }}
                    </h1>
                    <div class="mt-1 inline-block px-3 py-1 bg-slate-100 rounded-lg border border-slate-200">
                        <p class="text-[11px] font-black text-slate-500 uppercase tracking-widest">NIP: {{ $user->nip }}</p>
                    </div>

                    <div class="mt-1.5 flex items-center gap-1.5 text-orange-600">
                        <i class="fas fa-briefcase text-xs"></i>
                        <p class="text-[12px] font-black uppercase tracking-wider">{{ $namaJabatan }}</p>
                    </div>

                </div>

                <div class="flex flex-wrap gap-2">
                    <div class="px-4 py-1.5 bg-orange-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-orange-200 flex items-center gap-2">
                        <i class="fas fa-id-badge"></i> {{ $user->role }}
                    </div>
                </div>
            </div>
        </div>
        
        
    </header>

{{-- WIDGETS --}}
@php
    $divisi = Str::upper(Auth::user()->divisi?->nama_divisi);
    
    // Logika penentuan class grid berdasarkan jumlah kartu per role
    $gridConfig = 'md:grid-cols-4'; // Default (HRD & Manager)
    if ($divisi == 'FINANCE') {
        $gridConfig = 'md:grid-cols-3';
    } elseif ($divisi != 'FINANCE' && !in_array($divisi, ['MANAJEMEN', 'HRD'])) {
        $gridConfig = 'md:grid-cols-2'; // Teknisi / Lainnya
    }
@endphp

<div class="grid grid-cols-1 {{ $gridConfig }} gap-6 mb-12">

    {{-- LOGIKA DASHBOARD: teknis--}}
    @if(!in_array($divisi, ['MANAJEMEN', 'HRD', 'FINANCE']))
        {{-- 1. Track Cuti --}}
        <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Track Kuota Cuti</p>
                <h2 class="text-4xl font-black text-slate-900 italic tracking-tighter leading-none">{{ $cutiDiambil ?? 0 }} / 12</h2>
                <div class="w-full bg-slate-100 h-1 rounded-full mt-2">
                    <div class="bg-orange-500 h-1 rounded-full" style="width: {{ (($cutiDiambil ?? 0)/12)*100 }}%"></div>
                </div>
                <span class="text-[9px] font-bold text-slate-500 uppercase italic mt-1 inline-block">Sisa: {{ 12 - ($cutiDiambil ?? 0) }} Hari</span>
            </div>
            <i class="fas fa-calendar-alt absolute -right-4 -bottom-4 text-7xl text-slate-50"></i>
        </div>

        {{-- 2. Track Status Gaji --}}
        <div class="mesh-bg-workshop p-8 rounded-[45px] text-white shadow-2xl relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-60 mb-6 flex items-center gap-2">
                    <i class="fas fa-file-invoice-dollar"></i> Status Pembayaran Gaji
                </p>
                <h2 class="text-4xl font-black italic tracking-tighter mb-2 leading-none">
                    {{ Str::upper($gajiTerakhir->status_bayar ?? 'DRAFT') }}
                </h2>
                <p class="text-[10px] font-bold text-orange-200 uppercase italic">{{ date('F Y') }}</p>
            </div>
            <i class="fas fa-check-double absolute -bottom-6 -right-6 text-[100px] text-white/10 rotate-12 group-hover:scale-110 transition-transform"></i>
        </div>

    {{-- LOGIKA DASHBOARD: HRD--}}
    @elseif($divisi == 'HRD')
        <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Pegawai Aktif</p>
            <h2 class="text-4xl font-black text-slate-900 italic tracking-tighter leading-none">{{ $totalPegawai }}</h2>
            <i class="fas fa-users absolute -right-4 -bottom-4 text-7xl text-slate-50"></i>
        </div>

        <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Pengajuan Cuti</p>
            <h2 class="text-4xl font-black text-orange-500 italic tracking-tighter leading-none">{{ $jumlahCutiPending ?? 0 }}</h2>
            <i class="fas fa-envelope-open-text absolute -right-4 -bottom-4 text-7xl text-slate-50"></i>
        </div>

        <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Track Kuota Cuti</p>
                <h2 class="text-4xl font-black text-slate-900 italic tracking-tighter leading-none">{{ $cutiDiambil ?? 0 }} / 12</h2>
                <div class="w-full bg-slate-100 h-1 rounded-full mt-2">
                    <div class="bg-orange-500 h-1 rounded-full" style="width: {{ (($cutiDiambil ?? 0)/12)*100 }}%"></div>
                </div>
                <span class="text-[9px] font-bold text-slate-500 uppercase italic mt-1 inline-block">Sisa: {{ 12 - ($cutiDiambil ?? 0) }} Hari</span>
            </div>
            <i class="fas fa-calendar-alt absolute -right-4 -bottom-4 text-7xl text-slate-50"></i>
        </div>

        <div class="mesh-bg-workshop p-8 rounded-[45px] text-white shadow-2xl relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-60 mb-6 flex items-center gap-2">
                    <i class="fas fa-file-invoice-dollar"></i> Status Pembayaran Gaji
                </p>
                <h2 class="text-4xl font-black italic tracking-tighter mb-2 leading-none">
                    {{ Str::upper($gajiTerakhir->status_bayar ?? 'DRAFT') }}
                </h2>
                <p class="text-[10px] font-bold text-orange-200 uppercase italic">{{ date('F Y') }}</p>
            </div>
            <i class="fas fa-check-double absolute -bottom-6 -right-6 text-[100px] text-white/10 rotate-12 group-hover:scale-110 transition-transform"></i>
        </div>

    {{-- LOGIKA DASHBOARD: FINANCE --}}
    @elseif($divisi == 'FINANCE')

        <div class="mesh-bg-workshop p-8 rounded-[45px] text-white shadow-2xl relative overflow-hidden group">
            <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-60 mb-6">Total Biaya Gaji</p>
            <h2 class="text-2xl font-black italic tracking-tighter leading-none">Rp {{ number_format($totalPayroll ?? 0, 0, ',', '.') }}</h2>
            <i class="fas fa-coins absolute -right-4 -bottom-4 text-7xl text-white/10"></i>
        </div>

        <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group border-2 hover:border-blue-500 transition-all">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Payroll Submitted</p>
            <h2 class="text-3xl font-black text-blue-600 italic tracking-tighter leading-none">{{ $slipIsiCount ?? 0 }} / {{ $totalPegawai }}</h2>
            <i class="fas fa-file-export absolute -right-4 -bottom-4 text-7xl text-slate-50"></i>
        </div>

        <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Track Cuti</p>
                <h2 class="text-4xl font-black text-slate-900 italic tracking-tighter leading-none">{{ $cutiDiambil ?? 0 }} / 12</h2>
                <i class="fas fa-calendar-check absolute -right-4 -bottom-4 text-7xl text-slate-50"></i>
        </div>
        

    {{-- LOGIKA DASHBOARD: MANAGER --}}
    @elseif($divisi == 'MANAJEMEN')

        <div class="mesh-bg-workshop p-8 rounded-[45px] text-white shadow-2xl relative overflow-hidden group">
            <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-60 mb-6">Total Pengeluaran</p>
            <h2 class="text-2xl font-black italic tracking-tighter leading-none">Rp {{ number_format($totalPayroll ?? 0, 0, ',', '.') }}</h2>
            <i class="fas fa-vault absolute -right-4 -bottom-4 text-7xl text-white/10"></i>
        </div>

        <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Total Pegawai</p>
            <h2 class="text-4xl font-black text-slate-900 italic tracking-tighter leading-none">{{ $totalPegawai }}</h2>
            <i class="fas fa-user-tie absolute -right-4 -bottom-4 text-7xl text-slate-50"></i>
        </div>

        

        <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group border-2 border-green-500">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Payroll Approved</p>
            <h2 class="text-3xl font-black text-green-600 italic tracking-tighter leading-none">{{ $slipApprovedCount ?? 0 }} / {{ $totalPegawai }}</h2>
            <i class="fas fa-check-circle absolute -right-4 -bottom-4 text-7xl text-slate-50"></i>
        </div>

        <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Pengajuan Cuti</p>
            <h2 class="text-4xl font-black text-orange-500 italic tracking-tighter leading-none">{{ $jumlahCutiPending ?? 0 }}</h2>
            <i class="fas fa-user-clock absolute -right-4 -bottom-4 text-7xl text-slate-50"></i>
        </div>
    @endif

</div>

    @if(in_array($user->role, ['manager', 'hrd', 'akuntan']))
    <div class="bg-white rounded-[55px] p-10 border border-slate-100 shadow-sm mb-10">
        <h3 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter mb-8">Analisis Tren Gaji</h3>
        <div class="h-64"><canvas id="mainChart"></canvas></div>
    </div>
    @endif

    

        @if($divisi == 'MANAJEMEN')
        <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 mb-12">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-1">Analisis Bulanan</p>
                    <h3 class="text-xl font-black text-slate-900 italic tracking-tighter">STATISTIK PAYROLL</h3>
                </div>
                <select class="text-[10px] font-black uppercase tracking-widest border-none bg-slate-50 rounded-xl px-4 py-2 focus:ring-0">
                    <option>Tahun 2026</option>
                </select>
            </div>
            
            <div class="h-[300px]">
                <canvas id="mainChart"></canvas>
            </div>
        </div>
        @endif
        
        {{-- WORKSHOP INFO & REMINDER BOX --}}
        <div class="bg-slate-950 rounded-[55px] p-10 text-white shadow-2xl relative overflow-hidden flex flex-col">
            {{-- Aksen Gradasi Oranye Tipis Pojok Kanan Atas Biar Se-Tema --}}
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-orange-500/10 via-transparent to-transparent pointer-events-none"></div>

            <h3 class="text-xl font-black uppercase italic tracking-tighter mb-8 text-orange-500 relative z-10">Workshop Info</h3>
            
            <div class="space-y-8 relative z-10">
                <div class="flex gap-5">
                    <div class="bg-white/10 p-4 rounded-2xl text-center min-w-[60px]">
                        <p class="text-2xl font-black">{{ $totalPegawai }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase italic text-slate-200">Kru Aktif</p>
                        <p class="text-[9px] font-bold text-green-400 uppercase mt-1 tracking-widest italic">All Units Ready</p>
                    </div>
                </div>

                <div class="h-px bg-white/10 w-full"></div>

                {{-- DINAMIS: Reminder vs Safety Note --}}
                @if(in_array($user->role, ['manager', 'hrd', 'akuntan']))
                    <div class="space-y-4">
                        <p class="text-[10px] font-black text-orange-400 uppercase tracking-widest flex items-center gap-2">
                            <i class="fas fa-exclamation-triangle"></i> Penting:
                        </p>
                        <ul class="space-y-3">
                            <li class="text-[11px] font-bold text-slate-300 italic leading-tight uppercase">• Cek input gaji pegawai</li>
                            <li class="text-[11px] font-bold text-slate-300 italic leading-tight uppercase">• Deadline Payroll H-2</li>
                        </ul>
                    </div>
                @else
                    <div class="space-y-4">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                            <i class="fas fa-shield-alt"></i> Safety Note:
                        </p>
                        <p class="text-[11px] font-bold text-slate-300 italic leading-relaxed uppercase">
                            Gunakan APD lengkap dan patuhi protokol keselamatan kerja di area bengkel.
                        </p>
                    </div>
                @endif
            </div>
            <i class="fas fa-tools absolute -bottom-6 -right-6 text-[120px] text-white/5 -rotate-12"></i>
        </div>
    </div>
    

    @if($divisi == 'MANAJEMEN')

    {{-- CHART SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('mainChart').getContext('2d');
            
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(234, 88, 12, 0.3)');
            gradient.addColorStop(1, 'rgba(234, 88, 12, 0)');

            const chartData = @json(\App\Models\StatistikBulanan::orderBy('bulan', 'asc')->pluck('total_biaya') ?? []);
            const chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels.slice(0, chartData.length),
                    datasets: [{
                        label: 'Biaya',
                        data: chartData,
                        borderColor: '#ea580c',
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 4,
                        pointRadius: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#ea580c',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { 
                            display: false,
                            beginAtZero: true 
                        },
                        x: { 
                            grid: { display: false }, 
                            ticks: { 
                                color: '#94a3b8', 
                                font: { weight: 'bold', size: 10 } 
                            } 
                        }
                    }
                }
            });
        });
    </script>
@endif
@endsection