<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    protected $primaryKey = 'pekerjaan_id';
    protected $table = 'pekerjaan';
    public $timestamps = true;
    protected $fillable = [
        'plat_nomor',
        'kendaraan',
        'keluhan_id',
        'detail_keluhan',
        'jabatan_id',
        'status',
    ];

    public function keluhan()
    {
        return $this->belongsTo(Keluhan::class, 'keluhan_id');
    } 

    public function jabatan()
    {
        return $this->belongsTo(jabatan::class, 'jabatan_id');
    }

    public function terimaKerjaan()
    {
        return $this->belongsTo(TerimaKerjaan::class, 'pekerjaan_id');
    }
}
