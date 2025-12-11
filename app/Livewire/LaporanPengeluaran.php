<?php

namespace App\Livewire;

use App\Traits\WithNotify;
use Livewire\Component;

class LaporanPengeluaran extends Component
{
    use WithNotify;

    public $bulan;

    public $tahun;

    public function cetak()
    {
        if (! $this->bulan || ! $this->tahun) {
            $this->notifyWarning('Bulan dan Tahun wajib dipilih!');

            return;
        }

        // Redirect ke halaman cetak laporan
        return redirect()->route('laporan.pengeluaran.cetak', [
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
        ]);
    }

    public function render()
    {
        return view('livewire.laporan-pengeluaran');
    }
}
