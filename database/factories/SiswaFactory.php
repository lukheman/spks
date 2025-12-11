<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name,

            // ambil kelas acak, jika belum ada buat baru
            'kelas_id' => Kelas::inRandomOrder()->first()?->id
                ?? Kelas::factory()->create()->id,
        ];
    }
}
