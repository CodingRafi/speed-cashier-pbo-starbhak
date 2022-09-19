<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('/user', UserController::class);
    Route::resource('/menu', MenuController::class);
    Route::resource('/meja', MejaController::class);
    Route::resource('/kategori', KategoriController::class);
    Route::resource('/transaksi', TransaksiController::class);
    Route::resource('/pesanan', PesananController::class);
    Route::get('/downloadPDF',[TransaksiController::class, 'pdf']);
    Route::get('/bayar/{id}',[TransaksiController::class,"payment"])->name('paypal.payment');
    Route::get('/paypal-success',[TransaksiController::class,"success"])->name('paypal.success');
    Route::get('/paypal-cancel',[TransaksiController::class,'cancel'])->name('paypal.cancel');
});


require __DIR__.'/auth.php';

Route::get('/kota', function() {
    return view('kota.index');
});

Route::get('/meja', function() {
    return view('meja.index');
});

Route::get('/registerRestoran', function() {
    return view('auth.registerRestoran');
});

Route::get('/restoran', function() {
    return view('restoran.index');
});

Route::get('/restoran-create', function() {
    return view('restoran.create');
});