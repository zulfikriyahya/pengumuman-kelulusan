<?php

namespace App\Providers;

use App\Models\Instansi;
use App\Models\TahunPelajaran;
use Carbon\Carbon;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        FilamentColor::register([
            'danger'  => Color::hex('#FF0022'),
            'info'    => Color::hex('#00FFEA'),
            'primary' => Color::hex('#BF00FF'),
            'success' => Color::hex('#00FF41'),
            'warning' => Color::hex('#FF6D00'),
        ]);

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));
        }

        setlocale(LC_TIME, 'id_ID.utf8');
        Carbon::setLocale('id');

        // Share instansi ke semua view
        $instansiArray = Cache::remember('instansi.aktif', now()->addHour(), function () {
            $data = Instansi::first();
            return $data ? $data->toArray() : null;
        });
        $instansi = $instansiArray ? (object) $instansiArray : null;
        View::share('instansi', $instansi);

        // Share tahun pelajaran aktif ke semua view
        $tahunPelajaran = TahunPelajaran::where('status', true)->first();
        View::share('tahunPelajaran', $tahunPelajaran);
    }
}
