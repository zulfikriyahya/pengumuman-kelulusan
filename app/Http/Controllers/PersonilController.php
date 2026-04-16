<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonilCariRequest;
use App\Models\Personil;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PersonilController extends Controller
{
    public function index(Request $request): View
    {
        $personils = Personil::orderBy('jabatan')->get();

        return view('personil.index', [
            'personils' => $personils,
        ]);
    }

    public function cari(PersonilCariRequest $request): View
    {
        $keyword = $request->validated('nama');

        $personils = Personil::where('nama', 'like', "%{$keyword}%")
            ->orderBy('jabatan')
            ->get();

        return view('personil.index', [
            'personils' => $personils,
            'keyword'   => $keyword,
        ]);
    }
}
