<?php

namespace App\Http\Middleware;

use App\Models\TahunPelajaran;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JadwalKelulusanAktif
{
    public function handle(Request $request, Closure $next): Response
    {
        $tp = TahunPelajaran::where('status', true)->first();

        $aktif = $tp
            && $tp->jadwal_kelulusan_mulai
            && $tp->jadwal_kelulusan_selesai
            && now()->between($tp->jadwal_kelulusan_mulai, $tp->jadwal_kelulusan_selesai);

        if (! $aktif) {
            return redirect()->route('landing')
                ->with('info', 'Halaman tamu undangan belum tersedia.');
        }

        return $next($request);
    }
}