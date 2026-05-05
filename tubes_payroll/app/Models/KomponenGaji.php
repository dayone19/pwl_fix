<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class KomponenGaji extends Model
{
    protected $table = 'komponen_gaji';

    protected $fillable = [
        'nama_komponen',
        'tipe',
        'apakah_tetap'
    ];

    public function rincian()
    {
        return $this->hasMany(RincianGaji::class, 'komponen_id');
    }
}