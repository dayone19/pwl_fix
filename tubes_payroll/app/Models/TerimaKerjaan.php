<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TerimaKerjaan extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'terima_kerjaan';
    public $timestamps = false;
    protected $fillable = [
        'pekerjaan_id',
        'teknisi_id',
        'status',
        'progres',
        'selesai_pada',
        'created_at',
    ];

    public function pekerjaans()
    {
        return $this->hasMany(Pekerjaan::class, 'pekerjaan_id');
    }
}
