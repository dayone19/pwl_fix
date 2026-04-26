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
}