<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Instansi;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    public function index(Request $request): View
    {
        return view('landing.index');
        // $tahunPelajaran sudah di-share global via AppServiceProvider
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
            'siswa'   => $siswa,
            'keyword' => $siswa->nisn,
        ]);
    }

    // ── Dokumen ────────────────────────────────────────────────────

    public function cetakSkl(Siswa $siswa): View
    {
        return view('landing.skl', compact('siswa'));
        // $tahunPelajaran sudah global
    }

    public function cetakSklPdf(Siswa $siswa): Response
    {
        return $this->renderPdf('pdf.skl', $siswa, "SKL-{$siswa->nisn}.pdf");
    }

    public function cetakUndangan(Siswa $siswa): View
    {
        abort_unless($siswa->isLulus(), 403, 'Siswa tidak berhak mendapatkan surat undangan.');

        return view('landing.undangan', compact('siswa'));
    }

    public function cetakUndanganPdf(Siswa $siswa): Response
    {
        abort_unless($siswa->isLulus(), 403, 'Siswa tidak berhak mendapatkan surat undangan.');

        return $this->renderPdf('pdf.undangan', $siswa, "Undangan-{$siswa->nisn}.pdf");
    }

    // ── Helper ─────────────────────────────────────────────────────

    /**
     * Render view sebagai PDF dan langsung download.
     * Menghilangkan duplikasi Pdf::loadView() di dua method cetak.
     */
    private function renderPdf(string $view, Siswa $siswa, string $filename): Response
    {
        $instansi       = Instansi::first();
        $tahunPelajaran = TahunPelajaran::aktif()->first();

        return Pdf::loadView($view, compact('siswa', 'instansi', 'tahunPelajaran'))
            ->setPaper('a4', 'portrait')
            ->download($filename);
    }
}
