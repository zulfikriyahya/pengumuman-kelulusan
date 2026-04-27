<?php

namespace App\Exports;

use App\Exports\Concerns\HasExportStyles;
use App\Models\Alumni;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;

class AlumniExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithTitle
{
    use HasExportStyles;

    private int $no = 0;

    public function __construct(private readonly ?string $tahunLulus = null) {}

    public function query()
    {
        return Alumni::query()
            ->when($this->tahunLulus, fn ($q) => $q->where('tahun_lulus', $this->tahunLulus))
            ->orderByDesc('tahun_lulus')
            ->orderBy('nama');
    }

    public function title(): string
    {
        return 'Data Alumni';
    }

    public function headings(): array
    {
        return ['No', 'Nama', 'NISN', 'Tahun Lulus', 'Quote', 'Dibuat'];
    }

    public function map($alumni): array
    {
        return [
            ++$this->no,
            $alumni->nama,
            $alumni->nisn,
            $alumni->tahun_lulus,
            $alumni->quote ?? '-',
            $alumni->created_at->format('d/m/Y'),
        ];
    }
}
