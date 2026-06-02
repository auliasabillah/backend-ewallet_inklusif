<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ProfileController;
use App\Models\User;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/* USER */
Route::get('/saldo/{user_id}', [WalletController::class, 'getSaldo']);
Route::post('/topup', [WalletController::class, 'topUp']);
Route::post('/transfer', [WalletController::class, 'transfer']);
Route::post('/payment', [WalletController::class, 'payment']);
Route::get('/pengeluaran-harian/{user_id}', [WalletController::class, 'getPengeluaranPerHari']);

Route::get('/riwayat/{user_id}', [TransaksiController::class, 'getRiwayat']);
Route::get('/pengeluaran/{user_id}', [TransaksiController::class, 'getPengeluaranHariIni']);

Route::put('/profile/{id}', [ProfileController::class, 'update']);
Route::post('/upload-photo', [ProfileController::class, 'uploadPhoto']);

/* ADMIN */
Route::get('/users', function () {
    return User::all();
});

Route::get('/transaksi', [TransaksiController::class, 'getAllTransaksi']);
Route::delete('/users/{id}', [AuthController::class, 'deleteUser']);
Route::put('/users/{id}', [AuthController::class, 'updateUser']);

