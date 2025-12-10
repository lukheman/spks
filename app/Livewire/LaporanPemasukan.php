<?php

namespace App\Livewire;

use App\Traits\WithModal;
use App\Traits\WithNotify;
use Livewire\Component;

class LaporanPemasukan extends Component
{
    use WithNotify;

    public $bulan;
    public $tahun;

    public function cetak()
    {
        if (!$this->bulan || !$this->tahun) {
            $this->notifyWarning('Bulan dan Tahun wajib dipilih!');
            return;
        }

        // Redirect ke halaman cetak laporan pemasukan
        return redirect()->route('laporan.pemasukan.cetak', [
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
        ]);
    }

    public function render()
    {
        return view('livewire.laporan-pemasukan');
    }
}
