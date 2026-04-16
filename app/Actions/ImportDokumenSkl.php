<?php

namespace App\Actions;

use App\Models\Siswa;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportDokumenSkl
{
    /**
     * @param  UploadedFile[]  $files
     * @return array{berhasil: int, dilewati: int, gagal: int, log: string[]}
     */
    public function execute(array $files): array
    {
        $berhasil = $dilewati = $gagal = 0;
        $log = [];

        foreach ($files as $file) {
            $nisn = Str::beforeLast($file->getClientOriginalName(), '.pdf');

            if (! preg_match('/^\d{10}$/', $nisn)) {
                $log[] = "Dilewati — nama file tidak valid: {$file->getClientOriginalName()}";
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
            if ($siswa->berkas_skl && Storage::disk('public')->exists($siswa->berkas_skl)) {
                Storage::disk('public')->delete($siswa->berkas_skl);
            }

            $path = $file->storeAs('skl', "{$nisn}.pdf", 'public');

            $siswa->update(['berkas_skl' => $path]);
            $log[] = "SKL {$nisn} berhasil diimpor.";
            $berhasil++;
        }

        return compact('berhasil', 'dilewati', 'gagal', 'log');
    }
}
