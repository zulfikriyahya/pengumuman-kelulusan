<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    public function __construct(
        private readonly ?string $status = null,
    ) {}

    public function query()
    {
        return Siswa::query()
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->orderBy('nama');
    }

    public function title(): string
    {
        return 'Data Siswa';
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Nama Orang Tua',
            'NISN',
            'Telepon',
            'Status',
            'Berkas SKL',
            'Dibuat',
        ];
    }

    public function map($siswa): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $siswa->nama,
            $siswa->nama_orangtua ?? '-',
            $siswa->nisn,
            $siswa->telepon ?? '-',
            $siswa->status->getLabel(),
            $siswa->berkas_skl ?? '-',
            $siswa->created_at->format('d/m/Y'),
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
