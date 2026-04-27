<?php

namespace App\Exports;

use App\Exports\Concerns\HasExportStyles;
use App\Models\Personil;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;

class PersonilExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithTitle
{
    use HasExportStyles;

    private int $no = 0;

    public function query()
    {
        return Personil::query()->orderBy('jabatan');
    }

    public function title(): string
    {
        return 'Data Personil';
    }

    public function headings(): array
    {
        return ['No', 'Nama', 'NIP', 'Jabatan', 'Telepon', 'Sosial Media', 'Quote'];
    }

    public function map($personil): array
    {
        return [
            ++$this->no,
            $personil->nama,
            $personil->nip ?? '-',
            $personil->jabatan,
            $personil->telepon ?? '-',
            $personil->sosial_media ?? '-',
            $personil->quote ?? '-',
        ];
    }
}
