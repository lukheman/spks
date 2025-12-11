<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class KasMingguanFactory extends Factory
{
    public function definition(): array
    {
        $bulan = $this->faker->numberBetween(1, 12);
        $tahun = 2025;
        $mingguKe = $this->faker->numberBetween(1, 4);

        // tanggal awal bulan
        $tanggal = Carbon::create($tahun, $bulan, 1);

        // cari semua jumat dalam bulan itu
        $listJumat = [];

        while ($tanggal->month == $bulan) {
            if ($tanggal->dayOfWeek === Carbon::FRIDAY) {
                $listJumat[] = $tanggal->copy();
            }
            $tanggal->addDay();
        }

        // ambil jumat berdasarkan mingguKe (jika tidak ada, ambil terakhir)
        $tanggalJumat = $listJumat[$mingguKe - 1] ?? end($listJumat);

        return [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'minggu_ke' => $mingguKe,
            'tanggal_jumat' => $tanggalJumat->format('Y-m-d'),
        ];
    }
}
