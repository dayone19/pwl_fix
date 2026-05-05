<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RincianGaji extends Model
{
    protected $table = 'rincian_gaji';
    protected $fillable = [
        'penggajian_id',
        'komponen_id',
        'jumlah'
    ];

    public function penggajian()
    {
        return $this->belongsTo(Penggajian::class, 'penggajian_id');
    }

    public function komponen()
    {
        return $this->belongsTo(KomponenGaji::class, 'komponen_id');
    }
}