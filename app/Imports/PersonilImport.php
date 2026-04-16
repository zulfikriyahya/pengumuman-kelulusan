<?php

namespace App\Imports;

use App\Models\Personil;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class PersonilImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row): ?Personil
    {
        // Skip baris tanpa nama atau jabatan
        if (blank($row['nama'] ?? null) || blank($row['jabatan'] ?? null)) {
            return null;
        }

        return new Personil([
            'nama'         => $row['nama'],
            'nip'          => filled($row['nip'] ?? null) ? $row['nip'] : null,
            'jabatan'      => $row['jabatan'],
            'telepon'      => $row['telepon'] ?? null,
            'sosial_media' => $row['sosial_media'] ?? null,
            'quote'        => $row['quote'] ?? null,
        ]);
    }

    // nip nullable — upsert by nip hanya jika ada nilainya
    // Jika nip kosong, Laravel akan insert baru (bukan upsert)
    // Ini perilaku yang aman: personil tanpa NIP tidak saling tumpuk
    public function uniqueBy(): string
    {
        return 'nip';
    }
}
