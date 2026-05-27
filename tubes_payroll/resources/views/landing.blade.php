<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayTato | Workshop Payroll System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Smooth Custom Floating Animations */
        @keyframes subtleFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        @keyframes smoothRotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .animate-subtle-float { animation: subtleFloat 4s ease-in-out infinite; }
        .animate-gear-smooth { animation: smoothRotate 10s linear infinite; }
        .animate-gear-reverse { animation: smoothRotate 15s linear infinite reverse; }

        .premium-text-gradient {
            background: linear-gradient(135deg, #1e293b 30%, #ea580c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .dashboard-glow {
            background: radial-gradient(circle at top left, rgba(234, 88, 12, 0.15) 0%, transparent 60%);
        }
    </style>
</head>
<body class="bg-[#fafafa] text-slate-900 antialiased selection:bg-orange-500 selection:text-white">

    {{-- NAVBAR SECTION --}}
    <nav class="fixed w-full z-50 bg-white/70 backdrop-blur-md border-b border-slate-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 h-20 flex justify-between items-center">
            <div class="flex items-center gap-3 group cursor-pointer">
                <div class="bg-orange-600 p-2 rounded-xl text-white shadow-md shadow-orange-500/20 group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <span class="font-bold text-xl tracking-tight uppercase text-slate-900">
                    Pay<span class="text-orange-600">Tato</span>
                </span>
            </div>
            
            <div class="hidden md:flex gap-8 text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                <a href="#roles" class="hover:text-slate-900 transition-colors duration-200">Struktur Divisi</a>
            </div>

            <div>
                <a href="/login" class="inline-flex bg-slate-900 text-white hover:bg-orange-600 px-6 py-2.5 rounded-xl text-xs font-semibold tracking-wider uppercase transition-colors duration-300 shadow-sm">
                    Sign In
                </a>
            </div>
        </div>
    </nav>

{{-- HERO SECTION --}}
    <section class="pt-40 pb-24 px-6 lg:px-12 max-w-7xl mx-auto overflow-hidden">
        <div class="grid lg:grid-cols-12 gap-16 items-center">
            
            <div class="lg:col-span-5 space-y-8 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-orange-50 rounded-full border border-orange-100 text-[10px] font-bold uppercase tracking-widest text-orange-600 shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                    Professional Workshop Engine
                </div>

                <h1 class="text-5xl md:text-6xl font-black tracking-tight text-slate-900 leading-[1.05] uppercase">
                    Bengkel Rapi,<br>
                    <span class="premium-text-gradient">Gaji Pasti.</span>
                </h1>

                <p class="text-sm md:text-base text-slate-500 font-normal leading-relaxed max-w-md mx-auto lg:mx-0">
                    Sistem otomasi manajemen penggajian digital terpadu untuk Bengkel TATO. Memastikan transparansi komisi teknisi, tunjangan magang, dan laporan akuntansi secara instan.
                </p>

                <div class="flex flex-wrap gap-4 justify-center lg:justify-start pt-2">
                    <a href="/login" class="group bg-slate-900 hover:bg-orange-600 text-white px-8 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest transition-all duration-300 flex items-center gap-3 shadow-lg shadow-slate-900/10">
                        Buka Panel Kontrol
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-7 relative">
                <div class="absolute -inset-4 bg-orange-500/10 rounded-[50px] blur-3xl opacity-70"></div>
                
                <div class="bg-slate-950 w-full aspect-[4/3] rounded-[40px] shadow-2xl relative overflow-hidden p-8 border border-slate-900 dashboard-glow animate-subtle-float">
                    <div class="w-full h-full flex flex-col justify-between">
                        
                        <div class="flex justify-between items-center pb-4 border-b border-slate-900">
                            <div class="flex gap-2">
                                <div class="w-2.5 h-2.5 rounded-full bg-slate-800"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-slate-800"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-slate-800"></div>
                            </div>
                            <span class="text-[9px] text-slate-600 font-mono tracking-widest uppercase">Paytato</span>
                        </div>

            {{-- Date and Clock Card --}}
            <div class="bg-white/[0.02] border border-white/5 rounded-3xl p-6 space-y-4">
                <div class="text-[9px] text-orange-500 font-black uppercase tracking-widest" id="time-label">Waktu Operasional Kerja</div>
                
                <div class="space-y-1">
                    <div class="text-4xl font-extrabold text-white tracking-tight" id="live-clock">
                        00:00:00
                    </div>
                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider" id="live-date">
                        Memuat tanggal...
                    </div>
                </div>
                
                <div class="w-full bg-slate-900 h-1 rounded-full overflow-hidden">
                    <div class="bg-orange-500 h-full rounded-full transition-all duration-1000" id="progress-bar" style="width: 0%"></div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                {{-- Box 1: Jumlah Karyawan Aktif --}}
                <div class="bg-white/[0.01] border border-white/5 rounded-2xl p-4 flex flex-col justify-between h-24">
                    <span class="text-[9px] text-slate-500 uppercase font-bold tracking-wider">Karyawan Aktif</span>
                    <span class="text-2xl font-black text-white tracking-tight">
                        {{ $totalKaryawan ?? 142 }} <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wide">Kru</span>
                    </span>
                </div>
                
                {{-- Box 2: Jumlah Job Offer di Job Pool (Model Pekerjaan) --}}
                <div class="bg-white/[0.01] border border-white/5 rounded-2xl p-4 flex flex-col justify-between h-24">
                    <span class="text-[9px] text-slate-500 uppercase font-bold tracking-wider">Job Pool</span>
                    <span class="text-2xl font-black text-orange-500 tracking-tight">
                        {{ $totalJobOffers ?? 8 }} <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wide">Posisi</span>
                    </span>
                </div>
            </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ROLES / DEPARTEMEN SECTION --}}
    <section id="roles" class="py-28 px-6 lg:px-12 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto space-y-16">
            
            <div class="flex flex-col md:flex-row justify-between items-baseline gap-4 border-b border-slate-100 pb-8">
                <div class="space-y-1">
                    <p class="text-[10px] text-orange-600 font-bold uppercase tracking-widest">Aksesibilitas Multi-Role</p>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight uppercase">Struktur Divisi</h2>
                </div>
                <div class="text-slate-400 font-mono text-[10px] tracking-widest uppercase"></div>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                {{-- HRD --}}
                <div class="bg-[#fafafa] p-8 rounded-3xl border border-slate-100 hover:border-orange-500/30 hover:bg-white hover:shadow-xl hover:shadow-slate-100 transition-all duration-300 group">
                    <div class="text-slate-400 group-hover:text-orange-600 mb-6 transition-colors duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-sm uppercase text-slate-900 mb-2">Human Resources</h3>
                    <p class="text-slate-500 text-xs leading-relaxed font-normal">Manajemen penuh data karyawan, absensi real-time, dan pengawasan kuota cuti struktural.</p>
                </div>

                {{-- Accountant --}}
                <div class="bg-[#fafafa] p-8 rounded-3xl border border-slate-100 hover:border-orange-500/30 hover:bg-white hover:shadow-xl hover:shadow-slate-100 transition-all duration-300 group">
                    <div class="text-slate-400 group-hover:text-orange-600 mb-6 transition-colors duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-sm uppercase text-slate-900 mb-2">Finances</h3>
                    <p class="text-slate-500 text-xs leading-relaxed font-normal">Pemrosesan komponen gaji bersih, hitungan otomatis insentif tetap, serta potongan denda alpha.</p>
                </div>

                {{-- Manager --}}
                <div class="bg-[#fafafa] p-8 rounded-3xl border border-slate-100 hover:border-orange-500/30 hover:bg-white hover:shadow-xl hover:shadow-slate-100 transition-all duration-300 group">
                    <div class="text-slate-400 group-hover:text-orange-600 mb-6 transition-colors duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-sm uppercase text-slate-900 mb-2">Managements</h3>
                    <p class="text-slate-500 text-xs leading-relaxed font-normal">Otorisasi persetujuan pencairan dana (*payroll approval*) dan analisis pengeluaran anggaran bulanan.</p>
                </div>

                {{-- Mechanic --}}
                <div class="bg-[#fafafa] p-8 rounded-3xl border border-slate-100 hover:border-orange-500/30 hover:bg-white hover:shadow-xl hover:shadow-slate-100 transition-all duration-300 group">
                    <div class="text-slate-400 group-hover:text-orange-600 mb-6 transition-colors duration-300">
                        <i class="fas fa-wrench text-2xl w-8 h-8 flex items-center justify-center transition group-hover:text-orange-400"></i>
                    </div>
                    <h3 class="font-bold text-sm uppercase text-slate-900 mb-2">Automotive Technician</h3>
                    <p class="text-slate-500 text-xs leading-relaxed font-normal">Akses personal untuk melacak sisa hari kuota cuti serta memeriksa status pembayaran gaji bulanan.</p>
                </div>

            </div>
        </div>
    </section>

    {{-- CTA FOOTPRINT SECTION --}}
    <section class="py-24 px-6 lg:px-12 bg-[#fafafa]">
        <div class="max-w-5xl mx-auto relative group">
            
            <div class="absolute -inset-4 bg-orange-500/10 rounded-[50px] blur-3xl opacity-70 group-hover:opacity-100 transition duration-700 pointer-events-none"></div>

            <div class="relative overflow-hidden rounded-[40px] bg-slate-950 border border-slate-900 shadow-2xl p-12 md:p-20 text-center">
                
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_var(--tw-gradient-stops))] from-orange-500/15 via-transparent to-transparent pointer-events-none"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_right,_var(--tw-gradient-stops))] from-orange-500/12 via-transparent to-transparent pointer-events-none"></div>
                
                <div class="relative z-10 space-y-8">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/[0.02] border border-white/5 rounded-full text-[9px] font-mono tracking-widest text-slate-500 uppercase">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-800 animate-pulse"></span>
                        PayTato
                    </div>

                    <h2 class="text-4xl md:text-5xl font-black tracking-tight leading-[1.1] text-white uppercase">
                        Akurasi Perhitungan <br>
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500">
                            Tetap Terjaga
                        </span>
                    </h2>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                        <a href="/login" class="group relative px-8 py-3.5 bg-orange-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest overflow-hidden transition-all duration-300 hover:bg-orange-500 hover:shadow-[0_0_35px_-5px_rgba(234,88,12,0.4)] active:scale-95">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                Sign in
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                        </a>
                    </div>
                </div>

                <div class="absolute -left-14 -bottom-14 text-white/[0.01] pointer-events-none">
                    <svg class="w-56 h-56 animate-gear-smooth" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41l-0.36,2.54c-0.59,0.24-1.13,0.57-1.62,0.94L5.24,5.33c-0.22-0.07-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.84,9.48l2.03,1.58C4.82,11.36,4.8,11.68,4.8,12c0,0.32,0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96c0.22,0.07,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.5c-1.93,0-3.5-1.57-3.5-3.5 s1.57-3.5,3.5-3.5s3.5,1.57,3.5,3.5S13.93,15.5,12,15.5z"/>
                    </svg>
                </div>
                
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="py-12 border-t border-slate-100 text-center bg-white">
        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.3em]">&copy; 2026 PayTato. Professional Workshop System. Built for Precision.</p>
    </footer>

</body>
    <script>
        function startRealTimeClock() {
            const clockElement = document.getElementById('live-clock');
            const dateElement = document.getElementById('live-date');
            const progressBar = document.getElementById('progress-bar');
            
            if (!clockElement || !dateElement || !progressBar) return;

            const JAM_BUKA = 8; 
            const JAM_TUTUP = 20; 

            setInterval(() => {
                const now = new Date();

                const timeOptions = {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                };
                let formattedTime = new Intl.DateTimeFormat('id-ID', timeOptions).format(now);
                clockElement.innerText = formattedTime.replace('.', ':');

                const dateOptions = {
                    weekday: 'long',
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                };
                let formattedDate = new Intl.DateTimeFormat('id-ID', dateOptions).format(now);
                dateElement.innerText = formattedDate;

                const currentHour = now.getHours();
                const currentMinute = now.getMinutes();
                const currentSecond = now.getSeconds();

                const totalDetikSekarang = (currentHour * 3600) + (currentMinute * 60) + currentSecond;
                const totalDetikBuka = JAM_BUKA * 3600;
                const totalDetikTutup = JAM_TUTUP * 3600;

                let percentage = 0;

                if (currentHour < JAM_BUKA) {
                    percentage = 0;
                } else if (currentHour >= JAM_TUTUP) {
                    percentage = 100;
                } else {
                    const detikBerjalan = totalDetikSekarang - totalDetikBuka;
                    const totalDurasiKerja = totalDetikTutup - totalDetikBuka;
                    percentage = (detikBerjalan / totalDurasiKerja) * 100;
                }

                progressBar.style.width = percentage.toFixed(2) + '%';

            }, 1000);
        }

        document.addEventListener('DOMContentLoaded', startRealTimeClock);
    </script>
</html>