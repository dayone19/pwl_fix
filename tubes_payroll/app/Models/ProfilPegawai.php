<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProfilPegawai extends Model
{
    protected $table = 'profil_pegawai';
    protected $fillable = [
        'nip',
        'nama_lengkap',
        'nik',
        'jenis_kelamin',
        'agama',
        'email',
        'nomor_telepon',
        'tempat_tanggal_lahir',
        'tanggal_masuk',
        'tanggal_keluar',
        'apakah_digaji',
        'dibuat_pada',
        'jabatan',
        'departemen',
        'pendidikan'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'nip', 'nip');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'nip', 'nip');
    }

    public function cuti()
    {
        return $this->hasMany(Cuti::class, 'nip', 'nip');
    }

    public function penggajian()
    {
        return $this->hasMany(Penggajian::class, 'nip', 'nip');
    }

    public function riwayat()
    {
        return $this->hasMany(RiwayatPegawai::class, 'pegawai_id');
    }
}