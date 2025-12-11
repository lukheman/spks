<?php

namespace App\Livewire;

use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class Landing extends Component
{
    public $totalPengeluaranBulan;

    public $totalPemasukanBulan;

    public function mount()
    {
        $this->totalPengeluaranBulan = Pengeluaran::getLabelTotalPengeluaranBulan();
        $this->totalPemasukanBulanl = Pemasukan::getLabelTotalPemasukanBulan();
    }

    #[Computed]
    public function pengeluaranBulanList()
    {
        $now = Carbon::now();

        return Pengeluaran::query()->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->get();
    }

    #[Computed]
    public function pemasukanBulanList()
    {
        $now = Carbon::now();

        return Pemasukan::query()->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->get();
    }

    public function render()
    {
        return view('livewire.landing');
    }
}
