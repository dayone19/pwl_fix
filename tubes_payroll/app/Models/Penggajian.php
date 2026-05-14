<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    protected $primaryKey = 'id_gaji'; 
    public $timestamps = false;
    protected $table = 'penggajian';

    protected $fillable = [
        'id_pegawai',
        'nip', 
        'periode_mulai', 
        'periode_selesai', 
        'total_tunjangan', 
        'total_potongan', 
        'bonus', 
        'gaji_bersih', 
        'status_bayar', 
        'bulan'
    ];

    public function pegawai()
    {
        return $this->belongsTo(ProfilPegawai::class, 'id_pegawai', 'id');
    }

    public function rincian()
    {
        return $this->hasMany(RincianGaji::class, 'penggajian_id');
    }
}