<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Peran extends Model
{
    protected $table = 'peran';

    protected $fillable = [
        'nama_peran',
        'deskripsi'
    ];

    public function pengguna()
    {
        return $this->hasMany(Pengguna::class, 'role');
    }
}