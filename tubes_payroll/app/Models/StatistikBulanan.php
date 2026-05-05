<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class StatistikBulanan extends Model
{
    protected $table = 'statistik_bulanan';

    protected $fillable = [
        'bulan',
        'tahun',
        'total_pegawai',
        'total_pengeluaran_gaji',
        'jumlah_pegawai_baru',
        'jumlah_pegawai_keluar'
    ];
}