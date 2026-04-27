<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPeopleIndex;
use App\Models\Personil;

class PersonilController extends Controller
{
    use HasPeopleIndex;

    protected function model(): string
    {
        return Personil::class;
    }
    protected function indexView(): string
    {
        return 'personil.index';
    }
    protected function searchColumns(): array
    {
        return ['nama'];
    }
    protected function paginated(): bool
    {
        return false;
    }
}
