<?php

namespace App\Actions;

use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class ImportDokumen
{
    /**
     * @param  string  $zipPath  Path absolut ke file ZIP
     * @param  string  $kolom  Kolom pada model Siswa: 'berkas_skl' | 'berkas_undangan'
     * @param  string  $dir  Direktori storage tujuan: 'skl' | 'undangan'
     * @param  string  $label  Label untuk log/notifikasi: 'SKL' | 'Undangan'
     * @return array{berhasil: int, dilewati: int, gagal: int, log: string[]}
     */
    public function execute(string $zipPath, string $kolom, string $dir, string $label): array
    {
        $berhasil = $dilewati = $gagal = 0;
        $log = [];

        $zip = new ZipArchive;

        if ($zip->open($zipPath) !== true) {
            return [
                'berhasil' => 0,
                'dilewati' => 0,
                'gagal' => 1,
                'log' => ['Gagal membuka file ZIP. Pastikan file tidak rusak.'],
            ];
        }

        $tmpDir = storage_path('app/tmp/'.Str::slug($label).'-'.uniqid());
        mkdir($tmpDir, 0755, true);

        $zip->extractTo($tmpDir);
        $zip->close();

        foreach ($this->collectPdfs($tmpDir) as $pdfPath) {
            $filename = basename($pdfPath);
            $nisn = Str::beforeLast($filename, '.pdf');

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

            $oldPath = $siswa->getAttribute($kolom);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            $destination = "{$dir}/{$nisn}.pdf";
            Storage::disk('public')->put($destination, file_get_contents($pdfPath));

            $siswa->update([$kolom => $destination]);
            $log[] = "{$label} {$nisn} berhasil diimpor.";
            $berhasil++;
        }

        $this->deleteDirectory($tmpDir);

        return compact('berhasil', 'dilewati', 'gagal', 'log');
    }

    /**
     * Alias untuk kompatibilitas pemanggilan lama.
     *
     * @deprecated Gunakan execute() dengan parameter eksplisit.
     */
    public function executeFromZip(string $zipPath): array
    {
        return $this->execute($zipPath, 'berkas_skl', 'skl', 'SKL');
    }

    private function collectPdfs(string $dir): array
    {
        $pdfs = [];

        foreach (scandir($dir) as $entry) {
            if (in_array($entry, ['.', '..'], true)) {
                continue;
            }

            $full = $dir.DIRECTORY_SEPARATOR.$entry;

            if (is_dir($full)) {
                $pdfs = array_merge($pdfs, $this->collectPdfs($full));
            } elseif (is_file($full) && strtolower(pathinfo($full, PATHINFO_EXTENSION)) === 'pdf') {
                $pdfs[] = $full;
            }
        }

        return $pdfs;
    }

    private function deleteDirectory(string $dir): void
    {
        if (! is_dir($dir)) {
            return;
        }

        foreach (scandir($dir) as $entry) {
            if (in_array($entry, ['.', '..'], true)) {
                continue;
            }

            $full = $dir.DIRECTORY_SEPARATOR.$entry;
            is_dir($full) ? $this->deleteDirectory($full) : unlink($full);
        }

        rmdir($dir);
    }
}
