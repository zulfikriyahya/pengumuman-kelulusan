<?php

use App\Http\Controllers\AlumniController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PersonilController;
use App\Http\Controllers\TamuUndanganController;
use App\Http\Middleware\JadwalKelulusanAktif;
use Illuminate\Support\Facades\Route;

// ── Landing & Pencarian ────────────────────────────────────────────
Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::post('/cari', [LandingPageController::class, 'cari'])->name('landing.cari');

// ── Siswa: hasil, dokumen & aset ───────────────────────────────────
Route::prefix('/siswa/{siswa}')->name('landing.')->group(function () {
    Route::get('/', [LandingPageController::class, 'hasil'])->name('hasil');

    Route::get('/foto', [LandingPageController::class, 'foto'])
        ->name('foto')
        ->middleware('throttle:60,1');

    Route::get('/skl', [LandingPageController::class, 'cetakSkl'])
        ->name('skl')
        ->middleware('throttle:20,1');

    Route::get('/undangan', [LandingPageController::class, 'cetakUndangan'])
        ->name('undangan')
        ->middleware('throttle:20,1');
});

// ── Personil ───────────────────────────────────────────────────────
Route::prefix('personil')->name('personil.')->controller(PersonilController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/cari', 'search')->name('cari');
});

// ── Alumni ─────────────────────────────────────────────────────────
Route::prefix('alumni')->name('alumni.')->controller(AlumniController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/cari', 'search')->name('cari');
});

// ── Tamu Undangan (dibatasi jadwal kelulusan) ──────────────────────
Route::middleware(JadwalKelulusanAktif::class)
    ->prefix('tamu')
    ->name('tamu.')
    ->controller(TamuUndanganController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/scan', 'scanQr')->name('scan');
        Route::post('/scan', 'processScan')->name('scan.post');
        Route::get('/konfirmasi/{siswa}', 'konfirmasi')->name('konfirmasi');
        Route::post('/', 'store')->name('store');
        Route::get('/cetak-hadir', 'cetakHadir')->name('cetak-hadir');
    });
