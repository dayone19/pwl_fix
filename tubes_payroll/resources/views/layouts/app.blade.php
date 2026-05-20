<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PayTato | Workshop Management System')</title>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f1f5f9; }

        /* --- SIDEBAR & ANIMASI --- */
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .gear-rotate { 
            animation: spin-slow 25s linear infinite; 
            opacity: 0.04; 
        }

        #sidebar { 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background-color: #0f172a;
            background-image: radial-gradient(at 0% 100%, hsla(25,95%,35%,0.2) 0, transparent 50%);
        }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { 
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .nav-mask {
            mask-image: linear-gradient(to bottom, black 85%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, black 85%, transparent 100%);
        }
        
        .sidebar-item-active { 
            background: linear-gradient(to right, rgba(234, 88, 12, 0.2), transparent);
            border-right: 4px solid #ea580c; 
            color: #fb923c !important; 
        }

        #main-content { transition: margin-left 0.4s ease-in-out; }
        .sidebar-closed { transform: translateX(-100%); }
        .main-full { margin-left: 0 !important; }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="flex min-h-screen overflow-x-hidden">

    <aside id="sidebar" class="w-72 text-slate-400 p-8 flex flex-col fixed h-full z-50 shadow-2xl overflow-hidden">
        <i class="fas fa-cog gear-rotate absolute -right-12 -top-12 text-[220px] text-white pointer-events-none"></i>
        <i class="fas fa-wrench gear-rotate absolute -left-10 bottom-40 text-[120px] text-white pointer-events-none" style="animation-duration: 40s; opacity: 0.02;"></i>

        <div class="relative z-10 flex flex-col h-full">
            <div class="flex items-center justify-between mb-12">
                <div class="flex items-center gap-3">
                    <div class="bg-orange-600 p-2.5 rounded-2xl text-white shadow-lg shadow-orange-900/50">
                        <i class="fas fa-screwdriver-wrench text-xl"></i>
                    </div>
                    <span class="font-black text-xl text-white italic tracking-tighter uppercase leading-none">
                        Pay<span class="text-orange-500">Tato</span>
                    </span>
                </div>
                <button onclick="toggleSidebar()" class="lg:hidden text-slate-500 hover:text-white">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <nav class="flex-1 space-y-8 overflow-y-auto no-scrollbar nav-mask">
                {{-- SECTION: MONITORING --}}
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] mb-4 text-slate-600 flex items-center gap-2">
                        <i class="fas fa-gauge-high text-[8px]"></i> Monitoring
                    </p>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'sidebar-item-active' : '' }} flex items-center gap-4 p-4 rounded-2xl text-sm font-bold transition hover:text-white group">
                                <i class="fas fa-desktop w-5 transition group-hover:text-orange-500"></i>
                                Dashboard Utama
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- SECTION: WORKSHOP AREA --}}
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] mb-4 text-slate-600 flex items-center gap-2">
                        <i class="fas fa-toolbox text-[8px]"></i> Workshop Area
                    </p>
                    <ul class="space-y-2">
                        {{-- DATA MEKANIK & ABSENSI: MANAJEMEN & HRD --}}
                        @if(in_array(Str::upper(Auth::user()->divisi?->nama_divisi), ['MANAJEMEN', 'HRD']))
                        <li>
                            <a href="{{ route('karyawan.index') }}" 
                            class="{{ (request()->routeIs('karyawan.index') || request()->routeIs('karyawan.show')) ? 'sidebar-item-active' : '' }} flex items-center gap-4 p-4 hover:bg-white/5 rounded-2xl text-sm font-bold transition group">
                                <i class="fas fa-user-gear w-5 group-hover:text-orange-400"></i> Data teknisi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('absensi.index') }}" class="{{ request()->routeIs('absensi.*') ? 'sidebar-item-active' : '' }} flex items-center gap-4 p-4 hover:bg-white/5 rounded-2xl text-sm font-bold transition group">
                                <i class="fas fa-stopwatch w-5 group-hover:text-orange-400"></i> Rekap Absensi
                            </a>
                        </li>
                        @endif

                        {{-- PAYROLL & INSENTIF & CUTI: Semua Divisi --}}
                        <li>
                            <a href="{{ route('payroll.index') }}" class="{{ request()->routeIs('payroll.index') ? 'sidebar-item-active' : '' }} flex items-center gap-4 p-4 hover:bg-white/5 rounded-2xl text-sm font-bold transition group">
                                <i class="fas fa-file-invoice-dollar w-5 group-hover:text-orange-400"></i> Payroll & Insentif
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cuti.index') }}" class="{{ request()->routeIs('cuti.index') ? 'sidebar-item-active' : '' }} flex items-center gap-4 p-4 hover:bg-white/5 rounded-2xl text-sm font-bold transition group">
                                <i class="fas fa-calendar-day w-5 group-hover:text-orange-400"></i> Manajemen Cuti
                            </a>
                        </li>
                        
                        {{-- KELOLA GAJI: MANAJEMEN & FINANCE --}}
                        @if(in_array(Str::upper(Auth::user()->divisi?->nama_divisi), ['MANAJEMEN', 'FINANCE']))
                        <li>
                            <a href="{{ route('payroll.manage') }}" class="{{ request()->routeIs('payroll.manage') ? 'sidebar-item-active' : '' }} flex items-center gap-4 p-4 hover:bg-white/5 rounded-2xl text-sm font-bold transition group">
                                <i class="fas fa-calculator w-5 group-hover:text-orange-400"></i> Kelola Gaji
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>

                {{-- SECTION: SYSTEM: MANAJEMEN & HRD --}}
                @if(in_array(Str::upper(Auth::user()->divisi?->nama_divisi), ['MANAJEMEN', 'HRD']))
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] mb-4 text-slate-600 flex items-center gap-2">
                        <i class="fas fa-gears text-[8px]"></i> System
                    </p>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('users.index') }}" 
                            class="{{ (request()->routeIs('users.*') || request()->routeIs('karyawan.create')) ? 'sidebar-item-active' : '' }} flex items-center gap-4 p-4 hover:bg-white/5 rounded-2xl text-sm font-bold transition group">
                                <i class="fas fa-key w-5 group-hover:text-orange-400"></i> Akses Kontrol
                            </a>
                        </li>
                    </ul>
                </div>
                @endif
            </nav>

            <div class="pt-6 border-t border-white/5 mt-auto">
                <div class="bg-white/5 p-4 rounded-3xl border border-white/5 mb-4 group hover:bg-white/10 transition-all cursor-default">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-2xl overflow-hidden border border-orange-500/30">
                                <img src="{{ asset('img/profil/' . (Auth::user()->foto ?? 'default.jpg')) }}" class="w-full h-full object-cover">
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 border-2 border-[#0f172a] rounded-full"></div>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[10px] font-black text-white truncate uppercase italic leading-none mb-1">
                                {{ Auth::user()->nama }}
                            </p>
                            <p class="text-[9px] text-slate-500 truncate uppercase tracking-widest">
                                {{ Auth::user()->divisi?->nama_divisi ?? 'Tanpa Divisi' }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                        class="w-full flex items-center gap-4 p-4 text-red-400/70 hover:text-red-400 hover:bg-red-500/5 rounded-2xl text-[10px] font-black uppercase tracking-widest transition group">
                    <i class="fas fa-power-off w-5 group-hover:scale-110 transition"></i>
                    Matikan Mesin (Logout)
                </button>
            </div>
        </div>
    </aside>

    <main id="main-content" class="ml-72 flex-1 p-6 md:p-10">
        <header class="flex items-center justify-between mb-10">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="p-4 bg-white border border-slate-200 rounded-[20px] shadow-sm hover:shadow-md transition-all text-slate-600 focus:outline-none flex items-center gap-3 group">
                    <i class="fas fa-bars-staggered text-lg text-orange-600 group-hover:rotate-180 transition-all duration-500"></i>
                </button>
                <div class="hidden md:block">
                    <h1 class="text-sm font-black text-slate-900 uppercase italic tracking-tighter">PayTato Dashboard</h1>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">Sistem Manajemen Bengkel</p>
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

        <div class="relative min-h-[80vh]">
            @yield('content')
        </div>

        <footer class="mt-20 pt-8 border-t border-slate-200 flex flex-col md:flex-row justify-between items-center gap-4 opacity-50">
            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">© 2026 PayTato Pay System</p>
        </footer>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            sidebar.classList.toggle('sidebar-closed');
            mainContent.classList.toggle('main-full');
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth < 1024) {
                const sb = document.getElementById('sidebar');
                const mc = document.getElementById('main-content');
                if(sb) sb.classList.add('sidebar-closed');
                if(mc) mc.classList.add('main-full');
            } else {
                const sb = document.getElementById('sidebar');
                const mc = document.getElementById('main-content');
                if(sb) sb.classList.remove('sidebar-closed');
                if(mc) mc.classList.remove('main-full');
            }
        });
    </script>
</body>
</html>