@extends('layouts.app')

@section('title', 'Dashboard | Workshop Overview')

@push('loading')
<script>
    window.onload = function () {

        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');

        const progressBar = document.getElementById('progressBar');

        const nextStepBtn = document.getElementById('nextStepBtn');
        const backStepBtn = document.getElementById('backStepBtn');

        nextStepBtn.addEventListener('click', function () {
            step1.classList.add('hidden');
            step2.classList.remove('hidden');
            progressBar.style.width = '100%';
        });

        backStepBtn.addEventListener('click', function () {
            step2.classList.add('hidden');
            step1.classList.remove('hidden');
            progressBar.style.width = '50%';
        });

    };
</script>
@endpush

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

    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
        <div class="flex items-start gap-5">
            <div class="relative">
                <div class="w-36 h-48 bg-slate-200 rounded-2xl overflow-hidden border-4 border-white shadow-xl">
                    <img src="{{ asset('img/profil/' . ($user->foto ?? 'default.jpg')) }}" alt="foto" class="w-full h-full object-cover">
                </div>
                <div class="absolute -bottom-2 -right-2 bg-green-500 w-6 h-6 rounded-full border-4 border-white shadow-sm"></div>
            </div>

            <div class="flex flex-col gap-2">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tighter leading-none">
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

    @php
        $harusGanti = Auth::user()->harus_ganti_password;
        $batas      = Auth::user()->batas_ganti_password;
        $sisaJam    = $batas ? now()->diffInHours($batas, false) : 0;
        $expired    = $sisaJam <= 0;
    @endphp

    @if($harusGanti)
    <div class="mb-8 rounded-[30px] p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 {{ $expired ? 'bg-red-600' : 'bg-orange-500' }} text-white shadow-xl">
        <div class="flex items-center gap-4">
            <div class="bg-white/20 p-3 rounded-2xl">
                <i class="fas fa-key text-xl"></i>
            </div>
            <div>
                <p class="font-black uppercase tracking-widest text-sm">
                    {{ $expired ? 'Batas Waktu Habis!' : 'Wajib Ganti Password' }}
                </p>
                <p class="text-[11px] font-bold opacity-80 uppercase mt-0.5">
                    @if($expired)
                        Segera hubungi HRD untuk reset password.
                    @else
                        Sisa waktu: {{ floor($sisaJam / 24) }} hari {{ $sisaJam % 24 }} jam lagi
                    @endif
                </p>
            </div>
        </div>
        @if(!$expired)
        <a href="{{ route('password.form') }}"
            class="bg-white text-orange-600 font-black uppercase tracking-widest text-[11px] px-6 py-3 rounded-2xl shadow hover:scale-105 transition-all whitespace-nowrap">
            Ganti Sekarang
        </a>
        @endif
    </div>
    @endif

    @php
        $divisi = Str::upper(Auth::user()->divisi?->nama_divisi);
        
        $gridConfig = 'md:grid-cols-4'; // Default (HRD & Manager)
        if ($divisi == 'FINANCE') {
            $gridConfig = 'md:grid-cols-3';
        } elseif ($divisi != 'FINANCE' && !in_array($divisi, ['MANAJEMEN', 'HRD'])) {
            $gridConfig = 'md:grid-cols-2';
        }
    @endphp

    <div class="grid grid-cols-1 {{ $gridConfig }} gap-6 mb-12">

        @if(!in_array($divisi, ['MANAJEMEN', 'HRD', 'FINANCE']))

            <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Track Kuota Cuti</p>
                    <h2 class="text-4xl font-black text-slate-900 tracking-tighter leading-none">{{ $cutiDiambil ?? 0 }} / 12</h2>
                    <div class="w-full bg-slate-100 h-1 rounded-full mt-2">
                        <div class="bg-orange-500 h-1 rounded-full" style="width: {{ (($cutiDiambil ?? 0)/12)*100 }}%"></div>
                    </div>
                    <span class="text-[9px] font-bold text-slate-500 uppercase mt-1 inline-block">Sisa: {{ 12 - ($cutiDiambil ?? 0) }} Hari</span>
                </div>
                <i class="fas fa-calendar-alt absolute -right-4 -bottom-4 text-7xl text-slate-50"></i>
            </div>

            <div class="mesh-bg-workshop p-8 rounded-[45px] text-white shadow-2xl relative overflow-hidden group">
                <div class="relative z-10">
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-60 mb-6 flex items-center gap-2">
                        <i class="fas fa-file-invoice-dollar"></i> Status Pembayaran Gaji
                    </p>
                    <h2 class="text-4xl font-black tracking-tighter mb-2 leading-none">
                        {{ Str::upper($gajiTerakhir->status_bayar ?? 'DRAFT') }}
                    </h2>
                    <p class="text-[10px] font-bold text-orange-200 uppercase">{{ date('F Y') }}</p>
                </div>
                <i class="fas fa-check-double absolute -bottom-6 -right-6 text-[100px] text-white/10 rotate-12 group-hover:scale-110 transition-transform"></i>
            </div>

        @elseif($divisi == 'HRD')

            <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Pegawai Aktif</p>
                <h2 class="text-4xl font-black text-slate-900 tracking-tighter leading-none">{{ $totalPegawai }}</h2>
                <i class="fas fa-users absolute -right-4 -bottom-4 text-7xl text-slate-50"></i>
            </div>

            <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Pengajuan Cuti</p>
                <h2 class="text-4xl font-black text-orange-500 tracking-tighter leading-none">{{ $cutiPending ?? 0 }} <span class="text-lg font-medium text-slate-400">Hari</span></h2>
                <i class="fas fa-envelope-open-text absolute -right-4 -bottom-4 text-7xl text-slate-50"></i>
            </div>

            <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Track Kuota Cuti</p>
                    <h2 class="text-4xl font-black text-slate-900 tracking-tighter leading-none">{{ $cutiDiambil ?? 0 }} / 12</h2>
                    <div class="w-full bg-slate-100 h-1 rounded-full mt-2">
                        <div class="bg-orange-500 h-1 rounded-full" style="width: {{ (($cutiDiambil ?? 0)/12)*100 }}%"></div>
                    </div>
                    <span class="text-[9px] font-bold text-slate-500 uppercase mt-1 inline-block">Sisa: {{ 12 - ($cutiDiambil ?? 0) }} Hari</span>
                </div>
                <i class="fas fa-calendar-alt absolute -right-4 -bottom-4 text-7xl text-slate-50"></i>
            </div>

            <a href="{{ route('payroll.log') }}" class="block hover:scale-[1.01] transition-transform">
                <div class="mesh-bg-workshop p-8 rounded-[45px] text-white shadow-2xl relative overflow-hidden group h-full flex flex-col justify-between">
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-60 mb-4 flex items-center gap-2">
                        <i class="fas fa-file-invoice-dollar"></i> Status Gaji
                    </p>
                    <h2 class="text-4xl font-black tracking-tighter leading-none">{{ $sudahDibayar }} / {{ $sudahDibayar + $belumDibayar }}</h2>
                    <p class="text-[9px] font-black text-white/40 uppercase tracking-widest mt-auto pt-4 flex items-center gap-1">
                        <i class="fas fa-arrow-right text-[8px]"></i> Lihat Log Pembayaran
                    </p>
                    <i class="fas fa-money-check-alt absolute -bottom-6 -right-6 text-[100px] text-white/10 rotate-12"></i>
                </div>
            </a>

        @elseif($divisi == 'FINANCE')

            <div class="mesh-bg-workshop p-8 rounded-[45px] text-white shadow-2xl relative overflow-hidden group">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-60 mb-6">PENGELUARAN GAJI BULAN {{ $namaBulan }}</p>
                <h2 class="text-2xl font-black tracking-tighter leading-none">Rp {{ number_format($totalPayroll ?? 0, 0, ',', '.') }}</h2>
                <i class="fas fa-coins absolute -right-4 -bottom-4 text-7xl text-white/10"></i>
            </div>

            <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group border-2 hover:border-blue-500 transition-all">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Payroll Submitted</p>
                <h2 class="text-3xl font-black text-blue-600 tracking-tighter leading-none">{{ $slipIsiCount ?? 0 }} / {{ $totalPegawai }}</h2>
                <i class="fas fa-file-export absolute -right-4 -bottom-4 text-7xl text-slate-50"></i>
            </div>

            <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Track Cuti</p>
                <h2 class="text-4xl font-black text-slate-900 tracking-tighter leading-none">{{ $cutiDiambil ?? 0 }} / 12</h2>
                <i class="fas fa-calendar-check absolute -right-4 -bottom-4 text-7xl text-slate-50"></i>
            </div>

        {{-- LOGIKA DASHBOARD: MANAJEMEN --}}
        @elseif($divisi == 'MANAJEMEN')

            <div class="mesh-bg-workshop p-8 rounded-[45px] text-white shadow-2xl relative overflow-hidden group">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-60 mb-6">Total Pengeluaran Gaji Bulan {{ $namaBulan }}</p>
                <h2 class="text-2xl font-black tracking-tighter leading-none">Rp {{ number_format($totalPayroll ?? 0, 0, ',', '.') }}</h2>
                <i class="fas fa-vault absolute -right-4 -bottom-4 text-7xl text-white/10"></i>
            </div>

            <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Total Pegawai</p>
                <h2 class="text-4xl font-black text-slate-900 tracking-tighter leading-none">{{ $totalPegawai }}</h2>
                <i class="fas fa-user-tie absolute -right-4 -bottom-4 text-7xl text-slate-50"></i>
            </div>

            <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group border-2 border-green-500">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Payroll Approved</p>
                <h2 class="text-3xl font-black text-green-600 tracking-tighter leading-none">{{ $slipApprovedCount ?? 0 }} / {{ $totalPegawai }}</h2>
                <i class="fas fa-check-circle absolute -right-4 -bottom-4 text-7xl text-slate-50"></i>
            </div>

            <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Pengajuan Cuti</p>
                <h2 class="text-4xl font-black text-orange-500 tracking-tighter leading-none">{{ $jumlahCutiPending ?? 0 }}</h2>
                <i class="fas fa-user-clock absolute -right-4 -bottom-4 text-7xl text-slate-50"></i>
            </div>

        @endif

    </div>

    @if(in_array($user->role, ['manager', 'hrd', 'akuntan']))
    <div class="bg-white rounded-[55px] p-10 border border-slate-100 shadow-sm mb-10">
        <h3 class="text-xl font-black text-slate-900 uppercase tracking-tighter mb-8">Analisis Tren Gaji</h3>
        <div class="h-64"><canvas id="mainChart"></canvas></div>
    </div>
    @endif

    @if($divisi == 'MANAJEMEN' || $divisi == 'FINANCE')
    <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 mb-12">
        <div class="flex justify-between items-center mb-8">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-1">Analisis Bulanan</p>
                <h3 class="text-xl font-black text-slate-900 tracking-tighter">STATISTIK PENGELUARAN GAJI</h3>
            </div>
            <form action="{{ route('dashboard') }}" method="GET" id="formTahun">
                <select name="tahun" onchange="document.getElementById('formTahun').submit()" class="text-[10px] font-black uppercase tracking-widest border-none bg-slate-50 rounded-xl px-4 py-2 focus:ring-0 cursor-pointer">
                    <option value="2025" {{ $tahunDipilih == 2025 ? 'selected' : '' }}>Tahun 2025</option>
                    <option value="2026" {{ $tahunDipilih == 2026 ? 'selected' : '' }}>Tahun 2026</option>
                    <option value="2027" {{ $tahunDipilih == 2027 ? 'selected' : '' }}>Tahun 2027</option>
                </select>
            </form>
        </div>
        <div class="h-[300px]">
            <canvas id="mainChart"></canvas>
        </div>
    </div>
    @endif

    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm relative overflow-hidden flex flex-col justify-between">
        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full blur-2xl pointer-events-none"></div>
        
        <div>
            <div class="flex items-center gap-2 mb-6">
                <div class="w-1.5 h-4 bg-orange-500 rounded-full"></div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Workshop Info</h3>
            </div>

            <div class="grid grid-cols-2 gap-4 items-center">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-50 p-3 rounded-2xl text-blue-600 flex items-center justify-center">
                        <i class="fas fa-users text-lg"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-800 leading-none">{{ $totalPegawai }}</p>
                        <p class="text-xs font-medium text-slate-400 mt-1">Kru Aktif</p>
                    </div>
                </div>

                <div class="text-right border-l border-slate-100 pl-4">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-600">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        All Units Ready
                    </span>
                </div>
            </div>

            <hr class="my-5 border-slate-100">

            @if(in_array($user->role, ['manager', 'hrd', 'akuntan']))
                <div class="bg-orange-50/60 rounded-2xl p-4 border border-orange-100/50">
                    <p class="text-xs font-bold text-orange-600 uppercase tracking-wide flex items-center gap-2 mb-2">
                        <i class="fas fa-exclamation-circle text-sm"></i> Pengingat Penting
                    </p>
                    <ul class="space-y-1.5 pl-5 list-disc text-xs font-medium text-slate-600">
                        <li>Cek input gaji pegawai</li>
                        <li>Deadline Payroll H-2</li>
                    </ul>
                </div>
            @else
                <div class="bg-blue-50/60 rounded-2xl p-4 border border-blue-100/50">
                    <p class="text-xs font-bold text-blue-600 uppercase tracking-wide flex items-center gap-2 mb-1.5">
                        <i class="fas fa-shield-alt text-sm"></i> Safety Note
                    </p>
                    <p class="text-xs font-medium text-slate-600 leading-relaxed">
                        Gunakan APD lengkap dan patuhi protokol keselamatan kerja di area bengkel.
                    </p>
                </div>
            @endif
        </div>

        <i class="fas fa-tools absolute -bottom-4 -right-4 text-6xl text-slate-100 -rotate-12 pointer-events-none"></i>
    </div>

    @if($divisi == 'MANAJEMEN' || $divisi == 'FINANCE')
    {{-- CHART SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('mainChart').getContext('2d');
            
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(234, 88, 12, 0.3)');
            gradient.addColorStop(1, 'rgba(234, 88, 12, 0)');

            const chartData = @json($chartData ?? []);
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