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
                </div>

                <div class="flex flex-wrap gap-2">
                    <div class="px-4 py-1.5 bg-orange-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-orange-200 flex items-center gap-2">
                        <i class="fas fa-id-badge"></i> {{ $user->role }}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="hidden lg:flex items-center gap-4 bg-white p-4 rounded-[30px] border border-slate-100 shadow-sm">
            <div class="text-right">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none mb-1">Last Sync</p>
                <p class="text-xs font-bold text-slate-900 uppercase italic">{{ date('D, d M Y') }}</p>
            </div>
            <div class="w-px h-8 bg-slate-100"></div>
            <div class="flex items-center gap-3">
                 <div class="text-right">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none">Status</p>
                    <p class="text-[10px] font-black text-green-500 uppercase">Online</p>
                </div>
                <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600">
                    <i class="fas fa-bolt"></i>
                </div>
            </div>
        </div>
    </header>

    {{-- TOP WIDGETS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        @if(in_array($user->role, ['manager', 'hrd', 'akuntan']))
            <div class="mesh-bg-workshop p-8 rounded-[45px] text-white shadow-2xl relative overflow-hidden group">
                <div class="relative z-10">
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-60 mb-6 flex items-center gap-2">
                        <i class="fas fa-file-invoice-dollar"></i> Biaya Operasional & Gaji
                    </p>
                    <h2 class="text-3xl font-black italic tracking-tighter mb-2 leading-none">
                        Rp {{ number_format($stats->total_biaya ?? 0, 0, ',', '.') }}
                    </h2>
                    <p class="text-[10px] font-bold text-orange-200 uppercase italic">Update: {{ date('F Y') }}</p>
                </div>
                <i class="fas fa-oil-can absolute -bottom-6 -right-6 text-[120px] text-white/10 rotate-12 group-hover:scale-110 transition-transform"></i>
            </div>
        @else
            <div class="mesh-bg-workshop p-8 rounded-[45px] text-white shadow-2xl relative overflow-hidden group">
                <div class="relative z-10">
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-60 mb-6 flex items-center gap-2">
                        <i class="fas fa-wallet"></i> Estimasi Gaji Pokok
                    </p>
                    <h2 class="text-3xl font-black italic tracking-tighter mb-2 leading-none">
                        Rp {{ number_format($user->gaji_pokok ?? 0, 0, ',', '.') }}
                    </h2>
                    <p class="text-[10px] font-bold text-orange-200 uppercase italic">Status: Pegawai Aktif</p>
                </div>
                <i class="fas fa-wrench absolute -bottom-6 -right-6 text-[120px] text-white/10 rotate-12 group-hover:scale-110 transition-transform"></i>
            </div>
        @endif

        <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Total Kru Bengkel</p>
                <h2 class="text-4xl font-black text-slate-900 italic tracking-tighter leading-none">{{ $totalPegawai }}</h2>
            </div>
            <div class="flex gap-2 mt-4 relative z-10">
                <span class="px-2 py-1 bg-green-50 text-green-600 text-[9px] font-black rounded-lg uppercase italic border border-green-100">Standby</span>
            </div>
            <i class="fas fa-user-gear absolute -right-4 -bottom-4 text-8xl text-slate-50 group-hover:text-slate-100 transition-colors"></i>
        </div>

        <div class="bg-white p-8 rounded-[45px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group hover:border-orange-500 transition-all border-2">
            @if(in_array($user->role, ['manager', 'hrd', 'akuntan']))
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Rata-rata Gaji</p>
                    <h2 class="text-2xl font-black text-slate-900 italic tracking-tighter leading-none">
                        Rp {{ number_format(($stats->total_biaya ?? 0) / ($totalPegawai ?: 1), 0, ',', '.') }}
                    </h2>
                </div>
            @else
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">ID Database</p>
                    <h2 class="text-2xl font-black text-slate-900 italic tracking-tighter leading-none">#{{ $user->id_pengguna }}</h2>
                </div>
            @endif
            <div class="mt-4">
                <span class="text-[10px] font-black text-orange-600 uppercase italic tracking-widest">{{ date('M Y') }}</span>
            </div>
            <i class="fas fa-id-card absolute -right-4 -bottom-4 text-8xl text-slate-50 group-hover:text-orange-50/50 transition-colors"></i>
        </div>
    </div>

    @if(in_array($user->role, ['manager', 'hrd', 'akuntan']))
    <div class="bg-white rounded-[55px] p-10 border border-slate-100 shadow-sm mb-10">
        <h3 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter mb-8">Analisis Tren Gaji</h3>
        <div class="h-64"><canvas id="mainChart"></canvas></div>
    </div>
    @endif

    {{-- BOTTOM SECTION --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <div class="lg:col-span-2 bg-white rounded-[55px] p-10 border border-slate-100 shadow-sm">
            @if(in_array($user->role, ['manager', 'hrd', 'akuntan']))
                <h3 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter mb-8">Status Distribusi Gaji</h3>
                <div class="space-y-4">
                    @foreach($users as $u)
                    <div class="flex items-center justify-between p-4 bg-slate-50/50 rounded-3xl border border-slate-100 hover:bg-white hover:shadow-md transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-orange-600 rounded-xl flex items-center justify-center font-black text-white text-xs italic shadow-sm">
                                {{ strtoupper(substr($u->nama, 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-800 uppercase italic tracking-tighter">{{ $u->nama }}</p>
                                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">{{ $u->role }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-green-100 text-green-600 text-[9px] font-black rounded-lg uppercase italic border border-green-200">Paid</span>
                    </div>
                    @endforeach
                </div>
                <div class="mt-6">{{ $users->links() }}</div>
            @else
                <h3 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter mb-8">Informasi Kerja</h3>
                <div class="bg-slate-50 p-8 rounded-[40px] border-2 border-dashed border-slate-200 text-center">
                    <i class="fas fa-toolbox text-4xl text-slate-300 mb-4"></i>
                    <p class="text-sm font-bold text-slate-500 uppercase italic">Unit Maintenance Sedang Berjalan</p>
                </div>
            @endif
        </div>

        {{-- WORKSHOP INFO & REMINDER BOX --}}
        <div class="bg-slate-900 rounded-[55px] p-10 text-white shadow-2xl relative overflow-hidden flex flex-col">
            <h3 class="text-xl font-black uppercase italic tracking-tighter mb-8 text-orange-500">Workshop Info</h3>
            
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

    @if(in_array($user->role, ['manager', 'hrd', 'akuntan']))
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('mainChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(234, 88, 12, 0.3)');
        gradient.addColorStop(1, 'rgba(234, 88, 12, 0)');

        const chartData = @json(\App\Models\statistik_bulanan::orderBy('bulan', 'asc')->pluck('total_biaya'));
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
                    pointBackgroundColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { display: false },
                    x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { weight: 'bold', size: 10 } } }
                }
            }
        });
    </script>
    @endif
@endsection