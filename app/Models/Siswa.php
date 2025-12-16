<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    /** @use HasFactory<\Database\Factories\SiswaFactory> */
    use HasFactory;

    protected $table = 'siswa';

    protected $guarded = [];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function kasPembayaran()
    {
        return $this->hasMany(KasPembayaran::class, 'siswa_id');
    }

public function isTerbayar($mingguanId)
{
    return $this->kasPembayaran()
        ->where('kas_mingguan_id', $mingguanId)
        ->value('terbayar') ?? false;
}
}
