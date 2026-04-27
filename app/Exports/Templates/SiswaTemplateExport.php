<?php

namespace App\Exports\Templates;

use App\Exports\Concerns\HasExportStyles;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;

class SiswaTemplateExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    use HasExportStyles;

    public function array(): array
    {
        return [
            ['Budi Santoso', 'Ahmad Santoso', '0012345678', '08123456789', 'Lulus'],
            ['Siti Rahayu',  'Budi Rahayu',   '0098765432', '08199999999', 'Tidak Lulus'],
            ['Andi Wijaya',  'Hendra Wijaya', '0011223344', '',             'Lulus Bersyarat'],
        ];
    }

    public function headings(): array
    {
        return ['nama', 'nama_orangtua', 'nisn', 'telepon', 'status'];
    }
}
