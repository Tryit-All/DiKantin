<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SuccesController;
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
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/allOrder', [orderController::class, 'get_all_order']);
    Route::delete('/allOrder/{id}', [orderController::class, 'delete_order']);
    Route::get('/success', [SuccesController::class, 'index']);
    Route::delete('/success/{id}', [SuccesController::class, 'delete_success']);

    Route::get('/kasir/{id}', [KasirController::class, 'struk']);
    Route::get('/kasir', [KasirController::class, 'index']);
    Route::post('/kasir', [KasirController::class, 'order']);
    Route::get('/kasir/{id}/{datetime}', [KasirController::class, 'reload']);
    Route::get('/kasir/hapussemua/{id}', [KasirController::class, 'hapussemua']);

});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
