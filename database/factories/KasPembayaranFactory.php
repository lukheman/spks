<?php

namespace Database\Factories;

use App\Models\KasMingguan;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class KasPembayaranFactory extends Factory
{
    public function definition(): array
    {
        return [
            'siswa_id' => Siswa::inRandomOrder()->first()->id ?? Siswa::factory()->create()->id,
            'kelas_id' => Kelas::inRandomOrder()->first()->id ?? Kelas::factory()->create()->id,
            'kas_mingguan_id' => KasMingguan::inRandomOrder()->first()->id ?? KasMingguan::factory()->create()->id,
            'terbayar' => $this->faker->boolean(),
        ];
    }
}
