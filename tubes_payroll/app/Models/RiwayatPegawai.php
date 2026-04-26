<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RiwayatPegawai extends Model
{
    protected $table = 'riwayat_pegawai';

    protected $fillable = [
        'pegawai_id',
        'departemen_id',
        'jabatan_id',
        'tipe_pegawai',
        'gaji_pokok',
        'tanggal_mulai',
        'status_tugas'
    ];

    public function pegawai()
    {
        return $this->belongsTo(ProfilPegawai::class, 'pegawai_id');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'departemen_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }
}