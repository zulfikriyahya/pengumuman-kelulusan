<?php

namespace App\Exports;

use App\Enums\StatusSiswa;
use App\Exports\Concerns\HasExportStyles;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;

class SiswaExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithTitle
{
    use HasExportStyles;

    private int $no = 0;

    private readonly ?string $status;

    public function __construct(StatusSiswa|string|null $status = null)
    {
        $this->status = $status instanceof StatusSiswa ? $status->value : $status;
    }

    public function query()
    {
        return Siswa::query()
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->orderBy('nama');
    }

    public function title(): string
    {
        return 'Data Siswa';
    }

    public function headings(): array
    {
        return ['No', 'Nama', 'Nama Orang Tua', 'NISN', 'Telepon', 'Status', 'Berkas SKL', 'Dibuat'];
    }

    public function map($siswa): array
    {
        return [
            ++$this->no,
            $siswa->nama,
            $siswa->nama_orangtua ?? '-',
            $siswa->nisn,
            $siswa->telepon ?? '-',
            $siswa->status->getLabel(),
            $siswa->berkas_skl ?? '-',
            $siswa->created_at->format('d/m/Y'),
        ];
    }
}
