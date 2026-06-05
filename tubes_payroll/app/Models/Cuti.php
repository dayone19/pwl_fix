<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{

    public $timestamps = false;

    protected $table = 'cuti';
    protected $fillable = [
        'id_pegawai',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'status_persetujuan',
        'jenis_pengajuan',
        'disetujui_oleh_id'
    ];

    public function pegawai()
{
    return $this->belongsTo(Pengguna::class, 'id_pegawai', 'id');
}

    public function disetujuiOleh()
    {
        return $this->belongsTo(Pengguna::class, 'disetujui_oleh_id');
    }
}