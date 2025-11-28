<?php

namespace App\Livewire;

use App\Enums\Role;
use App\Models\BasisPengetahuan;
use App\Models\Gejala;
use App\Models\KasPembayaran;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Penyakit;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class Dashboard extends Component
{
    public string $bulan;

    public string $totalPemasukan;
    public string $totalPengeluaran;

    public string $sudahBayar;
    public string $belumBayar;

    public $user;

    public function mount()
    {
        $this->user = auth()->user();

        $this->bulan = date('Y-m');
        $this->totalPemasukan = Pemasukan::getTotalLabelAttribute($this->bulan);
        $this->totalPengeluaran = Pengeluaran::getTotalLabelAttribute($this->bulan);

        if ($this->user->role === Role::BENDAHARA_KELAS) {
            $this->user->load('kelas');
            $this->totalPemasukan = KasPembayaran::jumlahPemasukanLabel($this->user->kelas->id);
        }

    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
