<?php

namespace Database\Seeders;

use App\Models\KasMingguan;
use Illuminate\Database\Seeder;

class KasMingguanSeeder extends Seeder
{
    public function run(): void
    {
        // Buat data kas mingguan untuk 1 tahun penuh (misal 2025)
        foreach (range(1, 12) as $bulan) {
            foreach (range(1, 4) as $minggu) {
                KasMingguan::factory()->create([
                    'bulan' => $bulan,
                    'tahun' => 2025,
                    'minggu_ke' => $minggu,
                ]);
            }
        }
    }
}
