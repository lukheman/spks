<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function cetakPengeluaran($bulan, $tahun)
    {
        if (!is_numeric($bulan) || !is_numeric($tahun)) {
            abort(404);
        }

        $data = Pengeluaran::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        $total = $data->sum('nominal');

        $namaBulan = Carbon::createFromFormat('m', $bulan)->translatedFormat('F');

        $pdf = Pdf::loadView('laporan.pengeluaran-cetak', [
            'data' => $data,
            'bulan' => $namaBulan,
            'tahun' => $tahun,
            'total' => $total,
            'tanggalCetak' => Carbon::now()->translatedFormat('d F Y'),
        ])->setPaper('A4', 'portrait');

        return $pdf->stream("Laporan_Pengeluaran_{$bulan}_{$tahun}.pdf");
    }
 public function cetakPemasukan($bulan, $tahun)
    {
        if (!is_numeric($bulan) || !is_numeric($tahun)) {
            abort(404);
        }

        $data = Pemasukan::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        $total = $data->sum('nominal');

        $namaBulan = Carbon::createFromFormat('m', $bulan)->translatedFormat('F');

        $pdf = Pdf::loadView('laporan.pemasukan-cetak', [
            'data' => $data,
            'bulan' => $namaBulan,
            'tahun' => $tahun,
            'total' => $total,
            'tanggalCetak' => Carbon::now()->translatedFormat('d F Y'),
        ])->setPaper('A4', 'portrait');

        return $pdf->stream("Laporan_Pemasukan_{$bulan}_{$tahun}.pdf");
    }
}
