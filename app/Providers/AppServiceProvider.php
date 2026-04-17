<?php

namespace App\Providers;

use App\Models\Instansi;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        FilamentColor::register([
            'danger'    => Color::hex('#FF0022'), // Savage Red
            // 'gray'      => Color::hex('#3D3D3D'), // Gunmetal
            'info'      => Color::hex('#00FFEA'), // Toxic Cyan
            'primary'   => Color::hex('#BF00FF'), // Electric Violet
            'success'   => Color::hex('#00FF41'), // Matrix Green
            'warning'   => Color::hex('#FF6D00'), // Inferno Orange
            'secondary' => Color::hex('#FF007F'), // Shock Pink
        ]);
    }

    public function boot(): void
    {
        $instansiArray = Cache::remember('instansi.aktif', now()->addHour(), function () {
            $data = Instansi::first();

            return $data ? $data->toArray() : null;
        });
        $instansi = $instansiArray ? (object) $instansiArray : null;
        View::share('instansi', $instansi);
    }
}
