<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class SiswaImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row): Siswa
    {
        return new Siswa([
            'nama' => $row['nama'],
            'nama_orangtua' => $row['nama_orangtua'] ?? null,
            'nisn' => $row['nisn'],
            'telepon' => $row['telepon'] ?? null,
            'status' => $row['status'] ?? 'Lulus',
        ]);
    }

    /** Upsert key: nisn */
    public function uniqueBy(): string
    {
        return 'nisn';
    }
}
