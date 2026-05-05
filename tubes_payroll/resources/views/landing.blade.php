<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayTato | Workshop Payroll System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* --- Kumpulan Animasi Kustom --- */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes gear-rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .animate-float { animation: float 3s ease-in-out infinite; }
        .animate-slide-in { animation: slideIn 0.8s ease-out forwards; }
        .animate-gear { animation: gear-rotate 4s linear infinite; }
        
        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.4s; }

        /* Styling Visual */
        .mesh-gradient-text {
            background: linear-gradient(90deg, #f97316, #fbbf24, #475569);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .mesh-bg-garage {
            background-color: #0f172a;
            background-image: 
                radial-gradient(at 0% 0%, hsla(25,95%,50%,1) 0, transparent 50%), 
                radial-gradient(at 100% 100%, hsla(210,40%,20%,1) 0, transparent 50%);
        }

        .oil-smudge {
            filter: grayscale(1) opacity(0.1);
            background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');
        }
    </style>
</head>
<body class="bg-[#fcfcfc] text-slate-900 antialiased">

    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-orange-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-2 group cursor-pointer">
    <div class="bg-orange-600 p-1.5 rounded-lg text-white shadow-lg shadow-orange-200 group-hover:rotate-12 transition-transform duration-300">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
    </div>
    <span class="font-extrabold text-2xl tracking-tighter uppercase italic text-slate-900 leading-none">
        Pay<span class="text-orange-600">Tato</span>
    </span>
</div>
            <div class="hidden md:flex gap-8 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">
                <a href="#roles" class="hover:text-orange-600 transition">Jabatan Kerja</a>
            </div>
            <div class="flex items-center gap-4">
                <a href="/login" class="bg-orange-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-orange-200 transition transform hover:-rotate-2">Login</a>
            </div>
        </div>
    </nav>

    <section class="pt-32 pb-20 px-6 overflow-hidden">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 items-center">
            
            <div class="relative z-10">
                <span class="animate-float inline-block px-4 py-2 bg-orange-50 text-orange-600 rounded-lg text-[10px] font-bold uppercase tracking-[0.2em] mb-6 border border-orange-100 shadow-sm">
                    Professional Workshop Payroll
                </span>

                <h1 class="animate-slide-in opacity-0 text-6xl md:text-7xl font-black leading-[1.0] tracking-tighter mb-6 uppercase italic">
                    Bengkel Rapi, <br>
                    <span class="mesh-gradient-text">Gaji Pasti.</span>
                </h1>

                <p class="animate-slide-in opacity-0 delay-1 text-lg text-slate-500 mb-10 leading-relaxed max-w-lg">
                    Sistem payroll khusus bengkel TATO - Teknisi Aktif Teruji Otomotif yang menampilkan hasil perhitungan gaji secara akurat dalam satu platform melalui <i>PayTato</i>.
                </p>

                <div class="animate-slide-in opacity-0 delay-2 flex flex-wrap gap-4">
                    <a href="/login" class="bg-slate-900 text-white px-8 py-4 rounded-xl font-bold shadow-2xl transition-all duration-300 hover:bg-orange-600 hover:-translate-y-1 flex items-center gap-3">
                        Buka Panel Kontrol
                        <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="relative">
                <div class="mesh-bg-garage w-full aspect-square rounded-[40px] shadow-2xl relative overflow-hidden flex items-center justify-center p-8">
                    <div class="absolute inset-0 oil-smudge"></div>
                    <div class="bg-slate-900/40 backdrop-blur-2xl w-full h-full rounded-3xl border border-white/10 p-6 flex flex-col gap-4">
                        <div class="flex gap-2 mb-4">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-orange-500"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        </div>

                        <div class="h-24 bg-orange-600/20 rounded-2xl border border-orange-500/30 p-4 relative overflow-hidden">
                            <div class="text-[10px] text-orange-400 font-bold uppercase mb-1">Komisi Mekanik Hari Ini</div>
                            <div class="text-2xl font-black text-white italic">Rp 4.500.200</div>
                            <div class="absolute right-[-10px] bottom-[-10px] opacity-10">
                                <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="h-32 bg-slate-800 rounded-2xl border border-white/5 p-4">
                                <div class="w-8 h-1 bg-orange-500 mb-3"></div>
                                <div class="space-y-2">
                                    <div class="h-2 bg-white/10 rounded w-full"></div>
                                    <div class="h-2 bg-white/10 rounded w-4/5"></div>
                                    <div class="h-2 bg-white/10 rounded w-3/4"></div>
                                </div>
                            </div>
                            
                            <div class="h-32 bg-slate-800 rounded-2xl border border-white/5 p-4 flex items-center justify-center relative overflow-hidden group">
                                <div class="absolute inset-0 bg-orange-600/10 blur-2xl group-hover:bg-orange-600/20 transition-colors"></div>
                                <svg class="w-16 h-16 text-orange-600 animate-gear relative z-10" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41l-0.36,2.54c-0.59,0.24-1.13,0.57-1.62,0.94L5.24,5.33c-0.22-0.07-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.84,9.48l2.03,1.58C4.82,11.36,4.8,11.68,4.8,12c0,0.32,0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.07,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.5c-1.93,0-3.5-1.57-3.5-3.5 s1.57-3.5,3.5-3.5s3.5,1.57,3.5,3.5S13.93,15.5,12,15.5z"/>
                                </svg>
                                <div class="absolute bottom-2 text-[8px] text-slate-500 font-bold uppercase tracking-widest">PayTato Core</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="roles" class="py-24 px-6 bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                <div>
                    <h2 class="text-4xl font-black italic uppercase tracking-tighter mb-2">Kru PayTato</h2>
                    <p class="text-slate-400">Pembagian akses berdasarkan struktur bengkel modern.</p>
                </div>
                <div class="text-orange-500 font-bold text-sm tracking-[0.3em] uppercase">Status: System Online</div>
            </div>
            
            <div class="grid md:grid-cols-4 gap-4">
                <div class="bg-slate-800/50 p-8 rounded-3xl border border-white/5 hover:border-orange-500 transition-all group cursor-default text-center md:text-left">
                    <div class="text-orange-500 mb-6 group-hover:scale-110 transition inline-block md:block">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="1.5"></path></svg>
                    </div>
                    <h3 class="font-black italic uppercase mb-2">HR (Human Resources)</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">Atur data karyawan, absensi, dan penggajian.</p>
                </div>
                <div class="bg-slate-800/50 p-8 rounded-3xl border border-white/5 hover:border-orange-500 transition-all group cursor-default text-center md:text-left">
                    <div class="text-orange-500 mb-6 group-hover:scale-110 transition inline-block md:block">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-width="1.5"></path></svg>
                    </div>
                    <h3 class="font-black italic uppercase mb-2">Accountant</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">Hitung pembagian hasil jasa servis, komisi sparepart, dan gaji pokok.</p>
                </div>
                <div class="bg-slate-800/50 p-8 rounded-3xl border border-white/5 hover:border-orange-500 transition-all group cursor-default text-center md:text-left">
                    <div class="text-orange-500 mb-6 group-hover:scale-110 transition inline-block md:block">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a２ ２ ０ ０１－２ －２z" stroke-width="1.5"></path></svg>
                    </div>
                    <h3 class="font-black italic uppercase mb-2">Owner (Manager)</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">Pantau performa pit servis dan setujui pencairan dana PayTato.</p>
                </div>
                <div class="bg-slate-800/50 p-8 rounded-3xl border border-white/5 hover:border-orange-500 transition-all group cursor-default text-center md:text-left">
                    <div class="text-orange-500 mb-6 group-hover:scale-110 transition inline-block md:block">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" stroke-width="1.5"></path></svg>
                    </div>
                    <h3 class="font-black italic uppercase mb-2">Mekanik (Crew)</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">Cek slip gaji digital dan rincian bonus dari setiap unit kendaraan.</p>
                </div>
            </div>
        </div>
    </section>

<section class="py-24 px-6 bg-slate-50">
    <div class="max-w-6xl mx-auto relative group">
        
        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-orange-600 rounded-[50px] blur-2xl opacity-20 group-hover:opacity-30 transition duration-1000"></div>

        <div class="relative overflow-hidden rounded-[40px] bg-slate-900 border border-white/10 shadow-2xl p-12 md:p-20 text-center">
            
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-orange-500/20 via-transparent to-blue-900/40"></div>
            
            <div class="absolute inset-0 opacity-10 [mask-image:radial-gradient(ellipse_at_center,white,transparent)]">
                <svg width="100%" height="100%">
                    <pattern id="pattern-dots" width="20" height="20" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1" fill="white" />
                    </pattern>
                    <rect width="100%" height="100%" fill="url(#pattern-dots)" />
                </svg>
            </div>

            <div class="relative z-10">
                <h2 class="text-5xl md:text-7xl font-black mb-6 tracking-tighter leading-none text-white">
                    AKURASI <span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-400 to-orange-600">PERHITUNGAN</span>
                    <br>
                    <span class="inline-block hover:skew-x-2 transition-transform duration-300">TETAP TERJAGA!</span>
                </h2>
                

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/login" class="group relative px-8 py-4 bg-orange-600 text-white rounded-2xl font-bold text-lg overflow-hidden transition-all hover:scale-105 hover:shadow-[0_0_30px_-5px_rgba(234,88,12,0.6)] active:scale-95">
                        <span class="relative z-10 flex items-center gap-2">
                            Login Panel 
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                    </a>
                </div>
            </div>

            <div class="absolute -left-12 -bottom-12 text-blue-500/20 animate-spin-slow">
                <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41l-0.36,2.54c-0.59,0.24-1.13,0.57-1.62,0.94L5.24,5.33c-0.22-0.07-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.84,9.48l2.03,1.58C4.82,11.36,4.8,11.68,4.8,12c0,0.32,0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.07,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.5c-1.93,0-3.5-1.57-3.5-3.5 s1.57-3.5,3.5-3.5s3.5,1.57,3.5,3.5S13.93,15.5,12,15.5z"/></svg>
            </div>
            
            <div class="absolute -right-10 -top-10 text-orange-500/10 animate-spin-reverse">
                <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41l-0.36,2.54c-0.59,0.24-1.13,0.57-1.62,0.94L5.24,5.33c-0.22-0.07-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.84,9.48l2.03,1.58C4.82,11.36,4.8,11.68,4.8,12c0,0.32,0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.07,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.5c-1.93,0-3.5-1.57-3.5-3.5 s1.57-3.5,3.5-3.5s3.5,1.57,3.5,3.5S13.93,15.5,12,15.5z"/></svg>
            </div>

        </div>
    </div>
</section>

<style>
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    @keyframes spin-reverse {
        from { transform: rotate(360deg); }
        to { transform: rotate(0deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 25s linear infinite;
    }
    .animate-spin-reverse {
        animation: spin-reverse 20s linear infinite;
    }
</style>

    <footer class="py-12 border-t border-slate-200 text-center bg-white">
        <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.4em]">&copy; 2026 PayTato. Professional Workshop System. Build for Speed.</p>
    </footer>

</body>
</html>