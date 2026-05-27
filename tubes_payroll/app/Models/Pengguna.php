<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';
    protected $fillable = [
        'nama',
        'nip',
        'role',
        'email',
        'kata_sandi',
        'foto',
        'apakah_aktif',
        'login_attempts',
        'lockout_time',
        'update_at'
    ];

    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    public function peran()
    {
        return $this->belongsTo(Peran::class, 'role');
    }

    public function profilPegawai()
    {
        return $this->hasOne(ProfilPegawai::class, 'nip', 'nip');
    }

    public function cutiDisetujui()
    {
        return $this->hasMany(Cuti::class, 'disetujui_oleh_id');
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class, 'id'); 
    }

    public function cuti(): HasMany
    {
        return $this->hasMany(Cuti::class, 'id');
    }

    public function profil()
    {
        return $this->hasOne(ProfilPegawai::class, 'id', 'id');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'id_divisi');
    }

    public function terimaKerjaan()
    {
        return $this->belongsTo(TerimaKerjaan::class, 'teknisi_id');
    }

}