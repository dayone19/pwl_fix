<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    protected $table = 'cuti';
    protected $fillable = [
        'nip',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'status_persetujuan',
        'disetujui_oleh_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo(ProfilPegawai::class, 'nip', 'nip');
    }

    public function disetujuiOleh()
    {
        return $this->belongsTo(Pengguna::class, 'disetujui_oleh_id');
    }
}