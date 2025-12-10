<?php

namespace App\Observers;

use App\Enums\StatusPembayaran;
use App\Models\KasPembayaran;
use App\Models\Pemasukan;

class KasPembayaranObserver
{

    /**
     * Handle the KasPembayaran "saving" event.
     */
    public function saving(KasPembayaran $pembayaran): void
    {
    }


    /**
     * Handle the KasPembayaran "created" event.
     */
    public function created(KasPembayaran $kasPembayaran): void
    {
        //
    }

    /**
     * Handle the KasPembayaran "updated" event.
     */
 // public function updated(KasPembayaran $kasPembayaran)
 //    {
 //        // Cek apakah field 'terbayar' berubah
 //        if ($kasPembayaran->isDirty('terbayar')) {
 //
 //            // Jika terbayar = true → buat pemasukan baru
 //            if ($kasPembayaran->terbayar) {
 //                Pemasukan::updateOrCreate(
 //                    ['kas_pembayaran_id' => $kasPembayaran->id],
 //                    ['nominal' => 1000] // nominal default mingguan
 //                );
 //            } else {
 //                // Jika terbayar = false → hapus pemasukan
 //                $kasPembayaran->pemasukan()->delete();
 //            }
 //        }
 //    }

    /**
     * Handle the KasPembayaran "deleted" event.
     */
    public function deleted(KasPembayaran $kasPembayaran): void
    {
        //
    }

    /**
     * Handle the KasPembayaran "restored" event.
     */
    public function restored(KasPembayaran $kasPembayaran): void
    {
        //
    }

    /**
     * Handle the KasPembayaran "force deleted" event.
     */
    public function forceDeleted(KasPembayaran $kasPembayaran): void
    {
        //
    }
}
