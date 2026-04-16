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
    public function index(Request $request): View
    {
        $tamus = TamuUndangan::with('siswa')
            ->orderByDesc('created_at')
            ->paginate(20);

        // fix: hitung total PAX dari DB, bukan dari paginator (yang hanya halaman aktif)
        $totalPax    = TamuUndangan::sum('jumlah_tamu');
        $totalSiswa  = Siswa::whereIn('status', ['Lulus', 'Lulus Bersyarat'])->count();

        return view('tamu.index', [
            'tamuUndangans' => $tamus,
            'totalPax'      => $totalPax,
            'totalSiswa'    => $totalSiswa,
        ]);
    }

    public function scanQr(Request $request): View
    {
        return view('tamu.scan');
    }

    // fix: method baru — proses scan QR manual (POST dari form)
    public function processScan(Request $request): RedirectResponse
    {
        $request->validate([
            'kode' => ['required', 'string'],
        ]);

        $kode  = $request->input('kode');
        $siswa = Siswa::where('id', $kode)
            ->orWhere('nisn', $kode)
            ->first();

        if (! $siswa) {
            return back()->withErrors(['kode' => 'Siswa tidak ditemukan.'])->withInput();
        }

        return redirect()->route('tamu.konfirmasi', $siswa);
    }

    // fix: method baru — halaman konfirmasi kehadiran
    public function konfirmasi(Siswa $siswa): View
    {
        $sudahHadir = TamuUndangan::where('siswa_id', $siswa->id)->exists();

        return view('tamu.konfirmasi', [
            'siswa'       => $siswa,
            'sudahHadir'  => $sudahHadir,
        ]);
    }

    public function store(TamuUndanganStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        TamuUndangan::updateOrCreate(
            ['siswa_id'    => $data['siswa_id']],
            ['jumlah_tamu' => $data['jumlah_tamu'] ?? 1],
        );

        return redirect()->route('tamu.index')
            ->with('success', 'Tamu berhasil dicatat.');
    }

    // fix: method baru — cetak daftar hadir (view/PDF sederhana)
    public function cetakHadir(): View
    {
        $tamus = TamuUndangan::with('siswa')
            ->orderBy('created_at')
            ->get();

        return view('tamu.cetak-hadir', [
            'tamus'    => $tamus,
            'totalPax' => $tamus->sum('jumlah_tamu'),
        ]);
    }
}
