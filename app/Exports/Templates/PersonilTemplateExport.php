<?php

namespace App\Exports\Templates;

use App\Exports\Concerns\HasExportStyles;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;

class PersonilTemplateExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    use HasExportStyles;

    public function array(): array
    {
        return [
            ['Siti Aminah, S.Pd', '196501011990032001', 'Guru Matematika', '08111111111', 'https://instagram.com/siti', 'Semangat belajar!'],
            ['Drs. Hendra',       '',                   'Wali Kelas XII',  '08222222222', '',                           'Terus berkarya'],
        ];
    }

    public function headings(): array
    {
        return ['nama', 'nip', 'jabatan', 'telepon', 'sosial_media', 'quote'];
    }
}
