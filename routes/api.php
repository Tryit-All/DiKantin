<?php

use App\Http\Controllers\API\ApiAuth;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\ApiDikantinOld;
use App\Http\Controllers\API\ApiMenuController;

use App\Http\Controllers\API\ApiTransaction;
use App\Http\Controllers\PenjualanController;
use App\Http\Middleware\ApiKeyMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Route Login, Register, Forgot
Route::prefix('validate')->group(function () {
    // Customer
    Route::post('/login', [ApiController::class, 'loginUser']);
    Route::post('/register', [ApiController::class, 'registerUser']);
    Route::post('/forgotPassword', [ApiAuth::class, 'forgotPassword']);
    Route::post('/customerAccount', [ApiTransaction::class, 'editCustomer']);
    Route::post('/verifKode', [ApiAuth::class, 'verifKode']);
    Route::post('/confirmPassword', [ApiAuth::class, 'verifPasswordNew']);
    Route::get('/verified/{id}', [ApiController::class, 'verified'])->name('verifiedEmail');
    Route::post('/customerAccount', [ApiController::class, 'editCustomer']);
    Route::post('/imageProfile', [ApiController::class, 'profileImage']);
    Route::get('/profileShow', [ApiController::class, 'tampilCustomer']);

    // Kurir
    Route::post('/loginKurir', [ApiController::class, 'loginKurir']);
    Route::post('/editProfile', [ApiController::class, 'editProfile']);
    Route::post('/logoutKurir', [ApiTransaction::class, 'offStatusProfile']);

    // Kantin
    Route::post('/loginKantin', [ApiController::class, 'login']);
    Route::post('/logoutKantin', [ApiController::class, 'logout']);
    Route::post('/updateprofile', [ApiController::class, 'updateprofile']);
    Route::post('/userprofile', [ApiController::class, 'ubahprofile']);
});

// Route Product
Route::prefix('menu')->group(function () {
    // List Category of Product 
    Route::get('/productBestToday/{searchAll?}', [ApiMenuController::class, 'productBestToday'])->where('searchAll', '.*');
    Route::get('/productWithDiscount/{searchAll?}', [ApiMenuController::class, 'productWithDiscount'])->where('searchAll', '.*');
    Route::get('/productAll/{searchAll?}', [ApiMenuController::class, 'product'])->where('searchAll', '.*');
    Route::get('/food/{searchAll?}', [ApiMenuController::class, 'product_food'])->where('searchAll', '.*');
    Route::get('/drink/{searchAll?}', [ApiMenuController::class, 'product_drink'])->where('searchAll', '.*');

    // Menu Kantin 
    Route::post('/apimenu', [ApiMenuController::class, 'apimenu']);
});

Route::prefix('transaction')->group(function () {
    Route::post('/', [ApiTransaction::class, 'transaksiCustomer']);

    // Button Request Pesanan 
    Route::post('/konfirmasiPesanan', [ApiController::class, 'konfirmasiPesanan']);

    // List Pesanan 
    Route::get('/diproses', [ApiTransaction::class, 'pesananDiproses']);
    Route::get('/dikirim', [ApiTransaction::class, 'pesananDikirim']);
    Route::get('/diterima', [ApiTransaction::class, 'pesananDiterima']);
    Route::get('/untukDikirim', [ApiTransaction::class, 'pesananUntukDikirim']);
    Route::get('/konfirmasi', [ApiTransaction::class, 'pesananKonfirmasi']);
    Route::get('/riwayatTransaction', [ApiTransaction::class, 'riwayatCustomer']);
    Route::get('/riwayatKurir', [ApiTransaction::class, 'riwayatPesananKurir']);

    // list Orders Kantin 
    Route::post('/listOrderKantin', [ApiController::class, 'listOrdersKantin']);
});

// List Riwayat Kantin
Route::post('/api-riwayat', [ApiDikantinOld::class, 'api_riwayat']);

// Count Data Succes And Process
Route::post('/apisucces-date', [ApiDikantinOld::class, 'apisucces_date']);
Route::post('/apiproses-date', [ApiDikantinOld::class, 'apiproses_date']);

// Isi Dashboard Kantin
Route::post('/hargabulanan', [ApiDikantinOld::class, 'api_jumlah_penjualan_bulan_ini']);
Route::post('/hargaharian', [ApiDikantinOld::class, 'api_jumlah_penjualan_hari_ini']);
Route::post('/statistik', [ApiDikantinOld::class, 'Statistik']);
Route::post('/rentangpendapatan', [ApiDikantinOld::class, 'rentangPendapatan']);
Route::post('/menuTerlaris', [ApiDikantinOld::class, 'menuTerlaris']);

// Request Kantin
Route::post('/updatestatus', [ApiDikantinOld::class, 'updateStatusPenjualan']);
Route::post('/updatehabis', [ApiDikantinOld::class, 'updateHabis']);
Route::get('/update', [ApiDikantinOld::class, 'barangada']);
Route::get('/baranghabis', [ApiDikantinOld::class, 'baranghabis']);
Route::post('/updateada', [ApiDikantinOld::class, 'updateAda']);
Route::get('/ubahHarga', [ApiDikantinOld::class, 'ubahHarga']);
Route::get('/updateselesai', [ApiDikantinOld::class, 'orderselesai']);
Route::get('/updatemenu', [ApiDikantinOld::class, 'menuada']);
Route::get('/customer/get-by-id-customer', [ApiDikantinOld::class, 'showByIdCustomer']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('/transaction/{id_customer}', [ApiTransaction::class, 'tampilTransaksi']);
Route::post('/pesananStatus/{kode_tr}/{status_pesanan}/{status_konfirm}', [ApiTransaction::class, 'tampilStatus']);

Route::post('/kurirStatus/{kode_tr}/{status_konfirm}', [ApiTransaction::class, 'statusKurir']);
Route::get('/detailTransaksi/{kode_tr}', [ApiTransaction::class, 'detailPesanan']);

// Route tambahan dari web lama
Route::post('/kon/save', [PenjualanController::class, 'store'])->name('penjualan.save');
Route::post('/penjualan/tambahJumlah', [PenjualanController::class, 'tambahJumlah'])->name('penjualan.tambahJumlah');
Route::post('/penjualan/kurangJumlah', [PenjualanController::class, 'kurangJumlah'])->name('penjualan.kurangJumlah');
Route::post('/penjualan/hapusItem', [PenjualanController::class, 'hapusItem'])->name('penjualan.hapusItem');


// Route::post('/customerAccount/{id_customer}', [ApiTransaction::class, 'editCustomer']);

