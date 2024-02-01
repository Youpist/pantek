<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\WithdrawalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->name('login') ;
Route::post('/', [AuthController::class, 'login']);

Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout');

// Admin
Route::middleware(['auth', 'userAkses:admin'])->group(function(){
Route::get('/admin', [DashboardController::class, 'admninIndex'])->name('admin.index');
});

Route::resource('/admin/pengguna', UserController::class);

// Kantin
Route::middleware(['auth', 'userAkses:kantin'])->group(function(){
Route::get('/kantin', [DashboardController::class, 'kantinIndex'])->name('kantin.index');

Route::resource('/kantin/produk', ProdukController::class);
Route::resource('/kantin/kategori', KategoriController::class);
Route::get('/kantin/laporan-harian', [TransaksiController::class, 'laporanTransaksiHarian'])->name('kantin.laporan');
Route::get('/kantin/transaksi/{invoice}', [TransaksiController::class, 'laporanTransaksi'])->name('transaksi.detail');
});


// Bank
Route::middleware(['auth', 'userAkses:bank'])->group(function(){
Route::get('/bank', [DashboardController::class , 'bankIndex'])->name('bank.index');
Route::get('bank/topup', [BankController::class, 'topupIndex'])->name('bank.topup');
Route::get('bank/withdrawal', [BankController::class, 'withdrawalIndex'])->name('bank.withdrawal');

// Top Up
Route::put('/bank/konfirmasiTopup/{id}', [BankController::class, 'konfirmasiTopup'])->name('konfirmasi.topup');
Route::put('/bank/tolakTopup/{id}', [BankController::class, 'tolakTopup'])->name('tolak.topup');

// Tarik Tunai
Route::put('/bank/konfirmasiWithdrawal/{id}', [BankController::class, 'konfirmasiWithdrawal'])->name('konfirmasi.withdrawal');
Route::put('/bank/tolakWithdrawal/{id}', [BankController::class, 'tolakWithdrawal'])->name('tolak.withdrawal');
// Laporan
Route::get('/bank/laporan-withdrawal', [BankController::class, 'laporanWithdrawalHarian'])->name('withdrawal.harian');
Route::get('/bank/laporan-withdrawal/{tanggal}', [BankController::class, 'laporanWithdrawal'])->name('withdrawal.detail');
Route::get('/bank/laporan-topup', [BankController::class, 'laporanTopupHarian'])->name('topup.harian');
Route::get('/bank/laporan-topup/{tanggal}', [BankController::class, 'laporanTopup'])->name('topup.detail');
});



// Customer
Route::middleware(['auth', 'userAkses:customer'])->group(function(){
    Route::get('/customer', [DashboardController::class, 'customerIndex'])->name('customer.index');

    Route::post('/customer/topup', [BankController::class, 'topup'])->name('customer.topup');
    Route::post('/customer/withdrawal', [BankController::class, 'withdrawal'])->name('withdrawal.request');

        Route::get('/customer/kantin', [TransaksiController::class, 'customerIndexKantin'])->name('customer.kantin');
        Route::post('/customer/tambahKeranjang/{id}', [TransaksiController::class, 'addToCart'])->name('addToCart');
        Route::get('/customer/keranjang', [TransaksiController::class, 'keranjangIndex'])->name('customer.keranjang');
        Route::post('/customer/checkout', [TransaksiController::class, 'checkout'])->name('checkout');
        Route::delete('/customer/keranjang/destroy/{id}', [TransaksiController::class, 'keranjangDestroy'])->name('keranjang.destroy');
        Route::get('/customer/transaksi', [TransaksiController::class, 'invoice'])->name('cetak.transaksi');
        

        // Riwayat
        Route::get('/customer/riwayat/topup', [BankController::class, 'riwayatTopup'])->name('riwayat.topup');
        Route::get('/customer/riwayat/transaksi', [TransaksiController::class, 'riwayatTransaksi'])->name('riwayat.transaksi');
        Route::get('/customer/riwayat/transaksi/{invoice}', [TransaksiController::class, 'detailRiwayatTransaksi'])->name('riwayat.detail');
        Route::get('/customer/riwayat/withdrawal', [BankController::class, 'riwayatWithdrawal'])->name('riwayat.withdrawal');
        
});