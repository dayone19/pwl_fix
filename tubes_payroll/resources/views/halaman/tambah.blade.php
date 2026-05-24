@extends('layouts.app')

@section('title', 'Tambah Pegawai Baru | PayTato')

@section('content')

<div class="max-w-4xl mx-auto">

    <!-- HEADER -->
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('users.index') }}"
           class="w-10 h-10 bg-white border border-slate-100 rounded-xl flex items-center justify-center text-slate-400 hover:text-orange-600 transition-all shadow-sm">
            <i class="fas fa-arrow-left"></i>
        </a>

        <div>
            <h1 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter">
                Registrasi Teknisi Baru
            </h1>

            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                Sistem Manajemen Bengkel PayTato
            </p>
        </div>
    </div>


    <!-- PROGRESS -->
    <div class="flex gap-4 mb-6">
        <div class="flex-1 h-2 rounded-full overflow-hidden bg-slate-200">

            <div id="progressBar"
                 class="h-full bg-orange-600 transition-all duration-500"
                 style="width:50%">
            </div>

        </div>
    </div>


    <!-- ERROR -->
    @if (session('error'))
        <div class="bg-red-600 text-white p-4 rounded-2xl mb-6 font-bold text-xs uppercase tracking-widest shadow-lg shadow-red-900/20 flex items-center gap-3">
            <i class="fas fa-exclamation-triangle text-lg"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded-2xl mb-6 font-bold text-xs uppercase tracking-widest">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('karyawan.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
<!-- ================================= -->
<!-- STEP 1 -->
<!-- ================================= -->

<div id="step1">

    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">

        <div class="p-10">

            <h3 class="text-[10px] font-black text-orange-600 uppercase tracking-[0.3em] italic mb-8 flex items-center gap-2">
                <i class="fas fa-lock"></i>
                Step 01: Informasi Akun & Akses
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- NIP -->
                <div class="space-y-2">

                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4">
                        NIP (Nomor Induk Pegawai)
                    </label>

                    <input type="text"
                           id="nipInput"
                           name="nip"
                           class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 outline-none"
                           placeholder="Contoh: 123456">

                    <p id="nipStatus"
                       class="text-[9px] font-bold uppercase tracking-widest ml-4 hidden">

                        <span id="nipIcon">⚠️</span>
                        <span id="nipText">Minimal 6 Digit</span>

                    </p>

                </div>


                <!-- PASSWORD -->
                <div class="space-y-2">

                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4">
                        Kata Sandi
                    </label>

                    <input type="password"
                           id="passwordInput"
                           name="kata_sandi"
                           class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 outline-none"
                           placeholder="Masukkan kata sandi">

                    <div id="passwordFeedback"
                         class="mt-3 ml-2 opacity-0 transition-all duration-300 hidden">

                        <ul id="passwordError" class="space-y-1">

                            <li id="reqLen"
                                class="text-[11px] text-red-500 flex items-center gap-2 italic">
                                <span>•</span>
                                Minimal 8 karakter
                            </li>

                            <li id="reqUpper"
                                class="text-[11px] text-red-500 flex items-center gap-2 italic">
                                <span>•</span>
                                Minimal 1 huruf besar
                            </li>

                            <li id="reqNum"
                                class="text-[11px] text-red-500 flex items-center gap-2 italic">
                                <span>•</span>
                                Minimal 1 angka
                            </li>

                        </ul>

                        <p id="pwValidText"
                           class="hidden text-[11px] font-bold text-green-500 italic">

                            ✓ Password Valid

                        </p>

                    </div>

                </div>


                <!-- EMAIL -->
                <div class="space-y-2">

                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4">
                        Alamat Email
                    </label>

                    <input type="email"
                           id="emailInput"
                           name="email"
                           class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 outline-none"
                           placeholder="Contoh: example@gmail.com">

                    <p id="emailStatus"
                       class="text-[9px] font-bold uppercase tracking-widest ml-4 hidden">

                        <span id="statusIcon">⚠️</span>
                        <span id="statusText">Wajib menggunakan @gmail.com</span>

                    </p>

                </div>


                <!-- FOTO -->
                <div class="space-y-2">

                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4">
                        Foto Profil Resmi
                    </label>

                    <input type="file"
                           id="fotoInput"
                           name="foto"
                           accept="image/*"
                           class="w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100 cursor-pointer">

                    <p id="fotoStatus"
                       class="text-[11px] font-bold uppercase tracking-widest ml-4 hidden">

                        <span id="fotoIcon"></span>
                        <span id="fotoText"></span>

                    </p>

                </div>

            </div>


            <!-- NEXT BUTTON -->
            <div class="mt-10 flex justify-end">

                <button type="button"
                        id="nextStepBtn"
                        class="bg-slate-900 text-white px-10 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl hover:bg-orange-600 transition-all italic flex items-center gap-3">

                    Lanjut Ke Profil
                    <i class="fas fa-chevron-right"></i>

                </button>

            </div>

        </div>

    </div>

</div>



<!-- ================================= -->
<!-- STEP 2 -->
<!-- ================================= -->

<div id="step2" class="hidden">

    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">

        <div class="p-10">

            <h3 class="text-[10px] font-black text-blue-600 uppercase tracking-[0.3em] italic mb-8 flex items-center gap-2">
                <i class="fas fa-user-gear"></i>
                Step 02: Detail Profil & Pegawai
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- NAMA -->
                <div class="space-y-2">

                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4">
                        Nama Lengkap Sesuai KTP
                    </label>

                    <input type="text"
                           name="nama_lengkap"
                           class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-900 uppercase italic"
                           placeholder="Contoh : Antono Antini">

                </div>


                <!-- JK -->
                <div class="space-y-2">

                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4">
                        Jenis Kelamin
                    </label>

                    <select name="jenis_kelamin"
                            class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-900 italic">

                        <option value="">PILIH...</option>
                        <option value="L">LAKI-LAKI</option>
                        <option value="P">PEREMPUAN</option>

                    </select>

                </div>


                <!-- DIVISI -->
                <div class="space-y-2">

                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4">
                        Divisi / Departemen
                    </label>

                    <select name="id_divisi"
                            class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 italic">

                        <option value="">-- Pilih Divisi --</option>

                        @foreach($list_divisi as $divisi)
                            <option value="{{ $divisi->id }}">
                                {{ $divisi->nama_divisi }}
                            </option>
                        @endforeach

                    </select>

                </div>


                <!-- JABATAN -->
                <div class="space-y-2">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4">
                        Jabatan
                    </label>
                    
                    <select name="id_jabatan" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 italic" required>
                        <option value="" disabled selected>
                            -- Pilih Jabatan --
                        </option>
                        
                        @foreach($list_jabatan as $jabatan)
                        <option value="{{ $jabatan->id }}">
                            {{ $jabatan->nama_jabatan }}
                        </option>
                        @endforeach
                    </select>
                </div>


                <!-- TELEPON -->
                <div class="space-y-2">

                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4">
                        Nomor Telepon
                    </label>

                    <!-- NOMOR TELEPON -->
                    <input type="text" id="phoneInput" name="nomor_telepon" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-blue-500 transition-all" placeholder="Contoh : 08123456789">
                    
                    <p id="phoneStatus" class="text-[9px] font-bold uppercase tracking-widest ml-4 hidden">
                        <span id="phoneIcon">⚠️</span>
                        <span id="phoneText">Nomor telepon tidak valid</span>
                    </p>
                </div>


                <!-- NIK -->
                <div class="space-y-2">

                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4">
                        Nomor NIK
                    </label>

                    <!-- NIK -->
                    <input type="text" id="nikInput" name="nik" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-blue-500 transition-all" placeholder="Contoh : 1234567890123456">
                    
                    <p id="nikStatus" class="text-[9px] font-bold uppercase tracking-widest ml-4 hidden">
                        <span id="nikIcon">⚠️</span>
                        <span id="nikText">NIK harus 16 digit angka</span>
                    </p>
                </div>


                <!-- AGAMA -->
                <div class="space-y-2">

                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4">
                        Agama
                    </label>

                    <input type="text"
                           name="agama"
                           class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800"
                           placeholder="Islam / Kristen">

                </div>


                <!-- TTL -->
                <div class="space-y-2">

                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4">
                        Tempat & Tanggal Lahir
                    </label>

                    <div class="flex gap-2 bg-slate-50 rounded-2xl p-2">

                        <input type="text"
                               name="tempat_lahir"
                               class="flex-[2] bg-transparent border-none px-4 py-2 text-sm font-bold text-slate-800 uppercase italic"
                               placeholder="BINJAI">

                        <div class="w-px h-8 bg-slate-200 my-auto"></div>

                        <input type="date"
                               name="tanggal_lahir"
                               class="flex-1 bg-transparent border-none px-4 py-2 text-sm font-bold text-slate-800">

                    </div>

                </div>


                <!-- PENDIDIKAN -->
                <div class="space-y-2">

                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4">
                        Pendidikan Terakhir
                    </label>

                    <input type="text"
                           name="pendidikan"
                           class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800"
                           placeholder="SMK Otomotif">

                </div>


                <!-- STATUS -->
                <div class="space-y-2">

                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4">
                        Status Kerja
                    </label>

                    <select name="status_kerja"
                            class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 italic">

                        <option value="">-- Pilih Status --</option>

                        <option value="Tetap">Tetap</option>
                        <option value="Kontrak">Kontrak</option>
                        <option value="Magang">Magang</option>
                        <option value="PKL">PKL</option>

                    </select>

                </div>

            </div>


            <!-- BUTTON -->
            <div class="mt-10 flex justify-between gap-4">

                <button type="button"
                        id="backStepBtn"
                        class="bg-slate-100 text-slate-500 px-10 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-200 transition-all italic flex items-center gap-3">

                    <i class="fas fa-chevron-left"></i>
                    Kembali

                </button>

                <button type="submit"
                        class="flex-1 bg-orange-600 text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl hover:bg-slate-900 transition-all italic flex items-center justify-center gap-3">

                    <i class="fas fa-save"></i>
                    Simpan Data Pegawai Baru

                </button>

            </div>

        </div>

    </div>

</div>
<script>

window.onload = function () {

    // =========================
    // ELEMENT STEP
    // =========================

    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');

    const progressBar = document.getElementById('progressBar');

    const nextStepBtn = document.getElementById('nextStepBtn');
    const backStepBtn = document.getElementById('backStepBtn');


    // =========================
    // EMAIL
    // =========================

    const emailInput = document.getElementById('emailInput');
    const emailStatus = document.getElementById('emailStatus');
    const statusText = document.getElementById('statusText');
    const statusIcon = document.getElementById('statusIcon');


    // =========================
    // PASSWORD
    // =========================

    const pwInput = document.getElementById('passwordInput');

    const pwFeedback = document.getElementById('passwordFeedback');
    const pwErrorList = document.getElementById('passwordError');

    const pwValidText = document.getElementById('pwValidText');

    const reqLen = document.getElementById('reqLen');
    const reqUpper = document.getElementById('reqUpper');
    const reqNum = document.getElementById('reqNum');


    // =========================
    // NIP
    // =========================

    const nipInput = document.getElementById('nipInput');

    const nipStatus = document.getElementById('nipStatus');
    const nipText = document.getElementById('nipText');
    const nipIcon = document.getElementById('nipIcon');


    // =========================
    // FOTO
    // =========================

    const fotoInput = document.getElementById('fotoInput');

    const fotoStatus = document.getElementById('fotoStatus');
    const fotoText = document.getElementById('fotoText');
    const fotoIcon = document.getElementById('fotoIcon');


    // =========================
    // PHONE
    // =========================

    const phoneInput = document.getElementById('phoneInput');

    const phoneStatus = document.getElementById('phoneStatus');
    const phoneText = document.getElementById('phoneText');
    const phoneIcon = document.getElementById('phoneIcon');


    // =========================
    // NIK
    // =========================

    const nikInput = document.getElementById('nikInput');

    const nikStatus = document.getElementById('nikStatus');
    const nikText = document.getElementById('nikText');
    const nikIcon = document.getElementById('nikIcon');


    // =========================
    // HELPER
    // =========================

    function updateStatus(el, isValid) {

        el.style.color = isValid
            ? "#22c55e"
            : "#ef4444";

        el.querySelector('span').innerText = isValid
            ? '✓'
            : '•';
    }


    // =========================
    // VALIDASI PASSWORD
    // =========================

    function validasiPassword() {

        const val = pwInput.value;

        pwFeedback.classList.remove('hidden');

        setTimeout(() => {
            pwFeedback.classList.add('opacity-100');
        }, 10);

        const isLenOk = val.length >= 8;
        const isUpperOk = /[A-Z]/.test(val);
        const isNumOk = /[0-9]/.test(val);

        updateStatus(reqLen, isLenOk);
        updateStatus(reqUpper, isUpperOk);
        updateStatus(reqNum, isNumOk);

        if (isLenOk && isUpperOk && isNumOk) {

            pwErrorList.classList.add('hidden');

            pwValidText.classList.remove('hidden');

            pwInput.style.boxShadow =
                "0 0 0 2px #22c55e";

        } else {

            pwErrorList.classList.remove('hidden');

            pwValidText.classList.add('hidden');

            pwInput.style.boxShadow =
                "0 0 0 2px #ef4444";
        }
    }


    // =========================
    // VALIDASI EMAIL
    // =========================

    function validasiEmail() {

        const value = emailInput.value.toLowerCase();

        emailStatus.classList.remove('hidden');

        if (
            value.endsWith('@gmail.com') &&
            value.length > 10
        ) {

            emailStatus.style.color = "#22c55e";

            statusText.innerText =
                "Format Email Valid";

            statusIcon.innerText = "✓";

            emailInput.style.boxShadow =
                "0 0 0 2px #22c55e";

        } else {

            emailStatus.style.color = "#ef4444";

            statusText.innerText =
                "Wajib menggunakan @gmail.com";

            statusIcon.innerText = "⚠️";

            emailInput.style.boxShadow =
                "0 0 0 2px #ef4444";
        }
    }


    // =========================
    // VALIDASI NIP
    // =========================

    function validasiNip() {

        const value = nipInput.value.trim();

        nipStatus.classList.remove('hidden');

        const onlyNumber =
            /^[0-9]+$/.test(value);

        if (
            onlyNumber &&
            value.length >= 6
        ) {

            nipStatus.style.color = "#22c55e";

            nipText.innerText = "NIP Valid";

            nipIcon.innerText = "✓";

            nipInput.style.boxShadow =
                "0 0 0 2px #22c55e";

        } else {

            nipStatus.style.color = "#ef4444";

            nipText.innerText =
                "NIP wajib angka & minimal 6 digit";

            nipIcon.innerText = "⚠️";

            nipInput.style.boxShadow =
                "0 0 0 2px #ef4444";
        }
    }


    // =========================
    // VALIDASI PHONE
    // =========================

    function validasiPhone() {

        const value = phoneInput.value.trim();

        phoneStatus.classList.remove('hidden');

        const onlyNumber =
            /^[0-9]+$/.test(value);

        const validPrefix =
            value.startsWith('08') ||
            value.startsWith('628');

        const validLength =
            value.length >= 10 &&
            value.length <= 15;

        if (
            onlyNumber &&
            validPrefix &&
            validLength
        ) {

            phoneStatus.style.color = "#22c55e";

            phoneText.innerText =
                "Nomor Telepon Valid";

            phoneIcon.innerText = "✓";

            phoneInput.style.boxShadow =
                "0 0 0 2px #22c55e";

        } else {

            phoneStatus.style.color = "#ef4444";

            phoneText.innerText =
                "Gunakan format 08xxxxxxxxxx";

            phoneIcon.innerText = "⚠️";

            phoneInput.style.boxShadow =
                "0 0 0 2px #ef4444";
        }
    }


    // =========================
    // VALIDASI NIK
    // =========================

    function validasiNik() {

        const value = nikInput.value.trim();

        nikStatus.classList.remove('hidden');

        const onlyNumber =
            /^[0-9]+$/.test(value);

        if (
            onlyNumber &&
            value.length === 16
        ) {

            nikStatus.style.color = "#22c55e";

            nikText.innerText =
                "NIK Valid";

            nikIcon.innerText = "✓";

            nikInput.style.boxShadow =
                "0 0 0 2px #22c55e";

        } else {

            nikStatus.style.color = "#ef4444";

            nikText.innerText =
                "NIK harus 16 digit angka";

            nikIcon.innerText = "⚠️";

            nikInput.style.boxShadow =
                "0 0 0 2px #ef4444";
        }
    }


    // =========================
    // VALIDASI FOTO
    // =========================

    fotoInput.addEventListener('change', function () {

        const file = this.files[0];

        if (!file) return;

        fotoStatus.classList.remove('hidden');

        const fileSizeMB =
            file.size / (1024 * 1024);

        if (fileSizeMB > 2) {

            fotoStatus.style.color = "#ef4444";

            fotoIcon.innerText = "⚠️";

            fotoText.innerText =
                `Ukuran file ${fileSizeMB.toFixed(2)}MB (Maks 2MB)`;

            this.value = "";

        } else {

            fotoStatus.style.color = "#22c55e";

            fotoIcon.innerText = "✓";

            fotoText.innerText =
                "Ukuran file sesuai!";
        }
    });


    // =========================
    // EVENT LISTENER
    // =========================

    pwInput.addEventListener('input', validasiPassword);

    emailInput.addEventListener('input', validasiEmail);

    nipInput.addEventListener('input', validasiNip);

    phoneInput.addEventListener('input', validasiPhone);

    nikInput.addEventListener('input', validasiNik);


    // =========================
    // NEXT STEP
    // =========================

    nextStepBtn.addEventListener('click', function () {

        validasiNip();
        validasiEmail();
        validasiPassword();

        const nipValid =
            /^[0-9]+$/.test(nipInput.value) &&
            nipInput.value.length >= 6;

        const emailValid =
            emailInput.value.endsWith('@gmail.com') &&
            emailInput.value.length > 10;

        const passwordValid =
            pwInput.value.length >= 8 &&
            /[A-Z]/.test(pwInput.value) &&
            /[0-9]/.test(pwInput.value);

        if (
            !nipValid ||
            !emailValid ||
            !passwordValid
        ) {

            alert('Lengkapi data akun terlebih dahulu!');

            return;
        }

        step1.classList.add('hidden');

        step2.classList.remove('hidden');

        progressBar.style.width = '100%';
    });


    // =========================
    // BACK STEP
    // =========================

    backStepBtn.addEventListener('click', function () {

        step2.classList.add('hidden');

        step1.classList.remove('hidden');

        progressBar.style.width = '50%';
    });


    // =========================
    // VALIDASI SUBMIT
    // =========================

    const form = document.querySelector('form');

    form.addEventListener('submit', function (e) {

        validasiPhone();
        validasiNik();

        const phoneValid =
            /^[0-9]+$/.test(phoneInput.value) &&
            (
                phoneInput.value.startsWith('08') ||
                phoneInput.value.startsWith('628')
            ) &&
            phoneInput.value.length >= 10 &&
            phoneInput.value.length <= 15;

        const nikValid =
            /^[0-9]+$/.test(nikInput.value) &&
            nikInput.value.length === 16;

        if (
            !phoneValid ||
            !nikValid
        ) {

            e.preventDefault();

            alert(
                'Periksa kembali data nomor telepon dan NIK!'
            );
        }
    });

};

</script>

@endsection