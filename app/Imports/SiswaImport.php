<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class SiswaImport implements SkipsOnError, SkipsOnFailure, ToModel, WithHeadingRow, WithUpserts, WithValidation
{
    use SkipsErrors, SkipsFailures;

    private int $berhasil = 0;

    public function model(array $row): ?Siswa
    {
        if (blank($row['nisn'] ?? null) || blank($row['nama'] ?? null)) {
            return null;
        }

        $this->berhasil++;

        return new Siswa([
            'nama' => trim($row['nama']),
            'nama_orangtua' => filled($row['nama_orangtua'] ?? null) ? trim($row['nama_orangtua']) : null,
            'nisn' => (string) $row['nisn'],
            'telepon' => filled($row['telepon'] ?? null) ? (string) $row['telepon'] : null,
            'status' => $row['status'] ?? 'Lulus',
        ]);
    }

    public function uniqueBy(): string
    {
        return 'nisn';
    }

    public function rules(): array
    {
        return [
            'nisn' => ['required', 'digits:10'],
            'nama' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'in:Lulus,Tidak Lulus,Lulus Bersyarat'],
            'telepon' => ['nullable', 'max:15'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'nisn.digits' => 'NISN harus tepat 10 digit angka.',
            'nama.required' => 'Kolom nama wajib diisi.',
            'status.in' => 'Status harus salah satu dari: Lulus, Tidak Lulus, Lulus Bersyarat.',
        ];
    }

    public function getBerhasil(): int
    {
        return $this->berhasil;
    }
}
