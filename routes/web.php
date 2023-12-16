<?php

use App\Http\Controllers\AuthLoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KantinController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanKurirController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NotificationCotroller;
use App\Http\Controllers\orderController;
use App\Http\Controllers\OrderDetailTransaksiController;
use App\Http\Controllers\OrderTransaksiController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\RekapitulasiController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SuccesController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
    return view('layout.pageLogin');
});

Route::post('loginWeb', [AuthLoginController::class, 'loginUser'])->name('loginUserWeb');
Route::get('google', [AuthLoginController::class, 'redirectToGoogle']);
Route::get('google/callback', [AuthLoginController::class, 'handleGoogleCallback']);

Auth::routes();

Route::group(['middleware' => ['auth']], function () {


    Route::get("/kantin", [KantinController::class, "index"]);
    Route::get("/kantin/{id}", [KantinController::class, "edit"])->name('kantin-edit');
    Route::put("/kantin/{id}", [KantinController::class, "update"]);
    Route::delete("kantin", [KantinController::class, "destroy"]);
    Route::get("/kantin/add/create", [KantinController::class, "create"]);
    Route::post("/kantin/add/create", [KantinController::class, "store"]);





    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    // Route::put('roles/{id}/edit', [RoleController::class, 'update'])->name('roles.update');

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/allOrder', [orderController::class, 'get_all_order']);
    Route::delete('/allOrder/{id}', [orderController::class, 'delete_order']);
    Route::get('/success', [SuccesController::class, 'get_order_solved']);
    Route::post('/success/{kode_tr}', [SuccesController::class, 'validate_success']);
    Route::post('/trouble/{kode_tr}', [SuccesController::class, 'trouble_transaction']);

    // transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::get('/transaksi/{id}', [TransaksiController::class, 'detail']);
    Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy']);

    Route::get('/productAll', [MenuController::class, 'product']);
    Route::get('/searchProductAll', [MenuController::class, 'searchProduct']);
    Route::get('/menuAll', [MenuController::class, 'index']);
    Route::get('/menu/create', [MenuController::class, 'create']);
    Route::post('/menuCreate', [MenuController::class, 'store']);
    Route::get('/menu/{id}/edit', [MenuController::class, 'edit']);
    Route::put('/menu/{id}', [MenuController::class, 'update']);
    Route::delete('/menu/{id}', [MenuController::class, 'destroy']);
    Route::get('/rupiah', [MenuController::class, 'rupiah']);

    Route::get('/penjualan', [OrderTransaksiController::class, 'index']);
    Route::get('/penjualan/create', [OrderTransaksiController::class, 'create']);
    Route::post('/penjualan', [OrderTransaksiController::class, 'store']);
    Route::get('/penjualan/{id}/edit', [OrderTransaksiController::class, 'edit']);
    Route::put('/penjualan/{id}', [OrderTransaksiController::class, 'update']);
    Route::delete('/penjualan/{id}', [OrderTransaksiController::class, 'destroy']);

    Route::get('/detailpenjualan', [OrderDetailTransaksiController::class, 'index']);
    Route::get('/detailpenjualan/create', [OrderDetailTransaksiController::class, 'create']);
    Route::post('/detailpenjualan', [OrderDetailTransaksiController::class, 'store']);
    Route::get('/detailpenjualan/{id}/{id_menu}/edit', [OrderDetailTransaksiController::class, 'edit']);
    Route::put('/detailpenjualan/{id}/{id_menu}/', [OrderDetailTransaksiController::class, 'update']);
    Route::delete('/detailpenjualan/{id}', [OrderDetailTransaksiController::class, 'destroy']);

    Route::get('/kasir/{id}', [KasirController::class, 'struk']);
    Route::get('/kasir', [KasirController::class, 'index']);
    Route::post('/kasir', [KasirController::class, 'order']);
    Route::get('/kasir/{id}/{datetime}', [KasirController::class, 'reload']);
    Route::get('/kasir/hapussemua/{id}', [KasirController::class, 'hapussemua']);

    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::get('/ceklaporan/cetak/{tglMulai}/{tglSelesai}/{idKantin}/{status}', [LaporanController::class, 'cekLaporan']);
    Route::get('/laporan/cetak/{tglMulai}/{tglSelesai}/{idKantin}/{status}', [LaporanController::class, 'cetak']);
    Route::get('/laporan/cetakSemua', [LaporanController::class, 'cetakSemua']);


    Route::post("/rekapitulasi/excel", [RekapitulasiController::class, "excel"])->name('rekapitulasi-excel');
    Route::get('/rekapitulasi', [RekapitulasiController::class, 'index']);
    Route::get('/cekRekapitulasi/cetak/{tglMulai}/{tglSelesai}', [RekapitulasiController::class, 'cekRekapitulasi']);
    Route::get('/rekapitulasi/cetak/{tglMulai}/{tglSelesai}', [RekapitulasiController::class, 'cetak']);
    Route::get('/rekapitulasi/cetak-semua', [RekapitulasiController::class, 'cetakSemua'])->name('cetak.semua');

    // Route::get('/cekRekapitulasi/cetak/{tglMulai}/{tglSelesai}', [LaporanKurirController::class, 'cekRekapitulasi']);
    // Route::get('/kurir/cetak/{tglMulai}/{tglSelesai}', [LaporanKurirController::class, 'cetak']);
    // Route::get('/kurir/cetak-semua', [LaporanKurirController::class, 'cetakSemua'])->name('cetak.semua');



    Route::get('/pelanggan', [CustomerController::class, 'index']);
    Route::get('/autocomplete', [CustomerController::class, 'search'])->name('autocomplete');
    Route::get('/customer/create', [CustomerController::class, 'create']);
    Route::post('/prosesCustomer', [CustomerController::class, 'store']);
    Route::get('/customer/{id}/edit', [CustomerController::class, 'edit']);
    Route::put('/customer/{id}', [CustomerController::class, 'update']);
    Route::post('/deleteCustomer/{id}', [CustomerController::class, 'destroy'])->name('deleteCustomer');

    Route::post("/laporan/cetak/excel", [LaporanController::class, "cetakExcel"])->name('laporan-excel');

});
Route::get('/kurirr', [LaporanKurirController::class, 'index']);
Route::post('/kurirr/export', [LaporanKurirController::class, 'export'])->name('kurir-excel');

Route::get('/cekOnkirKurir/cetak/{tglMulai}/{tglSelesai}', [LaporanKurirController::class, 'cekOnkirKurir']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
