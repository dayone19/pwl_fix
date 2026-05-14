<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    protected $table = 'gaji';

    protected $fillable = [
        'gaji' 
    ];
    
    public function profil()
    {
        return $this->hasMany(ProfilPegawai::class, 'id_gaji', 'id');
    }
}