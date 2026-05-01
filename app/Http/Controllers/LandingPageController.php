<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LandingPageController extends Controller
{
    // ── Landing & Pencarian ─────────────────────────────────────────

    public function index(): View
    {
        return view('landing.index');
    }

    public function cari(SearchRequest $request): View
    {
        $keyword = $request->keyword();

        $siswa = Siswa::where('nisn', $keyword)
            ->orWhere('telepon', $keyword)
            ->first();

        return view('landing.hasil', compact('siswa', 'keyword'));
    }

    public function hasil(Siswa $siswa): View
    {
        return view('landing.hasil', [
            'siswa' => $siswa,
            'keyword' => $siswa->nisn,
        ]);
    }

    public function foto(Siswa $siswa): StreamedResponse
    {
        abort_unless($siswa->foto && Storage::disk('local')->exists($siswa->foto), 404);

        return Storage::disk('local')->response($siswa->foto, null, [
            'Content-Type' => Storage::disk('local')->mimeType($siswa->foto),
            'Cache-Control' => 'private, max-age=3600',
        ]);
    }

    // ── Dokumen: stream PDF dari storage ───────────────────────────

    /**
     * Download SKL (PDF yang sudah di-upload via dashboard).
     * Disk: local → storage/app/private/berkas-skl/{uuid}.pdf
     */
    public function cetakSkl(Siswa $siswa): StreamedResponse
    {
        abort_unless((bool) $siswa->berkas_skl, 404, 'Berkas SKL belum tersedia.');
        abort_unless(Storage::disk('local')->exists($siswa->berkas_skl), 404, 'File SKL tidak ditemukan.');

        return $this->streamPdf(
            disk: 'local',
            path: $siswa->berkas_skl,
            filename: 'SKL_'.$this->safeFilename($siswa->nama).'_'.$siswa->nisn.'.pdf',
            inline: true,
        );
    }

    /**
     * Download Surat Undangan (PDF yang sudah di-upload via dashboard).
     * Disk: local → storage/app/private/berkas-undangan/{uuid}.pdf
     */
    public function cetakUndangan(Siswa $siswa): StreamedResponse
    {
        abort_unless($siswa->isLulus(), 403, 'Siswa tidak berhak mendapatkan surat undangan.');
        abort_unless((bool) $siswa->berkas_undangan, 404, 'Berkas undangan belum tersedia.');
        abort_unless(Storage::disk('local')->exists($siswa->berkas_undangan), 404, 'File undangan tidak ditemukan.');

        return $this->streamPdf(
            disk: 'local',
            path: $siswa->berkas_undangan,
            filename: 'Undangan_'.$this->safeFilename($siswa->nama).'_'.$siswa->nisn.'.pdf',
            inline: true,
        );
    }

    // ── Helpers ─────────────────────────────────────────────────────

    /**
     * Stream file PDF dari Storage ke browser.
     *
     * @param  string  $disk  Nama disk Laravel (public / local / s3 …)
     * @param  string  $path  Path relatif di dalam disk
     * @param  string  $filename  Nama file yang diterima browser
     * @param  bool  $inline  true = tampil di tab browser; false = force-download
     */
    private function streamPdf(
        string $disk,
        string $path,
        string $filename,
        bool $inline = true,
    ): StreamedResponse {
        $disposition = $inline ? 'inline' : 'attachment';

        return Storage::disk($disk)->response($path, $filename, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "{$disposition}; filename=\"{$filename}\"",
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * Sanitasi nama file: hapus karakter non-alfanumerik, ganti spasi → underscore.
     */
    private function safeFilename(string $name): string
    {
        $clean = preg_replace('/[^A-Za-z0-9\s_-]/u', '', $name);

        return str_replace(' ', '_', trim($clean));
    }
}
