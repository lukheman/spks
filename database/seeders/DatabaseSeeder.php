<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\KasPembayaran;
use App\Models\Saldo;
use App\Models\User;
use App\Models\Kelas;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        User::factory()->create([
            'name' => 'Pembina Osis',
            'email' => 'pembina_osis@gmail.com',
            'role' => Role::PEMBINA_OSIS
        ]);

        User::factory()->create([
            'name' => 'Bendahara Osis',
            'email' => 'bendahara_osis@gmail.com',
            'role' => Role::BENDAHARA_OSIS
        ]);

        Saldo::query()->create(['nominal' => 0]);

        $this->call([
            KelasSeeder::class,
            KasMingguanSeeder::class,
            KasPembayaranSeeder::class,
        ]);

    }
}
