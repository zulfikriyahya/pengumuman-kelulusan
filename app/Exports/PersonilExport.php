<?php

namespace App\Exports;

use App\Models\Personil;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PersonilExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
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
        return [
            'No',
            'Nama',
            'NIP',
            'Jabatan',
            'Telepon',
            'Sosial Media',
            'Quote',
        ];
    }

    public function map($personil): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $personil->nama,
            $personil->nip ?? '-',
            $personil->jabatan,
            $personil->telepon ?? '-',
            $personil->sosial_media ?? '-',
            $personil->quote ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF0D9488']],
            ],
        ];
    }
}
