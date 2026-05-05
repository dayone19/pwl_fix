<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = 'pengguna';
    protected $fillable = [
        'nama',
        'nip',
        'role',
        'email',
        'kata_sandi',
        'foto',
        'apakah_aktif'
    ];

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
}