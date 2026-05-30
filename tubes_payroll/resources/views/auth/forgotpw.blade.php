<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Access | PayTato</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .oil-smudge {
            filter: grayscale(1) opacity(0.05);
            background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');
        }

        /* Step indicator line */
        .step-line {
            height: 2px;
            background: #e2e8f0;
            flex: 1;
            margin: 0 6px;
            position: relative;
            overflow: hidden;
        }
        .step-line.active::after {
            content: '';
            position: absolute;
            inset: 0;
            background: #ea580c;
            animation: fillLine 0.4s ease forwards;
        }
        @keyframes fillLine {
            from { width: 0 }
            to   { width: 100% }
        }

        /* Pulse ring on icon */
        .pulse-ring {
            animation: pulseRing 2s ease infinite;
        }
        @keyframes pulseRing {
            0%,100% { box-shadow: 0 0 0 0 rgba(234,88,12,0.3); }
            50%      { box-shadow: 0 0 0 10px rgba(234,88,12,0); }
        }

        /* Shake on error */
        .shake {
            animation: shake 0.4s ease;
        }
        @keyframes shake {
            0%,100% { transform: translateX(0); }
            20%     { transform: translateX(-6px); }
            40%     { transform: translateX(6px); }
            60%     { transform: translateX(-4px); }
            80%     { transform: translateX(4px); }
        }

        /* Slide panels */
        .panel {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        .panel.hidden-panel {
            opacity: 0;
            pointer-events: none;
            transform: translateX(20px);
            position: absolute;
            inset: 0;
        }
        .panels-wrap {
            position: relative;
            min-height: 480px;
        }

        input::-webkit-contacts-auto-fill-button,
        input::-webkit-credentials-auto-fill-button {
            visibility: hidden !important;
            pointer-events: none !important;
            position: absolute !important;
        }
       
        /* Hilangkan scrollbar */
        ::-webkit-scrollbar {
            display: none;
        }

        html, body {
            -ms-overflow-style: none;  /* IE & Edge lama */
            scrollbar-width: none;     /* Firefox */
        }
    </style>
</head>
<body class="bg-[#fafafa] text-slate-900 antialiased flex items-center justify-center min-h-screen p-4 md:p-6 selection:bg-orange-500 selection:text-white">

    <div class="w-full max-w-6xl bg-white rounded-[60px] shadow-2xl overflow-hidden grid md:grid-cols-2 min-h-[700px] border border-slate-100">

        {{-- ── LEFT DARK PANEL ── --}}
        <div class="bg-slate-950 p-12 text-white flex flex-col justify-between relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-orange-500/15 via-transparent to-transparent pointer-events-none"></div>
            <div class="absolute inset-0 oil-smudge"></div>

            {{-- Logo --}}
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-12">
                    <div class="bg-orange-600 p-2 rounded-xl text-white shadow-lg shadow-orange-900/50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-width="2"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <span class="font-extrabold text-2xl tracking-tighter uppercase italic text-white leading-none">
                        PAY<span class="text-orange-500">Tato</span>
                    </span>
                </div>

                {{-- Dynamic left-panel copy per step --}}
                <div id="leftStep1">
                    <h1 class="text-5xl font-black leading-none tracking-tighter uppercase italic">
                        Account<br><span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500">Recovery.</span>
                    </h1>
                    <p class="text-slate-400 text-sm mt-6 leading-relaxed max-w-xs">
                        Masukkan NIP-mu. Permintaan akan diteruskan ke HRD untuk diverifikasi manual.
                    </p>
                </div>

                <div id="leftStep2" class="hidden">
                    <h1 class="text-5xl font-black leading-none tracking-tighter uppercase italic">
                        Request<br><span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500">Sent.</span>
                    </h1>
                    <p class="text-slate-400 text-sm mt-6 leading-relaxed max-w-xs">
                        Permintaanmu sudah tercatat. HRD akan memproses dan menghubungimu melalui saluran resmi.
                    </p>
                </div>

                <div id="leftStep3" class="hidden">
                    <h1 class="text-5xl font-black leading-none tracking-tighter uppercase italic">
                        All<br><span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500">Done.</span>
                    </h1>
                    <p class="text-slate-400 text-sm mt-6 leading-relaxed max-w-xs">
                        Tunggu konfirmasi dari HRD. Jangan coba login sebelum menerima password baru.
                    </p>
                </div>
            </div>

            {{-- Bottom watermark gear --}}
            <div class="absolute -bottom-20 -left-20 opacity-5 transform rotate-12">
                <svg class="w-80 h-80 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41h-3.84c-0.24,0-0.43,0.17-0.47,0.41l-0.36,2.54c-0.59,0.24-1.13,0.57-1.62,0.94L5.24,5.33c-0.22-0.07-0.47,0-0.59,0.22L2.74,8.87C2.62,9.08,2.66,9.34,2.84,9.48l2.03,1.58C4.82,11.36,4.8,11.68,4.8,12s0.02,0.64,0.07,0.94l-2.03,1.58c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96c0.22,0.07,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z"/>
                </svg>
            </div>
        </div>

        {{-- ── RIGHT FORM PANEL ── --}}
        <div class="p-8 md:p-16 flex flex-col justify-center overflow-y-auto bg-white">

            {{-- Page header --}}
            <div class="mb-8">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-orange-500 italic mb-2">Account Recovery</p>
                <h3 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter">Reset Access</h3>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] mt-2 leading-none">Verifikasi Identitas via HRD</p>
            </div>

            {{-- ── Step indicator ── --}}
            <div class="flex items-center mb-10">
                {{-- Step 1 --}}
                <div class="flex flex-col items-center gap-1">
                    <div id="dot1" class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-[10px] font-black italic transition-all duration-300">
                        <span id="dot1label">01</span>
                    </div>
                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-900 italic">NIP</span>
                </div>
                <div class="step-line" id="line12"></div>
                {{-- Step 2 --}}
                <div class="flex flex-col items-center gap-1">
                    <div id="dot2" class="w-8 h-8 rounded-full bg-slate-200 text-slate-400 flex items-center justify-center text-[10px] font-black italic transition-all duration-300">
                        <span id="dot2label">02</span>
                    </div>
                    <span id="label2" class="text-[9px] font-black uppercase tracking-widest text-slate-400 italic">Konfirmasi</span>
                </div>
                <div class="step-line" id="line23"></div>
                {{-- Step 3 --}}
                <div class="flex flex-col items-center gap-1">
                    <div id="dot3" class="w-8 h-8 rounded-full bg-slate-200 text-slate-400 flex items-center justify-center text-[10px] font-black italic transition-all duration-300">
                        <span id="dot3label">03</span>
                    </div>
                    <span id="label3" class="text-[9px] font-black uppercase tracking-widest text-slate-400 italic">Selesai</span>
                </div>
            </div>

            {{-- ── PANELS wrapper ── --}}
            <div class="panels-wrap">

                <div id="panel1" class="panel">
                    <div class="bg-orange-50 border border-orange-100 rounded-2xl p-4 mb-6">
                        <div class="flex gap-3 items-start">
                            <div class="bg-orange-500 text-white p-2 rounded-xl flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2.25m0 3.75h.008v.008H12V15zm0-12a9 9 0 100 18 9 9 0 000-18z"/>
                                </svg>
                            </div>
                            <p class="text-[11px] text-orange-700 leading-relaxed">
                                Password <span class="font-black italic">tidak</span> direset otomatis. HRD yang akan memverifikasi dan memberikan password baru melalui saluran resmi.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic">NIP / Employee ID</label>
                            <input
                                type="text"
                                id="nipInput"
                                placeholder="Contoh: 220001"
                                inputmode="numeric"
                                maxlength="20"
                                class="w-full mt-2 px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-orange-600 outline-none transition font-semibold"
                            >
                            <p id="nipMsg" class="opacity-0 text-red-500 text-[11px] mt-2 ml-2 italic font-medium transition-all duration-300">• minimal 6 digit angka</p>
                        </div>

                        <button onclick="goToStep2()" id="btnStep1"
                            class="w-full bg-slate-900 text-white py-5 rounded-[25px] font-black shadow-xl shadow-orange-900/10 hover:bg-orange-600 transition transform active:scale-[0.97] uppercase text-[10px] tracking-[0.3em] italic">
                            Lanjutkan →
                        </button>
                    </div>

                    <div class="mt-6 flex items-center justify-center">
                        <a href="{{ route('login') }}"
                            class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition italic">
                            ← Kembali ke Login
                        </a>
                    </div>
                </div>

                <div id="panel2" class="panel hidden-panel">

                    {{-- NIP badge --}}
                    <div class="flex items-center gap-3 bg-slate-50 border border-slate-100 rounded-2xl px-5 py-3 mb-5">
                        <div class="bg-orange-100 p-2 rounded-xl">
                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 italic">NIP Terdeteksi</p>
                            <p id="nipDisplay" class="text-sm font-black text-slate-900 italic">–</p>
                        </div>
                        <button onclick="goToStep1()" class="ml-auto text-[9px] font-black uppercase tracking-widest text-orange-500 hover:text-orange-600 italic transition">Ubah</button>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-5">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 italic mb-2">
                                Konfirmasi Data
                            </p>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                Pastikan NIP yang dimasukkan sudah benar sebelum mengirim permintaan pemulihan akses.
                            </p>
                        </div>

                        <div class="bg-orange-50 border border-orange-100 rounded-2xl p-4">
                            <div class="flex gap-3 items-start">
                                <div class="bg-orange-500 text-white p-2 rounded-xl flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/>
                                    </svg>
                                </div>
                                <p class="text-[11px] text-orange-700 leading-relaxed">
                                    Request akan dikirim ke <span class="font-black italic">HRD</span> untuk verifikasi identitas sebelum akses dipulihkan. Estimasi respons: <span class="font-black italic">1×24 jam kerja.</span>
                                </p>
                            </div>
                        </div>

                        <button onclick="submitRequest()" id="btnSubmit"
                            class="w-full bg-slate-900 text-white py-5 rounded-[25px] font-black shadow-xl shadow-orange-900/10 hover:bg-orange-600 transition transform active:scale-[0.97] uppercase text-[10px] tracking-[0.3em] italic">
                            Send Recovery Request →
                        </button>
                    </div>

                    <div class="mt-6 flex items-center justify-center">
                        <button onclick="goToStep1()"
                            class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition italic">
                            ← Kembali
                        </button>
                    </div>
                </div>

                <div id="panel3" class="panel hidden-panel">

                    <div class="flex flex-col items-center text-center py-4">
                        {{-- Animated checkmark circle --}}
                        <div class="relative mb-8">
                            <div class="pulse-ring w-24 h-24 rounded-full border-4 border-orange-500 flex items-center justify-center">
                                <div class="w-20 h-20 rounded-full bg-orange-500 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-orange-500 italic mb-3">Request Terkirim</p>
                        <h3 class="text-3xl font-black uppercase italic tracking-tighter text-slate-900 mb-3">All Done!</h3>
                        <p class="text-slate-400 text-sm leading-relaxed max-w-xs mb-2">
                            Permintaan reset password untuk NIP
                            <span id="nipFinal" class="font-black text-slate-700 italic">–</span>
                            sudah tercatat di sistem.
                        </p>
                        <p class="text-slate-400 text-sm leading-relaxed max-w-xs">
                            HRD akan memproses dan menghubungimu melalui <span class="font-black italic text-slate-600">saluran resmi internal</span>.
                        </p>

                        {{-- Summary card --}}
                        <div class="mt-8 w-full bg-slate-50 border border-slate-100 rounded-[25px] p-6 text-left space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 italic">NIP</span>
                                <span id="summaryNip" class="text-sm font-black text-slate-900 italic">–</span>
                            </div>
                            <div class="border-t border-slate-100"></div>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 italic">Status</span>
                                <span class="text-[10px] font-black text-orange-600 uppercase italic bg-orange-50 px-3 py-1 rounded-full border border-orange-100">Pending Verifikasi</span>
                            </div>
                            <div class="border-t border-slate-100"></div>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 italic">Estimasi</span>
                                <span class="text-[10px] font-black text-slate-700 italic">1×24 Jam Kerja</span>
                            </div>
                        </div>

                        <a href="{{ route('login') }}"
                            class="mt-8 w-full inline-block bg-slate-900 text-white py-5 rounded-[25px] font-black shadow-xl shadow-orange-900/10 hover:bg-orange-600 transition transform active:scale-[0.97] uppercase text-[10px] tracking-[0.3em] italic text-center">
                            ← Kembali ke Login
                        </a>
                    </div>
                </div>

            </div>{{-- end panels-wrap --}}
        </div>{{-- end right panel --}}
    </div>

    <script>
        let currentStep = 1;

        /* ── Helpers ── */
        function showPanel(n) {
            [1,2,3].forEach(i => {
                const p = document.getElementById('panel' + i);
                if (i === n) {
                    p.classList.remove('hidden-panel');
                } else {
                    p.classList.add('hidden-panel');
                }
            });
            updateDots(n);
            updateLeftCopy(n);
        }

        function updateDots(n) {
            const cfg = [
                { id: 1, line: null },
                { id: 2, line: 'line12' },
                { id: 3, line: 'line23' },
            ];
            cfg.forEach(({ id, line }) => {
                const dot   = document.getElementById('dot' + id);
                const label = document.getElementById('dot' + id + 'label');
                if (id < n) {
                    // done
                    dot.className = 'w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center text-[10px] font-black italic transition-all duration-300';
                    label.innerHTML = '✓';
                } else if (id === n) {
                    // active
                    dot.className = 'w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-[10px] font-black italic transition-all duration-300';
                    label.innerHTML = '0' + id;
                } else {
                    // future
                    dot.className = 'w-8 h-8 rounded-full bg-slate-200 text-slate-400 flex items-center justify-center text-[10px] font-black italic transition-all duration-300';
                    label.innerHTML = '0' + id;
                }
                if (line) {
                    const el = document.getElementById(line);
                    if (id <= n) {
                        el.classList.add('active');
                    } else {
                        el.classList.remove('active');
                    }
                }
            });
        }

        function updateLeftCopy(n) {
            ['leftStep1','leftStep2','leftStep3'].forEach((id, i) => {
                document.getElementById(id).classList.toggle('hidden', i + 1 !== n);
            });
        }

        /* ── Step 1 → 2 ── */
        function goToStep1() {
            showPanel(1);
            currentStep = 1;
        }

        function goToStep2() {
            const nipInput = document.getElementById('nipInput');
            const nipMsg   = document.getElementById('nipMsg');
            const val      = nipInput.value.trim();

            if (!/^\d{6,}$/.test(val)) {
                nipMsg.classList.replace('opacity-0', 'opacity-100');
                nipMsg.textContent = '• minimal 6 digit angka';
                nipInput.classList.add('shake', 'border-red-400');
                nipInput.addEventListener('animationend', () => nipInput.classList.remove('shake'), { once: true });
                return;
            }
            nipMsg.textContent = '✓ NIP Valid';
            nipMsg.classList.replace('text-red-500', 'text-green-500');
            nipMsg.classList.replace('opacity-0', 'opacity-100');

            document.getElementById('nipDisplay').textContent = val;
            showPanel(2);
            currentStep = 2;
        }

        /* ── Step 2 → 3 (submit) ── */
        function submitRequest() {
            const nip = document.getElementById('nipInput').value.trim();
            const btn = document.getElementById('btnSubmit');

            btn.disabled = true;
            btn.textContent = 'Mengirim...';

            setTimeout(() => {
                document.getElementById('nipFinal').textContent = nip;
                document.getElementById('summaryNip').textContent = nip;

            showPanel(3);
            currentStep = 3;

            btn.disabled = false;
            btn.textContent = 'Send Recovery Request →';
        }, 900);
    }

            /*
            ── Real Laravel submit example ──
            fetch('{{ route("password.forgot.submit") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ nip, reason })
            })
            .then(r => r.json())
            .then(data => {
                document.getElementById('nipFinal').textContent   = nip;
                document.getElementById('summaryNip').textContent = nip;
                showPanel(3);
            })
            .catch(() => {
                btn.disabled = false;
                btn.textContent = 'Send Recovery Request →';
            });
            */

        /* ── NIP input — only digits ── */
        document.getElementById('nipInput').addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
        });
    </script>
</body>
</html>
