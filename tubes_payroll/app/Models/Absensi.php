<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';

    public $timestamps = false;

    protected $fillable = [
        'nip',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status_kehadiran',
        'menit_terlambat'
    ];

    public function profilPegawai()
    {
        return $this->belongsTo(ProfilPegawai::class, 'nip', 'nip');
    }
}