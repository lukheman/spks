<?php

namespace App\Livewire;

use App\Models\Saldo as SaldoModel;
use Livewire\Component;

class Saldo extends Component
{
    public $saldo = 0;

    public $updated_at = '-';

    public function mount()
    {
        $data = SaldoModel::first();

        if ($data) {
            $this->saldo = $data->nominal;
            $this->updated_at = $data->updated_at->format('d M Y H:i');
        }
    }

    public function render()
    {
        return view('livewire.saldo');
    }
}
