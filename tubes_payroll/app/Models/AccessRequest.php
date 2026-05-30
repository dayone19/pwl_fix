<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccessRequest extends Model
{
    protected $table = 'access_requests';

    protected $fillable = [
        'nip',
        'status',
        'token',
        'token_expires_at',
        'catatan_hr',
        'petugas_hr',
        'tanggal_verifikasi',
    ];

    protected $casts = [
        'token_expires_at'   => 'datetime',
        'tanggal_verifikasi' => 'datetime',
    ];

    // Relasi ke tabel 'pengguna' (bukan 'users')
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'nip', 'nip');
    }

    // Cek apakah token masih berlaku
    public function isTokenValid(): bool
    {
        return $this->token
            && $this->token_expires_at
            && now()->lt($this->token_expires_at);
    }

    // Helper badge status untuk view
    public function statusBadge(): array
    {
        return match ($this->status) {
            'pending'   => ['label' => 'Pending Verifikasi',            'color' => 'orange'],
            'disetujui' => ['label' => 'Disetujui – Menunggu Karyawan', 'color' => 'blue'],
            'selesai'   => ['label' => 'Selesai',                        'color' => 'green'],
            'ditolak'   => ['label' => 'Ditolak',                        'color' => 'red'],
            default     => ['label' => ucfirst($this->status),           'color' => 'slate'],
        };
    }
}