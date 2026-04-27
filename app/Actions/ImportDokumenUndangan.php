<?php

namespace App\Actions;

use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class ImportDokumenUndangan
{
    /**
     * Ekstrak ZIP, lalu simpan setiap PDF ke storage berdasarkan nama file (NISN).
     *
     * @return array{berhasil: int, dilewati: int, gagal: int, log: string[]}
     */
    public function executeFromZip(string $zipPath): array
    {
        $berhasil = $dilewati = $gagal = 0;
        $log = [];

        $zip = new ZipArchive();

        if ($zip->open($zipPath) !== true) {
            return [
                'berhasil' => 0,
                'dilewati' => 0,
                'gagal'    => 1,
                'log'      => ['Gagal membuka file ZIP. Pastikan file tidak rusak.'],
            ];
        }

        $tmpDir = storage_path('app/tmp/undangan-' . uniqid());
        mkdir($tmpDir, 0755, true);

        $zip->extractTo($tmpDir);
        $zip->close();

        // Kumpulkan semua PDF dari dalam ZIP (termasuk subfolder)
        $pdfFiles = $this->collectPdfs($tmpDir);

        foreach ($pdfFiles as $pdfPath) {
            $filename = basename($pdfPath);
            $nisn     = Str::beforeLast($filename, '.pdf');

            // Validasi nama file = 10 digit angka
            if (! preg_match('/^\d{10}$/', $nisn)) {
                $log[] = "Dilewati — nama file tidak valid: {$filename}";
                $gagal++;
                continue;
            }

            $siswa = Siswa::where('nisn', $nisn)->first();

            if (! $siswa) {
                $log[] = "Siswa dengan NISN {$nisn} tidak ditemukan.";
                $dilewati++;
                continue;
            }

            // Hapus berkas lama jika ada
            if ($siswa->berkas_undangan && Storage::disk('public')->exists($siswa->berkas_undangan)) {
                Storage::disk('public')->delete($siswa->berkas_undangan);
            }

            $destination = "undangan/{$nisn}.pdf";
            Storage::disk('public')->put($destination, file_get_contents($pdfPath));

            $siswa->update(['berkas_undangan' => $destination]);
            $log[] = "Undangan {$nisn} berhasil diimpor.";
            $berhasil++;
        }

        // Bersihkan direktori temp
        $this->deleteDirectory($tmpDir);

        return compact('berhasil', 'dilewati', 'gagal', 'log');
    }

    /** Kumpulkan semua file .pdf secara rekursif dari sebuah direktori. */
    private function collectPdfs(string $dir): array
    {
        $pdfs = [];

        foreach (scandir($dir) as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }

            $full = $dir . DIRECTORY_SEPARATOR . $entry;

            if (is_dir($full)) {
                $pdfs = array_merge($pdfs, $this->collectPdfs($full));
            } elseif (is_file($full) && strtolower(pathinfo($full, PATHINFO_EXTENSION)) === 'pdf') {
                $pdfs[] = $full;
            }
        }

        return $pdfs;
    }

    /** Hapus direktori beserta isinya secara rekursif. */
    private function deleteDirectory(string $dir): void
    {
        if (! is_dir($dir)) {
            return;
        }

        foreach (scandir($dir) as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }

            $full = $dir . DIRECTORY_SEPARATOR . $entry;
            is_dir($full) ? $this->deleteDirectory($full) : unlink($full);
        }

        rmdir($dir);
    }
}
