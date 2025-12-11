<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasPembayaran extends Model
{
    use HasFactory;

    protected $table = 'kas_pembayaran';

    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function kasMingguan()
    {
        return $this->belongsTo(KasMingguan::class, 'kas_mingguan_id');
    }

    public function pemasukan()
    {
        return $this->hasOne(Pemasukan::class, 'kas_pembayaran_id');
    }

    public static function jumlahPemasukanLabel($kelas_id)
    {
        $jumlah = self::countSudahBayarBulanIni($kelas_id) * 1000;

        return 'Rp '.number_format($jumlah, 0, ',', '.');
    }

    public static function countSudahBayarBulanIni($kelas_id)
    {
        return self::where('terbayar', true)
            ->where('kelas_id', $kelas_id)
            ->whereHas('kasMingguan', function ($query) {
                $query->where('bulan', now()->month)
                    ->where('tahun', now()->year);
            })
            ->count();
    }

    public static function totalPendapatanPerBulan($kelas_id, $bulan, $tahun)
    {
        // Normalisasi input bulan & tahun menggunakan Carbon
        $tanggal = Carbon::create($tahun, $bulan, 1);

        // Hitung jumlah siswa yang sudah membayar pada bulan & tahun tsb
        $jumlahBayar = self::where('terbayar', true)
            ->where('kelas_id', $kelas_id)
            ->whereHas('kasMingguan', function ($query) use ($tanggal) {
                $query->where('bulan', $tanggal->month)
                    ->where('tahun', $tanggal->year);
            })
            ->count();

        // Total pendapatan (tarif 1000)
        $total = $jumlahBayar * 1000;

        return $total;
    }

    public static function totalPendapatanPerBulanLabel($kelas_id, $bulan, $tahun)
    {
        $total = self::totalPendapatanPerBulan($kelas_id, $bulan, $tahun);

        return 'Rp '.number_format($total, 0, ',', '.');
    }
}
