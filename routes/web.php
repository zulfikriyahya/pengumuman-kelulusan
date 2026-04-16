<?php

use App\Http\Controllers\AlumniController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PersonilController;
use App\Http\Controllers\TamuUndanganController;
use App\Http\Middleware\JadwalKelulusanAktif;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::post('/cari', [LandingPageController::class, 'cari'])->name('landing.cari');
Route::get('/siswa/{siswa}', [LandingPageController::class, 'hasil'])->name('landing.hasil');
Route::get('/siswa/{siswa}/skl', [LandingPageController::class, 'cetakSkl'])
    ->name('landing.skl')
    ->middleware('throttle:30,1');
Route::get('/siswa/{siswa}/skl/pdf', [LandingPageController::class, 'cetakSklPdf'])
    ->name('landing.skl.pdf')
    ->middleware('throttle:10,1');
Route::get('/siswa/{siswa}/undangan', [LandingPageController::class, 'cetakUndangan'])
    ->name('landing.undangan')
    ->middleware('throttle:30,1');
Route::get('/siswa/{siswa}/undangan/pdf', [LandingPageController::class, 'cetakUndanganPdf'])
    ->name('landing.undangan.pdf')
    ->middleware('throttle:10,1');

Route::get('/personil', [PersonilController::class, 'index'])->name('personil.index');
Route::get('/personil/cari', [PersonilController::class, 'cari'])->name('personil.cari');

Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
Route::get('/alumni/cari', [AlumniController::class, 'cari'])->name('alumni.cari');

Route::middleware(JadwalKelulusanAktif::class)
    ->prefix('tamu')
    ->name('tamu.')
    ->group(function () {
        Route::get('/', [TamuUndanganController::class, 'index'])->name('index');
        Route::get('/scan', [TamuUndanganController::class, 'scanQr'])->name('scan');
        Route::post('/scan', [TamuUndanganController::class, 'processScan'])->name('scan.post');
        Route::get('/konfirmasi/{siswa}', [TamuUndanganController::class, 'konfirmasi'])->name('konfirmasi');
        Route::post('/', [TamuUndanganController::class, 'store'])->name('store');
        Route::get('/cetak-hadir', [TamuUndanganController::class, 'cetakHadir'])->name('cetak-hadir');
    });
