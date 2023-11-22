<?php

use App\Http\Controllers\API\ApiAuth;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\ApiMenuController;

use App\Http\Controllers\API\ApiTransaction;
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
    Route::get('/verified/{id}', [ApiController::class, 'verified']);

    // Kurir
    Route::post('/loginKurir', [ApiController::class, 'loginKurir']);
    Route::post('/editProfile', [ApiController::class, 'editProfile']);

    // Kantin
    Route::post('/loginKantin', [ApiController::class, 'login']);
    Route::post('/logoutKantin', [ApiController::class, 'logout']);
});

// Route Product
Route::prefix('menu')->group(function () {
    Route::get('/productBestToday/{searchAll?}', [ApiMenuController::class, 'productBestToday'])->where('searchAll', '.*');
    Route::get('/productWithDiscount/{searchAll?}', [ApiMenuController::class, 'productWithDiscount'])->where('searchAll', '.*');
    Route::get('/productAll/{searchAll?}', [ApiMenuController::class, 'product'])->where('searchAll', '.*');
    Route::get('/food/{searchAll?}', [ApiMenuController::class, 'product_food'])->where('searchAll', '.*');
    Route::get('/drink/{searchAll?}', [ApiMenuController::class, 'product_drink'])->where('searchAll', '.*');
});

Route::prefix('transaction')->group(function () {
    Route::post('/', [ApiTransaction::class, 'transaksiCustomer']);
    Route::post('/konfirmasiPesanan', [ApiController::class, 'konfirmasiPesanan']);
    Route::get('/diproses', [ApiTransaction::class, 'pesananDiproses']);
    Route::get('/dikirim', [ApiTransaction::class, 'pesananDikirim']);
    Route::get('/diterima', [ApiTransaction::class, 'pesananDiterima']);
    Route::get('/riwayatTransaction', [ApiTransaction::class, 'riwayatCustomer']);
    Route::post('/listOrderKantin', [ApiController::class, 'listOrdersKantin']);
    // Route::post('/updateStatus', [ApiController::class, 'updateStatusPenjualan']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/transaction/{id_customer}', [ApiTransaction::class, 'tampilTransaksi']);
Route::post('/pesananStatus/{kode_tr}/{status_pesanan}/{status_konfirm}', [ApiTransaction::class, 'tampilStatus']);

Route::post('/kurirStatus/{kode_tr}/{status_konfirm}', [ApiTransaction::class, 'statusKurir']);
Route::get('/detailTransaksi/{kode_tr}', [ApiTransaction::class, 'detailPesanan']);

// Route::post('/customerAccount/{id_customer}', [ApiTransaction::class, 'editCustomer']);

Route::post('/customerAccount', [ApiController::class, 'editCustomer']);
Route::post('/imageProfile', [ApiController::class, 'profileImage']);

Route::get('/profileShow', [ApiController::class, 'tampilCustomer']);

