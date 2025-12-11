<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $kelasList = [
            'X RPL 1', 'X RPL 2',
            'XI RPL 1', 'XI RPL 2',
            'XII RPL 1', 'XII RPL 2',
            'X TKJ 1', 'XI TKJ 1', 'XII TKJ 1',
        ];

        foreach ($kelasList as $kelas) {
            $formatted = str_replace(' ', '_', strtolower($kelas));

            // buat user bendahara
            $bendahara = User::query()->create([
                'name' => 'bendahara_'.$formatted,
                'email' => 'bendahara_'.$formatted.'@gmail.com',
                'password' => bcrypt('password123'),
                'role' => Role::BENDAHARA_KELAS,
            ]);

            // buat kelas
            $kelasModel = Kelas::query()->create([
                'nama_kelas' => $kelas,
                'bendahara_id' => $bendahara->id,
            ]);

            // ==== Tambah siswa ====
            for ($i = 1; $i <= 10; $i++) {
                Siswa::query()->create([
                    'nama_siswa' => "Siswa {$i} {$formatted}",
                    'kelas_id' => $kelasModel->id,
                ]);
            }
        }
    }
}
