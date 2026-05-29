<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AsupanController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PilihanSehatController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\UsdaProxyController;

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'register']);
Route::get('/usda-proxy', [UsdaProxyController::class, 'proxyUsdaApi']);

Route::middleware('auth.token')->group(function () {
    Route::get('asupan', [AsupanController::class, 'index']);
    Route::post('asupan', [AsupanController::class, 'store']);
    Route::put('asupan/{asupan}', [AsupanController::class, 'update']);
    Route::delete('asupan/{asupan}', [AsupanController::class, 'destroy']);
    Route::post('laporan', [LaporanController::class, 'store']);
    Route::get('sehat', [PilihanSehatController::class, 'index']);
    Route::get('sehat/{kategori}', [PilihanSehatController::class, 'index']);
    Route::get('dashboard', [AsupanController::class, 'dashboard']);
    Route::get('dashboard/daily-totals', [AsupanController::class, 'getDailyTotals']);
    Route::get('profile', [ProfilController::class, 'getProfileData']);
    Route::post('profile', [ProfilController::class, 'updateForPostman']);
    Route::put('profile', [ProfilController::class, 'updateForPostman']);
    Route::post('profile/password', [ProfilController::class, 'updatePassword']);
    Route::post('konsultasi', [KonsultasiController::class, 'sendForPostman']);
    Route::post('logout', [LoginController::class, 'logout']);
});

Route::middleware(['auth.token', 'admin'])->prefix('admin')->group(function () {
    Route::get('pilihan-sehat', [PilihanSehatController::class, 'adminApiIndex']);
    Route::post('pilihan-sehat', [PilihanSehatController::class, 'store']);
    Route::put('pilihan-sehat/{pilihanSehat}', [PilihanSehatController::class, 'update']);
    Route::delete('pilihan-sehat/{pilihanSehat}', [PilihanSehatController::class, 'destroy']);
});
