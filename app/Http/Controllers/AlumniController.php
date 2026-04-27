<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPeopleIndex;
use App\Models\Alumni;

class AlumniController extends Controller
{
    use HasPeopleIndex;

    protected function model(): string
    {
        return Alumni::class;
    }
    protected function indexView(): string
    {
        return 'alumni.index';
    }
    protected function searchColumns(): array
    {
        return ['nisn', 'nama'];
    }
}
