<?php

namespace App\Http\Controllers;

use App\Http\Requests\TamuUndanganStoreRequest;
use App\Models\Siswa;
use App\Models\TamuUndangan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TamuUndanganController extends Controller
{
    public function index(): View
    {
        $tamus      = TamuUndangan::with('siswa')->latest()->paginate(20);
        $totalSiswa = Siswa::whereIn('status', ['Lulus', 'Lulus Bersyarat'])->count();

        return view('tamu.index', [
            'tamuUndangans' => $tamus,
            'totalPax'      => $tamus->sum('jumlah_tamu'),
            'totalSiswa'    => $totalSiswa,
        ]);
    }

    public function scanQr(): View
    {
        return view('tamu.scan');
    }

    public function processScan(Request $request): RedirectResponse
    {
        $request->validate([
            'kode' => ['required', 'string', 'max:36'],
        ]);

        $kode  = trim($request->input('kode'));
        $siswa = Siswa::where('id', $kode)->orWhere('nisn', $kode)->first();

        if (! $siswa) {
            return back()
                ->withErrors(['kode' => 'Siswa tidak ditemukan. Periksa kode yang dimasukkan.'])
                ->withInput();
        }

        if (! $siswa->isLulus()) {
            return back()
                ->withErrors(['kode' => "Siswa {$siswa->nama} tidak berhak hadir (status: {$siswa->status->getLabel()})."])
                ->withInput();
        }

        return redirect()->route('tamu.konfirmasi', $siswa);
    }

    public function konfirmasi(Siswa $siswa): View
    {
        abort_unless($siswa->isLulus(), 403, 'Siswa tidak berhak hadir.');

        return view('tamu.konfirmasi', [
            'siswa'      => $siswa,
            'sudahHadir' => TamuUndangan::where('siswa_id', $siswa->id)->exists(),
        ]);
    }

    public function store(TamuUndanganStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        TamuUndangan::updateOrCreate(
            ['siswa_id' => $data['siswa_id']],
            ['jumlah_tamu' => $data['jumlah_tamu'] ?? 1],
        );

        return redirect()->route('tamu.index')->with('success', 'Kehadiran berhasil dicatat.');
    }

    public function cetakHadir(): View
    {
        $tamus = TamuUndangan::with('siswa')->oldest()->get();

        return view('tamu.cetak-hadir', [
            'tamus'    => $tamus,
            'totalPax' => $tamus->sum('jumlah_tamu'),
        ]);
    }
}
