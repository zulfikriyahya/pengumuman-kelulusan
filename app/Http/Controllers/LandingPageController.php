<?php

namespace App\Http\Controllers;

use App\Http\Requests\LandingPageCariRequest;
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
        $tahunPelajaran = TahunPelajaran::aktif()->first();

        return view('landing.index', [
            'tahunPelajaran' => $tahunPelajaran,
        ]);
    }

    public function cari(LandingPageCariRequest $request): View
    {
        $keyword = $request->keyword();

        $siswa = Siswa::where('nisn', $keyword)
            ->orWhere('telepon', $keyword)
            ->first();

        return view('landing.hasil', [
            'siswa' => $siswa,
            'keyword' => $keyword,
        ]);
    }

    public function hasil(Siswa $siswa): View
    {
        return view('landing.hasil', [
            'siswa' => $siswa,
            'keyword' => $siswa->nisn,
        ]);
    }

    public function cetakSkl(Siswa $siswa): View
    {
        $tahunPelajaran = TahunPelajaran::aktif()->first();

        return view('landing.skl', [
            'siswa' => $siswa,
            'tahunPelajaran' => $tahunPelajaran,
        ]);
    }

    public function cetakSklPdf(Siswa $siswa): Response
    {
        $instansi = Instansi::first();
        $tahunPelajaran = TahunPelajaran::aktif()->first();

        $pdf = Pdf::loadView('pdf.skl', compact('siswa', 'instansi', 'tahunPelajaran'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("SKL-{$siswa->nisn}.pdf");
    }

    public function cetakUndangan(Siswa $siswa): View
    {
        abort_unless($siswa->isLulus(), 403, 'Siswa tidak berhak mendapatkan surat undangan.');

        $tahunPelajaran = TahunPelajaran::aktif()->first();

        return view('landing.undangan', [
            'siswa' => $siswa,
            'tahunPelajaran' => $tahunPelajaran,
        ]);
    }

    public function cetakUndanganPdf(Siswa $siswa): Response
    {
        abort_unless($siswa->isLulus(), 403, 'Siswa tidak berhak mendapatkan surat undangan.');

        $instansi = Instansi::first();
        $tahunPelajaran = TahunPelajaran::aktif()->first();

        $pdf = Pdf::loadView('pdf.undangan', compact('siswa', 'instansi', 'tahunPelajaran'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("Undangan-{$siswa->nisn}.pdf");
    }
}
