<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';

    protected $fillable = ['nama_jabatan'];

    public function riwayat()
    {
        return $this->hasMany(RiwayatPegawai::class, 'jabatan_id');
    }

    public function pekerjaans()
    {
        return $this->hasMany(Pekerjaan::class, 'id_jabatan');
    }

    public function keluhans()
    {
        return $this->hasMany(Keluhan::class, 'jabatan_id');
    }

    public function gajiMaster()
    {
        return $this->belongsTo(Gaji::class, 'id_gaji');
    }

    public function ProfilPegawai()
    {
        return $this->hasMany(ProfilPegawai::class, 'id_jabatan', 'id');
    }
}