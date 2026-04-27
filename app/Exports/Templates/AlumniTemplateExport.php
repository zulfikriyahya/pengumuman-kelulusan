<?php

namespace App\Exports\Templates;

use App\Exports\Concerns\HasExportStyles;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;

class AlumniTemplateExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    use HasExportStyles;

    public function array(): array
    {
        return [
            ['Budi Santoso', '0012345678', '2024', 'Terus semangat meraih mimpi!'],
            ['Siti Rahayu',  '0098765432', '2024', ''],
        ];
    }

    public function headings(): array
    {
        return ['nama', 'nisn', 'tahun_lulus', 'quote'];
    }
}
