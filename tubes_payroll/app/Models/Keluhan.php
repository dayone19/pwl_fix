<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Keluhan extends Model
{
    protected $primaryKey = 'keluhan_id';
    protected $table = 'keluhan';
    protected $fillable = [
        'kategori'
    ];

    public $timestamps = false;

    public function pekerjaans()
    {
        return $this->hasMany(Pekerjaan::class, 'keluhan_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }
    
}
