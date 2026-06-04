<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>ID Card - {{ $pegawai->nama_lengkap ?? $pegawai->nama }}</title>
    <style>
        /* Pengaturan Ukuran Kanvas Cetak PDF Pas Sesuai Dimensi Desain Canva */
        @page {
            size: 260px 390px;
            margin: 0;
        }

        html,
        body {
            width: 260px;
            height: 390px;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            font-family: 'Helvetica', 'Arial', sans-serif;
        }

        /* Kontainer Utama Sisi Kartu Depan */
        .card-container-front {
            width: 260px;
            height: 390px;
            position: relative;
            overflow: hidden;
        }

        /* Lapisan Gambar Latar Belakang Canva (Menghapus z-index negatif) */
        .canva-bg-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 260px;
            height: 390px;
        }

        /* Penempatan Pasfoto 3x4 (Dipastikan berada di lapisan atas) */
        .avatar-placement {
            position: absolute;
            top: 71px;        /* Jarak vertikal masuk ke bingkai */
            left: 80px;       /* Jarak horizontal center otomatis */
            width: 100px;     /* Lebar pasfoto */
            height: 143px;    /* Tinggi pasfoto */
            overflow: hidden;
        }

        /* Penempatan Lapisan Teks Nama Karyawan */
        .name-placement {
            position: absolute;
            top: 237px;
            width: 260px;
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            color: #0d1b2e;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .role-placement {
            position: absolute;
            top: 283px;
            width: 260px;
            text-align: center;
            font-size: 9px;
            font-weight: bold;
            color: #f97316;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Penempatan Lapisan Angka NIP */
        .nip-placement {
            position: absolute;
            top: 330px;       
            width: 260px;
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            color: #0d1b2e;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>

    <div class="card-container-front">
        
        <img class="canva-bg-img" src="{{ public_path('img/template/id_card_front.png') }}">
        
        <div class="avatar-placement">
            @if($pegawai->foto_akun)
                <img src="{{ public_path('img/profil/' . $pegawai->foto_akun) }}" width="100" height="143">
            @else
                <div style="width: 100%; height: 100%; background-color: #dde3ec;"></div>
            @endif
        </div>

        <div class="name-placement">
            {{ $pegawai->nama_lengkap ?? $pegawai->nama }}
        </div>

        <div class="role-placement">
            {{ $pegawai->jabatan ?? 'Karyawan' }}
        </div>

        <div class="nip-placement">
            {{ $pegawai->nip }}
        </div>

    </div>

</body>
</html>