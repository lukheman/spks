<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    /** @use HasFactory<\Database\Factories\KelasFactory> */
    use HasFactory;

    protected $table = 'kelas';

    protected $guarded = [];

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function bendahara()
    {
        return $this->belongsTo(User::class, 'bendahara_id');
    }

    public function kasPembayaran()
    {
        return $this->hasMany(KasPembayaran::class, 'kelas_id');
    }
}
