<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChemistryController;

// =======================
// Public Routes
// =======================
Route::get('/', [ChemistryController::class, 'landing'])->name('landing');
Route::get('/materi', [ChemistryController::class, 'materi'])->name('materi');
Route::get('/simulasi', [ChemistryController::class, 'simulasi'])->name('simulasi');

// =======================
// Quiz Routes (Student)
// =======================
Route::prefix('kuis')->name('kuis.')->group(function () {
    Route::get('/', [ChemistryController::class, 'kuis'])->name('index');
    Route::post('/login', [ChemistryController::class, 'kuisLogin'])->name('login');
    Route::get('/soal', [ChemistryController::class, 'kuisSoal'])->name('soal');
    Route::post('/submit', [ChemistryController::class, 'kuisSubmit'])->name('submit');
});

// =======================
// Teacher Dashboard Routes
// =======================
Route::prefix('guru')->name('guru.')->group(function () {
    Route::get('/login', [ChemistryController::class, 'guruLogin'])->name('login');
    Route::post('/auth', [ChemistryController::class, 'guruAuth'])->name('auth');

    Route::get('/dashboard', [ChemistryController::class, 'guruDashboard'])->name('dashboard');
    Route::get('/export', [ChemistryController::class, 'guruExport'])->name('export');

    Route::post('/logout', [ChemistryController::class, 'guruLogout'])->name('logout');
    Route::get('/logout', [ChemistryController::class, 'guruLogout'])->name('logout.get');
});

// =======================
// Fallback (404)
// =======================
Route::fallback(function () {
    return response()->view('errors.404', [
        'title' => 'Halaman Tidak Ditemukan',
        'message' => 'Maaf, halaman yang Anda cari tidak dapat ditemukan.'
    ], 404);
});

Route::get('/simulasi-molekul', [ChemistryController::class, 'simulasiMolekul'])->name('simulasi.molekul');