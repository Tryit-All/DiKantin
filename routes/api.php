<?php

use App\Http\Controllers\ApiController;
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
    Route::post('/login', [ApiController::class, 'loginUser']);
    Route::post('/register', [ApiController::class, 'registerUser']);
    Route::post('/forgotPassword', [ApiController::class, 'forgotPassword']);
    Route::post('/verified/{id}', [ApiController::class, 'verified']);
});

// Route Product
Route::prefix('product')->group(function () {
    Route::get('/', [ApiController::class, 'product']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});