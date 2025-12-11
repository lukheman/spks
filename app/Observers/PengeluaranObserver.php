<?php

namespace App\Observers;

use App\Models\Pengeluaran;
use App\Models\Saldo;

class PengeluaranObserver
{
    public function created(Pengeluaran $pengeluaran)
    {
        $saldo = Saldo::first();
        $saldo->update([
            'nominal' => $saldo->nominal - $pengeluaran->nominal,
        ]);
    }

    public function updated(Pengeluaran $pengeluaran)
    {
        if ($pengeluaran->wasChanged('nominal')) {
            $Lama = $pengeluaran->getOriginal('nominal');
            $Baru = $pengeluaran->nominal;

            $saldo = Saldo::first();
            $saldo->update([
                'nominal' => ($saldo->nominal + $Lama) - $Baru,
            ]);
        }
    }

    public function deleted(Pengeluaran $pengeluaran)
    {
        $saldo = Saldo::first();
        $saldo->update([
            'nominal' => $saldo->nominal + $pengeluaran->nominal,
        ]);
    }
}
