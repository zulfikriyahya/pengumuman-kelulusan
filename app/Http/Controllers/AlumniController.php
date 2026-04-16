<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlumnusCariRequest;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlumniController extends Controller
{
    public function index(Request $request): View
    {
        $alumnis = Alumni::orderBy('nama')->paginate(12);

        return view('alumni.index', ['alumnis' => $alumnis]);
    }

    public function cari(AlumnusCariRequest $request): View
    {
        // fix: ambil keyword dari field yang terisi
        $keyword = $request->filled('nisn')
            ? $request->validated('nisn')
            : $request->validated('nama');

        $alumnis = Alumni::where('nisn', $keyword)
            ->orWhere('nama', 'like', "%{$keyword}%")
            ->orderBy('nama')
            ->paginate(12)
            ->withQueryString();

        return view('alumni.index', [
            'alumnis' => $alumnis,
            'keyword' => $keyword,
        ]);
    }
}
