<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelasFactory extends Factory
{
    protected $model = Kelas::class;

    public function definition(): array
    {
        // contoh nama kelas acak
        $kelasList = [
            'X RPL 1', 'X RPL 2',
            'XI RPL 1', 'XI RPL 2',
            'XII RPL 1', 'XII RPL 2',
            'X TKJ 1', 'XI TKJ 1', 'XII TKJ 1',
        ];

        $namaKelas = $this->faker->randomElement($kelasList);

        // Format nama dan email bendahara
        $formatted = str_replace(' ', '_', strtolower($namaKelas)); // x_rpl_1

        $bendahara = User::factory()->create([
            'name' => 'bendahara_'.$formatted,
            'email' => 'bendahara_'.$formatted.'@example.com',
        ]);

        return [
            'nama_kelas' => $namaKelas,
            'bendahara_id' => $bendahara->id,
        ];
    }
}
