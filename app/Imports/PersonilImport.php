<?php

namespace App\Imports;

use App\Models\Personil;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class PersonilImport implements SkipsOnError, SkipsOnFailure, ToModel, WithHeadingRow, WithUpserts, WithValidation
{
    use SkipsErrors, SkipsFailures;

    private int $berhasil = 0;

    public function model(array $row): ?Personil
    {
        if (blank($row['nama'] ?? null) || blank($row['jabatan'] ?? null)) {
            return null;
        }

        $this->berhasil++;

        return new Personil([
            'nama' => trim($row['nama']),
            'nip' => filled($row['nip'] ?? null) ? (string) $row['nip'] : null,
            'jabatan' => trim($row['jabatan']),
            'telepon' => filled($row['telepon'] ?? null) ? (string) $row['telepon'] : null,
            'sosial_media' => $row['sosial_media'] ?? null,
            'quote' => $row['quote'] ?? null,
        ]);
    }

    public function uniqueBy(): string
    {
        return 'nip';
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'telepon' => ['nullable', 'max:15'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'nama.required' => 'Kolom nama wajib diisi.',
            'jabatan.required' => 'Kolom jabatan wajib diisi.',
        ];
    }

    public function getBerhasil(): int
    {
        return $this->berhasil;
    }
}
