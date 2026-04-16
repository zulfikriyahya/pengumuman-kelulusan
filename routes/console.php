<?php

use App\Console\Commands\BroadcastKelulusan;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Broadcast otomatis setiap hari pukul 07:00
| Hanya berjalan jika hari ini adalah hari jadwal_pengumuman_mulai
|--------------------------------------------------------------------------
*/

Schedule::command(BroadcastKelulusan::class)
    ->dailyAt('07:00')
    ->when(
        fn() => \App\Models\TahunPelajaran::where('status', true)
            ->whereDate('jadwal_pengumuman_mulai', today())
            ->exists()
    );

Artisan::command('inspire', function () {
    $this->comment(\Illuminate\Foundation\Inspiring::quote());
})->purpose('Display an inspiring quote');
