<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class ImportFoto
{
    /**
     * Ekstensi gambar yang didukung.
     */
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];

    /**
     * @param  string  $zipPath  Path absolut ke file ZIP
     * @param  class-string  $modelClass  Model Eloquent target (Siswa::class, dll.)
     * @param  string  $identifierCol  Kolom pencocok nama file, mis. 'nisn' atau 'nip'
     * @param  string  $fotoCol  Kolom yang menyimpan path foto, mis. 'foto' atau 'avatar'
     * @param  string  $storageDir  Direktori tujuan di disk public, mis. 'foto-siswa'
     * @return array{berhasil: int, dilewati: int, gagal: int, log: string[]}
     */
    public function execute(
        string $zipPath,
        string $modelClass,
        string $identifierCol,
        string $fotoCol,
        string $storageDir,
    ): array {
        $berhasil = $dilewati = $gagal = 0;
        $log = [];

        // Buka ZIP
        $zip = new ZipArchive;
        if ($zip->open($zipPath) !== true) {
            return [
                'berhasil' => 0,
                'dilewati' => 0,
                'gagal' => 1,
                'log' => ['Gagal membuka file ZIP. Pastikan file tidak rusak.'],
            ];
        }

        $tmpDir = storage_path('app/tmp/foto-'.uniqid());
        mkdir($tmpDir, 0755, true);
        $zip->extractTo($tmpDir);
        $zip->close();

        $images = $this->collectImages($tmpDir);

        if (empty($images)) {
            $this->deleteDirectory($tmpDir);

            return [
                'berhasil' => 0,
                'dilewati' => 0,
                'gagal' => 1,
                'log' => ['Tidak ada file gambar yang ditemukan di dalam ZIP.'],
            ];
        }

        foreach ($images as $imagePath) {
            $filename = basename($imagePath);
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $identifier = Str::beforeLast($filename, '.'.$ext);

            // Validasi: identifier tidak boleh kosong
            if (blank($identifier)) {
                $log[] = "Dilewati — nama file tidak valid: {$filename}";
                $gagal++;

                continue;
            }

            /** @var Model|null $record */
            $record = $modelClass::where($identifierCol, $identifier)->first();

            if (! $record) {
                $log[] = "Data dengan {$identifierCol} '{$identifier}' tidak ditemukan — {$filename} dilewati.";
                $dilewati++;

                continue;
            }

            // Hapus foto lama jika ada
            $oldPath = $record->getAttribute($fotoCol);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            // Simpan foto baru dengan nama bersih: {identifier}.{ext}
            $destination = "{$storageDir}/{$identifier}.{$ext}";
            Storage::disk('public')->put($destination, file_get_contents($imagePath));

            $record->update([$fotoCol => $destination]);
            $log[] = "Foto '{$identifier}' berhasil diimpor.";
            $berhasil++;
        }

        $this->deleteDirectory($tmpDir);

        return compact('berhasil', 'dilewati', 'gagal', 'log');
    }

    /**
     * Kumpulkan semua file gambar secara rekursif dari direktori.
     */
    private function collectImages(string $dir): array
    {
        $results = [];

        foreach (scandir($dir) as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }

            // Lewati file/folder tersembunyi (mis. __MACOSX dari macOS ZIP)
            if (str_starts_with($entry, '.') || str_starts_with($entry, '__')) {
                continue;
            }

            $full = $dir.DIRECTORY_SEPARATOR.$entry;

            if (is_dir($full)) {
                $results = array_merge($results, $this->collectImages($full));
            } elseif (
                is_file($full) &&
                in_array(strtolower(pathinfo($full, PATHINFO_EXTENSION)), self::ALLOWED_EXTENSIONS, true)
            ) {
                $results[] = $full;
            }
        }

        return $results;
    }

    /**
     * Hapus direktori beserta isinya secara rekursif.
     */
    private function deleteDirectory(string $dir): void
    {
        if (! is_dir($dir)) {
            return;
        }

        foreach (scandir($dir) as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }

            $full = $dir.DIRECTORY_SEPARATOR.$entry;
            is_dir($full) ? $this->deleteDirectory($full) : unlink($full);
        }

        rmdir($dir);
    }
}
