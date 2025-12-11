<?php

namespace App\Observers;

use App\Models\Pemasukan;
use App\Models\Saldo;

class PemasukanObserver
{
    public function created(Pemasukan $pemasukan)
    {
        $saldo = Saldo::first();
        $saldo->update([
            'nominal' => $saldo->nominal + $pemasukan->nominal,
        ]);
    }

    public function updated(Pemasukan $pemasukan)
    {
        if ($pemasukan->wasChanged('nominal')) {
            $SaldoLama = $pemasukan->getOriginal('nominal');
            $SaldoBaru = $pemasukan->nominal;

            $saldo = Saldo::first();
            $saldo->update([
                'nominal' => ($saldo->nominal - $SaldoLama) + $SaldoBaru,
            ]);
        }
    }

    public function deleted(Pemasukan $pemasukan)
    {
        $saldo = Saldo::first();
        $saldo->update([
            'nominal' => $saldo->nominal - $pemasukan->nominal,
        ]);
    }
}
