<?php

namespace App\Providers;

use App\Models\KasPembayaran;
use App\Observers\KasPembayaranObserver;
use Illuminate\Support\ServiceProvider;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Observers\PemasukanObserver;
use App\Observers\PengeluaranObserver;

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
