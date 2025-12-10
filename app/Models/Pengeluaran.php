<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pengeluaran extends Model
{
    protected $table = 'pengeluaran';
    protected $guarded = [];

    public function getNominalLabelAttribute()
    {
        return 'Rp ' . number_format($this->nominal, 0, ',', '.');
    }

    /**
     * Ambil total pemasukan per bulan (format tanggal Y-m)
     */
    public static function getTotalByMonth(?string $tanggal = null)
    {
        $query = self::query()->selectRaw('SUM(nominal) as total');

        if ($tanggal && Carbon::hasFormat($tanggal, 'Y-m')) {
            try {
                $date = Carbon::createFromFormat('Y-m', $tanggal);

                $query->whereYear('created_at', $date->year)
                      ->whereMonth('created_at', $date->month);

            } catch (\Exception $e) {
                // Abaikan jika parsing gagal
            }
        }

        return $query->value('total') ?? 0;
    }

    /**
     * Scope filter by bulan (format Y-m)
     */
    public function scopeByBulan($query, ?string $tanggal)
    {
        if ($tanggal && Carbon::hasFormat($tanggal, 'Y-m')) {
            try {
                $date = Carbon::createFromFormat('Y-m', $tanggal);

                return $query->whereYear('created_at', $date->year)
                             ->whereMonth('created_at', $date->month);

            } catch (\Exception $e) {
                // Abaikan jika salah format
            }
        }

        return $query;
    }

    /**
     * Label total dalam bentuk Rupiah
     */
    public static function getTotalLabelAttribute(?string $tanggal = null)
    {
        $total = self::getTotalByMonth($tanggal);
        return 'Rp ' . number_format($total, 0, ',', '.');
    }

/**
 * Ambil total pengeluaran bulan ini dalam format rupiah
 */
public static function getLabelTotalPengeluaranBulan()
{
    $now = Carbon::now();

    $total = self::whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month)
                ->sum('nominal');

    return 'Rp ' . number_format($total, 0, ',', '.');
}

}
