<?php

namespace App\Jobs;

use App\Models\Siswa;
use App\Models\TahunPelajaran;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BroadcastPesanKelulusan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $backoff = 60;

    public function __construct(
        private readonly Siswa $siswa,
        private readonly TahunPelajaran $tahunPelajaran,
    ) {}

    public function handle(): void
    {
        if (blank($this->siswa->telepon)) {
            return;
        }

        $pesan = $this->buildPesan();
        $response = Http::withToken(config('services.wapi.token'))
            ->timeout(15)
            ->post(config('services.wapi.url'), [
                'phone' => $this->siswa->telepon,
                'message' => $pesan,
            ]);
        if ($response->failed()) {
            Log::warning("WA gagal ke {$this->siswa->nisn} (attempt {$this->attempts()}): ".$response->body());

            throw new \RuntimeException("Gagal kirim WA ke {$this->siswa->nisn}: HTTP {$response->status()}");
        }

        Log::info("WA terkirim ke {$this->siswa->nisn}");
    }

    private function buildPesan(): string
    {
        $tp = $this->tahunPelajaran;
        $url = config('app.url');

        $pesan = "Assalamu'alaikum, {$this->siswa->nama}.\n\n";
        $pesan .= "Pengumuman Kelulusan sudah dapat diakses pada:\n";
        $pesan .= "🔗 {$url}\n\n";

        $adaJadwal = $tp->jadwal_kelulusan_mulai
            && $tp->jadwal_kelulusan_selesai
            && $tp->jadwal_kelulusan_tempat;

        if ($adaJadwal) {
            $mulai = $tp->jadwal_kelulusan_mulai->translatedFormat('l, d F Y H:i');
            $selesai = $tp->jadwal_kelulusan_selesai->translatedFormat('H:i');

            $pesan .= "📅 Acara Kelulusan:\n";
            $pesan .= "Tanggal : {$mulai} – {$selesai} WIB\n";
            $pesan .= "Tempat  : {$tp->jadwal_kelulusan_tempat}\n\n";
        }

        $pesan .= 'Selamat & semoga sukses!';

        return $pesan;
    }

    public function failed(\Throwable $e): void
    {
        Log::error("Broadcast WA gagal permanen untuk {$this->siswa->nisn}: ".$e->getMessage());
    }
}
