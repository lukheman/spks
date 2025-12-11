<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasMingguan extends Model
{
    use HasFactory;

    protected $table = 'kas_mingguan';

    protected $guarded = [];

    public function pembayaran()
    {
        return $this->hasMany(KasPembayaran::class, 'kas_mingguan_id');
    }
}
