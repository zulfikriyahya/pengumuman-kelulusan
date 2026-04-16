<?php

namespace App\Providers;

use App\Models\Instansi;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        view()->composer('*', function ($view) {
            // fix: cache query agar tidak hit DB di setiap request
            $instansi = Cache::remember('instansi.aktif', now()->addHour(), fn() => Instansi::first());
            $view->with('instansi', $instansi);
        });
    }
}
