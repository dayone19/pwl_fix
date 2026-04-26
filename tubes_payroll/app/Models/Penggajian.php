<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    protected $table = 'penggajian';

    protected $fillable = [
        'nip',
        'periode_mulai',
        'periode_selesai',
        'total_tunjangan',
        'total_potongan',
        'bonus',
        'gaji_bersih',
        'status_bayar',
        'dibuat_pada'
    ];

    public function pegawai()
    {
        return $this->belongsTo(ProfilPegawai::class, 'nip', 'nip');
    }

    public function rincian()
    {
        return $this->hasMany(RincianGaji::class, 'penggajian_id');
    }
}