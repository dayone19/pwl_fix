<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Kru | PayTato</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .mesh-bg { 
            background-color: #0f172a; 
            background-image: radial-gradient(at 50% 50%, hsla(25,95%,30%,1) 0, transparent 80%), 
                            radial-gradient(at 0% 0%, hsla(210,40%,15%,1) 0, transparent 50%); 
        }
        input[type="radio"]:checked + label {
            border-color: #ea580c;
            background-color: #fff7ed;
            color: #9a3412;
        }
        .oil-smudge {
            filter: grayscale(1) opacity(0.05);
            background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');
        }
    </style>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4 md:p-6">
    <div class="w-full max-w-6xl bg-white rounded-[60px] shadow-2xl overflow-hidden grid md:grid-cols-2 min-h-[700px]">
        
        <div class="mesh-bg p-12 text-white flex flex-col justify-between relative overflow-hidden">
            <div class="absolute inset-0 oil-smudge"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-12">
                    <div class="bg-orange-600 p-2 rounded-xl text-white shadow-lg shadow-orange-900/50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-width="2"></path>
                        </svg>
                    </div>
                    <span class="font-extrabold text-2xl tracking-tighter uppercase italic text-white leading-none">
                        PAY<span class="text-orange-500">TATO</span>
                    </span>
                </div>
                
                <h1 class="text-5xl font-black leading-none tracking-tighter uppercase italic">
                    Precision in <br>Every <span class="text-orange-500">Payroll.</span>
                </h1>
            </div>

            <div class="absolute -bottom-20 -left-20 opacity-10 transform rotate-12">
                <svg class="w-80 h-80 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41l-0.36,2.54c-0.59,0.24-1.13,0.57-1.62,0.94L5.24,5.33c-0.22-0.07-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.84,9.48l2.03,1.58C4.82,11.36,4.8,11.68,4.8,12c0,0.32,0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.07,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z"/></svg>
            </div>
        </div>

        <div class="p-8 md:p-16 flex flex-col justify-center overflow-y-auto">
            <div class="mb-8">
                <h3 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter">Login Kru</h3>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] mt-2 leading-none">Otoritasi Identitas Teknisi & Staff</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-xl">
                    <p class="text-xs font-bold text-red-600 uppercase italic">{{ $errors->first() }}</p>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf 
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Pilih Posisi :</label>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="relative">
                            <input type="radio" name="role" id="teknisi" value="teknisi" class="peer hidden" checked>
                            <label for="teknisi" class="flex flex-col p-4 border-2 border-slate-100 rounded-[25px] cursor-pointer transition-all hover:border-orange-200">
                                <span class="text-xs font-black uppercase italic leading-none">teknisi</span>
                                <span class="text-[9px] text-slate-400 mt-1 uppercase tracking-tighter">Payroll Check</span>
                            </label>
                        </div>
                        <div class="relative">
                            <input type="radio" name="role" id="akuntan" value="akuntan" class="peer hidden">
                            <label for="akuntan" class="flex flex-col p-4 border-2 border-slate-100 rounded-[25px] cursor-pointer transition-all hover:border-orange-200">
                                <span class="text-xs font-black uppercase italic leading-none">Akuntan</span>
                                <span class="text-[9px] text-slate-400 mt-1 uppercase tracking-tighter">Generate Payroll</span>
                            </label>
                        </div>
                        <div class="relative">
                            <input type="radio" name="role" id="hrd" value="hrd" class="peer hidden">
                            <label for="hrd" class="flex flex-col p-4 border-2 border-slate-100 rounded-[25px] cursor-pointer transition-all hover:border-orange-200">
                                <span class="text-xs font-black uppercase italic leading-none">HRD</span>
                                <span class="text-[9px] text-slate-400 mt-1 uppercase tracking-tighter">Data Management</span>
                            </label>
                        </div>
                        <div class="relative">
                            <input type="radio" name="role" id="manager" value="manager" class="peer hidden">
                            <label for="manager" class="flex flex-col p-4 border-2 border-slate-100 rounded-[25px] cursor-pointer transition-all hover:border-orange-200">
                                <span class="text-xs font-black uppercase italic leading-none">Manager</span>
                                <span class="text-[9px] text-slate-400 mt-1 uppercase tracking-tighter">Approve Request</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- NIP -->
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic">NIP / ID Karyawan</label>
                        <input type="text" name="nip" id="nipInput" value="{{ old('nip') }}" required
                            class="w-full mt-2 px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-orange-600 outline-none transition font-semibold" 
                            placeholder="Contoh: 123456">
                        <p id="nipHint" class="opacity-0 text-red-500 text-[11px] mt-2 ml-2 italic font-medium transition-all duration-300">
                            • minimal 6 digit angka
                        </p>
                    </div>

                    <!-- Pass-Key -->
                    <div>
                        <div class="flex justify-between items-center ml-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic">Pass-Key</label>
                        </div>
                        <div class="relative mt-2">
                            <input type="password" name="kata_sandi" id="passwordInput" required
                                class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-orange-600 outline-none transition font-semibold" 
                                placeholder="••••••••">
                            
                            <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-orange-600 transition p-2">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>

                        <!-- Container Checklist -->
                        <div id="passwordFeedback" class="mt-3 ml-2 opacity-0 transition-all duration-300">
                            <ul id="passwordError" class="space-y-1">
                                <li id="reqLen" class="text-[11px] text-red-500 flex items-center gap-2 transition-colors italic">
                                    <span>•</span> Minimal 8 karakter
                                </li>
                                <li id="reqUpper" class="text-[11px] text-red-500 flex items-center gap-2 transition-colors italic">
                                    <span>•</span> Minimal 1 huruf besar
                                </li>
                                <li id="reqNum" class="text-[11px] text-red-500 flex items-center gap-2 transition-colors italic">
                                    <span>•</span> Minimal 1 angka
                                </li>
                            </ul>
                            <!-- Teks Valid yang akan muncul -->
                            <p id="pwValidText" class="hidden text-[11px] font-bold text-green-500 italic">✓ Password Valid</p>
                        </div>
                    </div>
                
                <button type="submit" class="w-full bg-slate-900 text-white py-5 rounded-[25px] font-black shadow-xl shadow-orange-900/10 hover:bg-orange-600 transition transform active:scale-[0.97] uppercase text-[10px] tracking-[0.3em] italic">
                    Masuk Dashboard →
                </button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                
                // ICON MATA TERBUKA
                eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                `;
            } else {
                passwordInput.type = 'password';
                
                // ICON MATA TERTUTUP
                eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                `;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const nipInput = document.getElementById('nipInput');
            const nipHint = document.getElementById('nipHint');
            const passwordInput = document.getElementById('passwordInput');
            const passwordError = document.getElementById('passwordError');
            const pwValidText = document.getElementById('pwValidText'); 
            // PERBAIKAN: Tambahkan variabel feedback ini
            const passwordFeedback = document.getElementById('passwordFeedback');

            // --- 1. LOGIKA VALIDASI NIP ---
            if (nipInput) {
                nipInput.addEventListener('focus', function() {
                    nipHint.classList.replace('opacity-0', 'opacity-100');
                });

                nipInput.addEventListener('input', function() {
                    const isValid = /^\d{6,}$/.test(this.value);
                    if (isValid) {
                        nipHint.innerText = "✓ NIP Valid"; 
                        nipHint.classList.replace('text-red-500', 'text-green-500');
                        nipHint.classList.add('font-bold');
                        this.classList.replace('border-slate-100', 'border-green-500');
                        this.classList.remove('border-red-400');
                    } else {
                        nipHint.innerText = "• silahkan masukkan minimal 6 digit angka";
                        nipHint.classList.replace('text-green-500', 'text-red-500');
                        nipHint.classList.remove('font-bold');
                        this.classList.remove('border-green-500');
                        if (this.value.length > 0) {
                            this.classList.add('border-red-400');
                        } else {
                            this.classList.add('border-slate-100');
                            this.classList.remove('border-red-400');
                        }
                    }
                });
            }

            // --- 2. LOGIKA VALIDASI PASSWORD ---
            if (passwordInput) {
                passwordInput.addEventListener('focus', function() {
                    // Gunakan passwordFeedback sesuai ID di HTML
                    passwordFeedback.classList.replace('opacity-0', 'opacity-100');
                    checkPassword(this.value);
                });

                passwordInput.addEventListener('input', function() {
                    checkPassword(this.value);
                });
            }

            function checkPassword(val) {
                const check = {
                    reqLen: val.length >= 8,
                    reqUpper: /[A-Z]/.test(val),
                    reqNum: /[0-9]/.test(val)
                };

                let allValid = true;
                for (const [id, isValid] of Object.entries(check)) {
                    updateStatus(id, isValid);
                    if (!isValid) allValid = false;
                }

                if (allValid && val.length > 0) {
                    passwordError.classList.add('hidden');
                    pwValidText.classList.remove('hidden');
                    
                    passwordInput.classList.replace('focus:ring-orange-600', 'focus:ring-green-500');
                    passwordInput.classList.replace('border-slate-100', 'border-green-500');
                    passwordInput.classList.remove('border-red-400');
                } else {
                    passwordError.classList.remove('hidden');
                    pwValidText.classList.add('hidden');

                    passwordInput.classList.replace('focus:ring-green-500', 'focus:ring-orange-600');
                    passwordInput.classList.remove('border-green-500');
                    if (val.length > 0) {
                        passwordInput.classList.add('border-red-400');
                    } else {
                        passwordInput.classList.add('border-slate-100');
                        passwordInput.classList.remove('border-red-400');
                    }
                }
            }

            function updateStatus(id, isValid) {
                const el = document.getElementById(id);
                if (!el) return;
                if (isValid) {
                    el.classList.remove('text-red-500');
                    el.classList.add('text-green-500', 'font-bold');
                } else {
                    el.classList.remove('text-green-500', 'font-bold');
                    el.classList.add('text-red-500');
                }
            }
        });
    </script>
    <style>
        input::-ms-reveal,
        input::-ms-clear {
            display: none;
        }
        input::-webkit-contacts-auto-fill-button,
        input::-webkit-credentials-auto-fill-button {
            visibility: hidden;
            pointer-events: none;
            position: absolute;
            right: 0;
        }
    </style>
</body>
</html>