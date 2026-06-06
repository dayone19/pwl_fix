<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>ID Card - {{ $pegawai->nama_lengkap ?? $pegawai->nama }}</title>
    <style>
        
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

       
        .card-container-front {
            width: 260px;
            height: 390px;
            position: relative;
            overflow: hidden;
        }

       
        .canva-bg-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 260px;
            height: 390px;
        }

        
        .avatar-placement {
            position: absolute;
            top: 71px;        
            left: 80px;      
            width: 100px;    
            height: 143px;    
            overflow: hidden;
        }

        
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