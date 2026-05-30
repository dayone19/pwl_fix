<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Password Baru | PayTato</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .oil-smudge {
            filter: grayscale(1) opacity(0.05);
            background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');
        }

        /* Strength bar animasi */
        #strengthBar { transition: width 0.4s ease, background-color 0.4s ease; }

        /* Shake on error */
        .shake { animation: shake 0.4s ease; }
        @keyframes shake {
            0%,100% { transform: translateX(0); }
            20%     { transform: translateX(-6px); }
            40%     { transform: translateX(6px); }
            60%     { transform: translateX(-4px); }
            80%     { transform: translateX(4px); }
        }

        /* Checklist items */
        .rule-item { transition: color 0.2s, opacity 0.2s; }
        .rule-ok   { color: #22c55e !important; }

        ::-webkit-scrollbar { display: none; }
        html, body { scrollbar-width: none; -ms-overflow-style: none; }
    </style>
</head>
<body class="bg-[#fafafa] text-slate-900 antialiased flex items-center justify-center min-h-screen p-4 md:p-6">

<div class="w-full max-w-6xl bg-white rounded-[60px] shadow-2xl overflow-hidden grid md:grid-cols-2 min-h-[680px] border border-slate-100">

    {{-- ── LEFT DARK PANEL ─────────────────────────────────────────────── --}}
    <div class="bg-slate-950 p-12 text-white flex flex-col justify-between relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-orange-500/15 via-transparent to-transparent pointer-events-none"></div>
        <div class="absolute inset-0 oil-smudge"></div>

        <div class="relative z-10">
            {{-- Logo --}}
            <div class="flex items-center gap-2 mb-12">
                <div class="bg-orange-600 p-2 rounded-xl text-white shadow-lg shadow-orange-900/50">
                    <i class="fas fa-screwdriver-wrench text-xl"></i>
                </div>
                <span class="font-extrabold text-2xl tracking-tighter uppercase italic text-white leading-none">
                    PAY<span class="text-orange-500">Tato</span>
                </span>
            </div>

            <h1 class="text-5xl font-black leading-none tracking-tighter uppercase italic mb-6">
                Buat<br><span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500">Password<br>Baru.</span>
            </h1>
            <p class="text-slate-400 text-sm leading-relaxed max-w-xs">
                Kamu sudah diverifikasi oleh HRD. Sekarang buat password baru yang kuat dan mudah kamu ingat.
            </p>

            {{-- NIP info box --}}
            <div class="mt-10 bg-white/5 border border-white/10 rounded-3xl p-6">
                <p class="text-[9px] font-black uppercase tracking-widest text-slate-500 italic mb-3">Akun yang Akan Direset</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-orange-600/20 border border-orange-500/30 flex items-center justify-center">
                        <i class="fas fa-user text-orange-400"></i>
                    </div>
                    <div>
                        <p class="text-lg font-black text-white italic uppercase tracking-tight">{{ $ar->pengguna?->nama ?? '–' }}</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">NIP: {{ $ar->nip }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom watermark --}}
        <div class="absolute -bottom-20 -left-20 opacity-5 rotate-12">
            <i class="fas fa-lock text-[200px] text-white"></i>
        </div>
    </div>

    {{-- ── RIGHT FORM PANEL ─────────────────────────────────────────────── --}}
    <div class="p-8 md:p-14 flex flex-col justify-center overflow-y-auto bg-white">

        <div class="mb-8">
            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-orange-500 italic mb-2">
                <i class="fas fa-shield-halved mr-1"></i> Step Terakhir
            </p>
            <h3 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter">Password Baru</h3>
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mt-2">Isi dua kali untuk konfirmasi</p>
        </div>

        @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-100 rounded-2xl p-4 flex items-start gap-3">
            <i class="fas fa-circle-exclamation text-red-500 mt-0.5"></i>
            <ul class="text-[11px] font-bold text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('password.reset.submit', $token) }}" id="resetForm" class="space-y-5">
            @csrf

            {{-- Password baru --}}
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic ml-1">Password Baru</label>
                <div class="relative mt-2">
                    <input
                        type="password"
                        name="password"
                        id="passwordInput"
                        placeholder="Minimal 8 karakter"
                        autocomplete="new-password"
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-semibold focus:ring-2 focus:ring-orange-500 outline-none transition pr-14"
                        oninput="checkStrength(this.value)"
                    >
                    <button type="button" onclick="togglePass('passwordInput', this)"
                        class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                </div>

                {{-- Strength bar --}}
                <div class="mt-2 w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                    <div id="strengthBar" class="h-full rounded-full w-0 bg-red-400"></div>
                </div>
                <p id="strengthLabel" class="text-[9px] font-black uppercase tracking-widest mt-1 ml-1 text-slate-300 italic">Kekuatan password</p>

                {{-- Rules checklist --}}
                <ul class="mt-3 space-y-1.5 ml-1">
                    <li id="rule-len"   class="rule-item text-[10px] font-bold text-slate-300 flex items-center gap-2 italic"><i class="fas fa-circle-dot w-3 text-[8px]"></i> Minimal 8 karakter</li>
                    <li id="rule-upper" class="rule-item text-[10px] font-bold text-slate-300 flex items-center gap-2 italic"><i class="fas fa-circle-dot w-3 text-[8px]"></i> Huruf kapital (A–Z)</li>
                    <li id="rule-num"   class="rule-item text-[10px] font-bold text-slate-300 flex items-center gap-2 italic"><i class="fas fa-circle-dot w-3 text-[8px]"></i> Angka (0–9)</li>
                    <li id="rule-sym"   class="rule-item text-[10px] font-bold text-slate-300 flex items-center gap-2 italic"><i class="fas fa-circle-dot w-3 text-[8px]"></i> Simbol (!@#$...)</li>
                </ul>
            </div>

            {{-- Konfirmasi password --}}
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic ml-1">Konfirmasi Password</label>
                <div class="relative mt-2">
                    <input
                        type="password"
                        name="password_confirmation"
                        id="confirmInput"
                        placeholder="Ulangi password"
                        autocomplete="new-password"
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-semibold focus:ring-2 focus:ring-orange-500 outline-none transition pr-14"
                        oninput="checkMatch()"
                    >
                    <button type="button" onclick="togglePass('confirmInput', this)"
                        class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                </div>
                <p id="matchMsg" class="text-[10px] font-bold mt-1.5 ml-1 italic opacity-0 transition-opacity">&nbsp;</p>
            </div>

            {{-- Token expiry info --}}
            <div class="bg-orange-50 border border-orange-100 rounded-2xl p-4 flex gap-3 items-start">
                <i class="fas fa-triangle-exclamation text-orange-500 mt-0.5 text-sm flex-shrink-0"></i>
                <p class="text-[10px] text-orange-700 leading-relaxed italic">
                    Link ini berlaku hingga <span class="font-black">{{ $ar->token_expires_at?->format('d M Y, H:i') }} WIB</span>. Setelah itu kamu perlu mengajukan permintaan ulang ke HRD.
                </p>
            </div>

            <button type="submit" id="submitBtn"
                class="w-full bg-slate-900 text-white py-5 rounded-[25px] font-black shadow-xl hover:bg-orange-600 transition transform active:scale-[0.97] uppercase text-[10px] tracking-[0.3em] italic">
                <i class="fas fa-key mr-2"></i>Simpan Password Baru
            </button>
        </form>

    </div>
</div>

<script>
    // ── Toggle show/hide password ──────────────────────────────────────────────
    function togglePass(id, btn) {
        const input = document.getElementById(id);
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        btn.querySelector('i').className = isHidden ? 'fas fa-eye' : 'fas fa-eye-slash';
    }

    // ── Password strength ──────────────────────────────────────────────────────
    function checkStrength(val) {
        const rules = {
            len:   val.length >= 8,
            upper: /[A-Z]/.test(val),
            num:   /[0-9]/.test(val),
            sym:   /[^A-Za-z0-9]/.test(val),
        };

        Object.entries(rules).forEach(([key, ok]) => {
            const el = document.getElementById('rule-' + key);
            if (ok) {
                el.classList.add('rule-ok');
                el.querySelector('i').className = 'fas fa-circle-check w-3 text-[8px]';
            } else {
                el.classList.remove('rule-ok');
                el.querySelector('i').className = 'fas fa-circle-dot w-3 text-[8px]';
            }
        });

        const score = Object.values(rules).filter(Boolean).length;
        const bar   = document.getElementById('strengthBar');
        const label = document.getElementById('strengthLabel');

        const config = [
            { w: '0%',   color: 'bg-slate-200', text: 'Kekuatan password', cls: 'text-slate-300' },
            { w: '25%',  color: 'bg-red-400',   text: 'Lemah',   cls: 'text-red-400' },
            { w: '50%',  color: 'bg-orange-400', text: 'Cukup',   cls: 'text-orange-500' },
            { w: '75%',  color: 'bg-yellow-400', text: 'Baik',    cls: 'text-yellow-500' },
            { w: '100%', color: 'bg-green-500',  text: 'Kuat 🔥', cls: 'text-green-500' },
        ];

        const c = config[score] || config[0];
        bar.style.width = c.w;
        bar.className   = 'h-full rounded-full transition-all duration-400 ' + c.color;
        label.textContent = c.text;
        label.className   = 'text-[9px] font-black uppercase tracking-widest mt-1 ml-1 italic ' + c.cls;

        checkMatch();
    }

    // ── Match check ───────────────────────────────────────────────────────────
    function checkMatch() {
        const pw  = document.getElementById('passwordInput').value;
        const cfm = document.getElementById('confirmInput').value;
        const msg = document.getElementById('matchMsg');
        if (!cfm) { msg.style.opacity = 0; return; }
        if (pw === cfm) {
            msg.textContent = '✓ Password cocok';
            msg.className   = 'text-[10px] font-bold mt-1.5 ml-1 italic text-green-500 transition-opacity';
        } else {
            msg.textContent = '✗ Password tidak cocok';
            msg.className   = 'text-[10px] font-bold mt-1.5 ml-1 italic text-red-500 transition-opacity';
        }
        msg.style.opacity = 1;
    }

    // ── Form submit guard ─────────────────────────────────────────────────────
    document.getElementById('resetForm').addEventListener('submit', function(e) {
        const pw  = document.getElementById('passwordInput').value;
        const cfm = document.getElementById('confirmInput').value;
        if (pw !== cfm || pw.length < 8) {
            e.preventDefault();
            document.getElementById('resetForm').classList.add('shake');
            setTimeout(() => document.getElementById('resetForm').classList.remove('shake'), 500);
        }
    });
</script>
</body>
</html>