<?php

namespace App\Providers;

use App\Models\KasPembayaran;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Observers\KasPembayaranObserver;
use App\Observers\PemasukanObserver;
use App\Observers\PengeluaranObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        KasPembayaran::observe(KasPembayaranObserver::class);
        Pemasukan::observe(PemasukanObserver::class);
        Pengeluaran::observe(PengeluaranObserver::class);
    }
}
