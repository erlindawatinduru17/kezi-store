<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenerimaanKasController;
use App\Http\Controllers\MonitoringController;

/*
|--------------------------------------------------------------------------
| KEZ iSTORE ROUTES - FINAL VERSION
|--------------------------------------------------------------------------
*/


// ======================================================
// ROOT
// ======================================================
Route::get('/', function () {
    return redirect()->route('login');
});


// ======================================================
// GUEST AREA
// ======================================================
Route::middleware('guest')->group(function () {

    Route::controller(AuthController::class)->group(function () {

        // LOGIN
        Route::get('/login', 'login')
            ->name('login');

        Route::post('/login-proses', 'loginProses')
            ->name('login.proses');

        // REGISTER
        Route::get('/register', 'register')
            ->name('register');

        Route::post('/register-proses', 'registerProses')
            ->name('register.proses');
    });
});


// ======================================================
// LOGOUT
// ======================================================
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ======================================================
// AUTH AREA
// ======================================================
Route::middleware(['auth'])->group(function () {

    // ======================================================
    // DASHBOARD
    // ======================================================
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    // ======================================================
    // PROFILE
    // ======================================================
    Route::prefix('profile')
        ->name('profile.')
        ->controller(ProfileController::class)
        ->group(function () {

            Route::get('/', 'index')
                ->name('index');

            Route::get('/edit', 'edit')
                ->name('edit');

            Route::post('/update', 'update')
                ->name('update');

            Route::post('/password', 'updatePassword')
                ->name('password');

            Route::post('/foto', 'uploadFoto')
                ->name('foto');
        });


    // ======================================================
    // TRANSAKSI
    // ======================================================
    Route::middleware('role:admin,kasir')
        ->prefix('transaksi')
        ->name('transaksi.')
        ->controller(TransaksiController::class)
        ->group(function () {

            Route::get('/', 'index')
                ->name('index');

            Route::post('/add', 'add')
                ->name('add');

            Route::post('/update', 'update')
                ->name('update');

            Route::post('/delete', 'delete')
                ->name('delete');

            Route::post('/checkout', 'checkout')
                ->name('checkout');
        });


    // ======================================================
    // PENJUALAN
    // ======================================================
    Route::middleware('role:admin,kasir')
        ->prefix('penjualan')
        ->name('penjualan.')
        ->controller(PenjualanController::class)
        ->group(function () {

            Route::get('/', 'index')
                ->name('index');

            Route::get('/detail/{id}', 'show')
                ->name('show')
                ->where('id', '.*');

            Route::get('/nota/{id}', 'nota')
                ->name('nota')
                ->where('id', '.*');

            Route::delete('/delete/{id}', 'destroy')
                ->name('delete')
                ->where('id', '.*');

            Route::post('/verifikasi/{id}', 'verifikasi')
                ->name('verifikasi')
                ->where('id', '.*');

            Route::post('/status/{id}', 'updateStatus')
                ->name('status')
                ->where('id', '.*');
        });


    // ======================================================
    // KEUANGAN
    // ======================================================
    Route::middleware('role:admin')
        ->prefix('keuangan')
        ->name('keuangan.')
        ->controller(PenerimaanKasController::class)
        ->group(function () {

            Route::get('/penerimaan-kas', 'index')
                ->name('penerimaan_kas');

            Route::post('/store', 'store')
                ->name('store');

            Route::delete('/delete/{id}', 'destroy')
                ->name('delete');
        });


    // ======================================================
    // LAPORAN
    // ======================================================
    Route::middleware('role:admin')
        ->prefix('laporan')
        ->name('laporan.')
        ->controller(LaporanController::class)
        ->group(function () {

            Route::get('/penjualan', 'penjualan')
                ->name('penjualan');

            Route::get('/produk-terlaris', 'produkTerlaris')
                ->name('produk_terlaris');
        });


    // ======================================================
    // MONITORING
    // ======================================================
    Route::middleware('role:admin')
        ->prefix('monitoring')
        ->name('monitoring.')
        ->controller(MonitoringController::class)
        ->group(function () {

            Route::get('/activity', 'activity')
                ->name('activity');

            Route::get('/grafik', 'grafik')
                ->name('grafik');

            Route::get('/produk-terlaris', 'produkTerlaris')
                ->name('produk_terlaris');

            Route::delete('/delete/{id}', 'destroy')
                ->name('delete');
        });


    // ======================================================
    // MASTER DATA
    // ======================================================
    Route::middleware('role:admin')->group(function () {

        // ======================================================
        // KATEGORI
        // ======================================================
        Route::prefix('kategori')
            ->name('kategori.')
            ->controller(KategoriController::class)
            ->group(function () {

                Route::get('/', 'index')
                    ->name('index');

                Route::get('/edit/{id}', 'edit')
                    ->name('edit')
                    ->where('id', '.*');

                Route::post('/store', 'store')
                    ->name('store');

                Route::put('/update/{id}', 'update')
                    ->name('update')
                    ->where('id', '.*');
                Route::patch('/update/{id}', 'update')
                    ->where('id', '.*');

                Route::delete('/delete/{id}', 'destroy')
                    ->name('delete')
                    ->where('id', '.*');
            });


        // ======================================================
        // PRODUK
        // ======================================================
        Route::prefix('produk')
            ->name('produk.')
            ->controller(ProdukController::class)
            ->group(function () {

                Route::get('/', 'index')
                    ->name('index');

                Route::get('/edit/{id}', 'edit')
                    ->name('edit')
                    ->where('id', '.*');

                Route::post('/store', 'store')
                    ->name('store');

                Route::put('/update/{id}', 'update')
                    ->name('update')
                    ->where('id', '.*');
                Route::patch('/update/{id}', 'update')
                    ->where('id', '.*');

                Route::delete('/delete/{id}', 'destroy')
                    ->name('delete')
                    ->where('id', '.*');
            });


        // ======================================================
        // USER ✅ SUDAH DISESUAIKAN
        // ======================================================
        Route::prefix('user')
            ->name('user.')
            ->controller(UserController::class)
            ->group(function () {

                Route::get('/', 'index')
                    ->name('index');

                Route::post('/store', 'store')
                    ->name('store');

                Route::put('/update/{id}', 'update')
                    ->name('update');
                Route::patch('/update/{id}', 'update');

                Route::delete('/delete/{id}', 'destroy')
                    ->name('delete');
            });
    });

});