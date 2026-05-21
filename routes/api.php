<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ProfileController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/saldo/{user_id}', [WalletController::class, 'getSaldo']);
Route::post('/topup', [WalletController::class, 'topUp']);
Route::get('/saldo/{user_id}', [WalletController::class, 'getSaldo']);
Route::get('/riwayat/{user_id}', [TransaksiController::class, 'getRiwayat']);
Route::post('/transfer', [WalletController::class, 'transfer']);
Route::post('/payment', [WalletController::class, 'payment']);
Route::put('/profile/{id}', [ProfileController::class, 'update']);
Route::get('/pengeluaran/{user_id}', [TransaksiController::class, 'getPengeluaranHariIni']);