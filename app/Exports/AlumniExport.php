<?php

namespace App\Exports;

use App\Models\Alumni;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AlumniExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    public function __construct(
        private readonly ?string $tahunLulus = null,
    ) {}

    public function query()
    {
        return Alumni::query()
            ->when($this->tahunLulus, fn($q) => $q->where('tahun_lulus', $this->tahunLulus))
            ->orderBy('tahun_lulus', 'desc')
            ->orderBy('nama');
    }

    public function title(): string
    {
        return 'Data Alumni';
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'NISN',
            'Tahun Lulus',
            'Quote',
            'Dibuat',
        ];
    }

    public function map($alumni): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $alumni->nama,
            $alumni->nisn,
            $alumni->tahun_lulus,
            $alumni->quote ?? '-',
            $alumni->created_at->format('d/m/Y'),
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
