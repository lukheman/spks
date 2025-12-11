<?php

use App\Http\Controllers\LaporanController;
use App\Livewire\Table\DetailKasMingguan;
use Illuminate\Support\Facades\Route;

Route::get('/landing', \App\Livewire\Landing::class)->name('landing');
Route::get('/', \App\Livewire\Index::class)->name('index')->middleware('auth');
Route::get('/profile', \App\Livewire\Profile::class)->name('profile')->middleware('auth');
Route::get('/users', \App\Livewire\Table\UserTable::class)->name('user-table')->middleware('auth');
Route::get('/kelas', \App\Livewire\Table\KelasTable::class)->name('kelas-table')->middleware('auth');
Route::get('/siswa', \App\Livewire\Table\SiswaTable::class)->name('siswa-table')->middleware('auth');
Route::get('/pemasukan', \App\Livewire\Table\PemasukanTable::class)->name('pemasukan-table')->middleware('auth');
Route::get('/pengeluaran', \App\Livewire\Table\PengeluaranTable::class)->name('pengeluaran-table')->middleware('auth');
Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard')->middleware('auth');

Route::get('/saldo', \App\Livewire\Saldo::class)->name('saldo')->middleware('auth');

Route::get('/laporan-pemasukan', \App\Livewire\LaporanPemasukan::class)->name('laporan-pemasukan')->middleware('auth');

Route::get('/laporan-pengeluaran', \App\Livewire\LaporanPengeluaran::class)->name('laporan-pengeluaran')->middleware('auth');

Route::get('/login', \App\Livewire\Login::class)->name('login');
Route::get('/logout', App\Http\Controllers\LogoutController::class)->name('logout');

Route::get('/laporan/pengeluaran/cetak/{bulan}/{tahun}', [LaporanController::class, 'cetakPengeluaran'])
    ->name('laporan.pengeluaran.cetak');

Route::get('/laporan/pemasukan/{bulan}/{tahun}',
    [LaporanController::class, 'cetakPemasukan']
)->name('laporan.pemasukan.cetak');

Route::prefix('kas')->group(function () {

    // Halaman detail pembayaran per minggu
    Route::get('mingguan', DetailKasMingguan::class)
        ->name('kas.mingguan.detail');

});
