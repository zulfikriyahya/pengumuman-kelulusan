<?php

namespace App\Console\Commands;

use App\Jobs\BroadcastPesanKelulusan;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use Illuminate\Console\Command;

class BroadcastKelulusan extends Command
{
    protected $signature   = 'skl:broadcast {--force : Kirim tanpa cek jadwal}';
    protected $description = 'Broadcast pesan kelulusan via WhatsApp ke seluruh siswa yang memiliki nomor.';

    public function handle(): int
    {
        $tp = TahunPelajaran::where('status', true)->first();

        if (! $tp) {
            $this->error('Tidak ada Tahun Pelajaran aktif.');
            return self::FAILURE;
        }

        $dalamJadwal = now()->between(
            $tp->jadwal_pengumuman_mulai,
            $tp->jadwal_pengumuman_selesai,
        );

        if (! $this->option('force') && ! $dalamJadwal) {
            $this->warn('Belum dalam rentang jadwal pengumuman. Gunakan --force untuk memaksa.');
            return self::FAILURE;
        }

        $siswas = Siswa::whereNotNull('telepon')->get();
        $total  = $siswas->count();

        if ($total === 0) {
            $this->warn('Tidak ada siswa dengan nomor telepon terdaftar.');
            return self::SUCCESS;
        }

        $this->info("Mengirim ke {$total} siswa...");
        $bar    = $this->output->createProgressBar($total);
        $bar->start();

        // Delay akumulatif agar job tidak membanjiri API sekaligus
        $offsetDetik = 0;

        foreach ($siswas as $siswa) {
            $offsetDetik += rand(2, 8);

            BroadcastPesanKelulusan::dispatch($siswa, $tp)
                ->delay(now()->addSeconds($offsetDetik));

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Semua {$total} job berhasil di-dispatch. Estimasi selesai: ~{$offsetDetik} detik.");

        return self::SUCCESS;
    }
}
