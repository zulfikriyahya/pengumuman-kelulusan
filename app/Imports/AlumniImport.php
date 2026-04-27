<?php

namespace App\Imports;

use App\Models\Alumni;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class AlumniImport implements SkipsOnError, SkipsOnFailure, ToModel, WithHeadingRow, WithUpserts, WithValidation
{
    use SkipsErrors, SkipsFailures;

    private int $berhasil = 0;

    public function model(array $row): ?Alumni
    {
        if (blank($row['nama'] ?? null) || blank($row['nisn'] ?? null)) {
            return null;
        }

        $this->berhasil++;

        return new Alumni([
            'nama' => trim($row['nama']),
            'nisn' => (string) $row['nisn'],
            'tahun_lulus' => (string) ($row['tahun_lulus'] ?? date('Y')),
            'avatar' => $row['avatar'] ?? null,
            'quote' => $row['quote'] ?? null,
        ]);
    }

    public function uniqueBy(): string
    {
        return 'nisn';
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'nisn' => ['required', 'digits:10'],
            'tahun_lulus' => ['required', 'digits:4', 'integer', 'min:1900', 'max:'.(date('Y') + 1)],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'nisn.digits' => 'NISN harus tepat 10 digit angka.',
            'tahun_lulus.digits' => 'Tahun lulus harus 4 digit.',
            'nama.required' => 'Kolom nama wajib diisi.',
        ];
    }

    public function getBerhasil(): int
    {
        return $this->berhasil;
    }
}
