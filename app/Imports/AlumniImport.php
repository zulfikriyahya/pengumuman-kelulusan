<?php

namespace App\Imports;

use App\Models\Alumni;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class AlumniImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row): ?Alumni
    {
        if (blank($row['nama'] ?? null) || blank($row['nisn'] ?? null)) {
            return null;
        }

        return new Alumni([
            'nama' => $row['nama'],
            'nisn' => $row['nisn'],
            'tahun_lulus' => $row['tahun_lulus'],
            'avatar' => $row['avatar'] ?? null,
            'quote' => $row['quote'] ?? null,
        ]);
    }

    public function uniqueBy(): string
    {
        return 'nisn';
    }
}
