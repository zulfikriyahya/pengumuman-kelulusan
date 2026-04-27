<?php

namespace App\Filament\Resources\Siswas\Pages;

use App\Actions\ImportDokumenSkl;
use App\Exports\SiswaExport;
use App\Filament\Resources\Siswas\SiswaResource;
use App\Imports\SiswaImport;
use App\Enums\StatusSiswa;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Maatwebsite\Excel\Facades\Excel;

class ListSiswas extends ListRecords
{
    protected static string $resource = SiswaResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            // ── 1. Import Excel ────────────────────────────────────────
            Action::make('import_excel')
                ->label('Import Excel')
                ->icon(Heroicon::ArrowUpTray)
                ->color(Color::Blue)
                ->outlined()
                ->size('sm')
                ->modalHeading('Import Data Siswa dari Excel')
                ->modalDescription('Upload file Excel (.xlsx). Gunakan template agar format kolom sesuai.')
                ->modalSubmitActionLabel('Import Sekarang')
                ->form([
                    FileUpload::make('file')
                        ->label('File Excel (.xlsx / .xls)')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                        ])
                        ->maxSize(5120)
                        ->required()
                        ->helperText('Kolom wajib: nama, nisn. Opsional: nama_orangtua, telepon, status. Maks. 5 MB.'),
                ])
                ->action(function (array $data): void {
                    $path = storage_path('app/livewire-tmp/' . $data['file']);

                    $import = new SiswaImport();
                    Excel::import($import, $path);

                    $failures = $import->failures();
                    $berhasil = $import->getBerhasil();

                    if ($failures->count() > 0) {
                        $messages = collect($failures)
                            ->map(fn($f) => "Baris {$f->row()}: " . implode(', ', $f->errors()))
                            ->take(5)
                            ->join("\n");

                        Notification::make()
                            ->title("Import selesai — {$berhasil} berhasil, {$failures->count()} baris gagal")
                            ->body($messages)
                            ->warning()
                            ->persistent()
                            ->send();
                    } else {
                        Notification::make()
                            ->title("{$berhasil} data siswa berhasil diimpor!")
                            ->success()
                            ->send();
                    }
                }),

            // ── 2. Export Excel ────────────────────────────────────────
            Action::make('export_excel')
                ->label('Export Excel')
                ->icon(Heroicon::ArrowDownTray)
                ->color(Color::Emerald)
                ->outlined()
                ->size('sm')
                ->modalHeading('Export Data Siswa')
                ->modalSubmitActionLabel('Export Sekarang')
                ->form([
                    Select::make('status')
                        ->label('Filter Status Kelulusan')
                        ->placeholder('Semua Status')
                        ->options(StatusSiswa::class),
                ])
                ->action(function (array $data) {
                    return Excel::download(
                        new SiswaExport($data['status'] ?? null),
                        'siswa-' . now()->format('Ymd-His') . '.xlsx'
                    );
                }),

            // ── 3. Import SKL (ZIP berisi PDF) ─────────────────────────
            Action::make('import_skl')
                ->label('Import SKL (ZIP)')
                ->icon(Heroicon::DocumentArrowUp)
                ->color(Color::Purple)
                ->outlined()
                ->size('sm')
                ->modalHeading('Import Berkas SKL dari ZIP')
                ->modalDescription('Upload 1 file ZIP yang berisi file-file PDF. Nama setiap PDF harus berupa NISN 10 digit, contoh: 0012345678.pdf')
                ->modalSubmitActionLabel('Import Sekarang')
                ->form([
                    FileUpload::make('zip_file')
                        ->label('File ZIP berisi PDF SKL')
                        ->acceptedFileTypes(['application/zip', 'application/x-zip-compressed'])
                        ->maxSize(102400) // 100 MB
                        ->required()
                        ->helperText('Maks. 100 MB. Nama file PDF = NISN 10 digit, contoh: 0012345678.pdf'),
                ])
                ->action(function (array $data): void {
                    $zipPath = storage_path('app/livewire-tmp/' . $data['zip_file']);

                    $result = (new ImportDokumenSkl())->executeFromZip($zipPath);

                    $isWarning = $result['gagal'] > 0 || $result['dilewati'] > 0;
                    $title = "SKL: {$result['berhasil']} berhasil"
                        . ($result['dilewati'] ? ", {$result['dilewati']} dilewati" : '')
                        . ($result['gagal'] ? ", {$result['gagal']} gagal" : '');

                    $body = implode("\n", array_slice($result['log'], 0, 8));
                    if (count($result['log']) > 8) {
                        $body .= "\n... dan " . (count($result['log']) - 8) . " lainnya.";
                    }

                    Notification::make()
                        ->title($title)
                        ->body($body)
                        ->when($isWarning, fn($n) => $n->warning(), fn($n) => $n->success())
                        ->persistent()
                        ->send();
                }),

            // ── 4. Unduh Template Excel ────────────────────────────────
            Action::make('template')
                ->label('Unduh Template')
                ->icon(Heroicon::DocumentArrowDown)
                ->color(Color::Gray)
                ->outlined()
                ->size('sm')
                ->action(function () {
                    return Excel::download(
                        new class implements
                            \Maatwebsite\Excel\Concerns\FromArray,
                            \Maatwebsite\Excel\Concerns\WithHeadings,
                            \Maatwebsite\Excel\Concerns\WithStyles,
                            \Maatwebsite\Excel\Concerns\ShouldAutoSize {
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

                            public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet): array
                            {
                                return [
                                    1 => [
                                        'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                                        'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF0D9488']],
                                    ],
                                ];
                            }
                        },
                        'template-siswa.xlsx'
                    );
                }),

            // ── 5. Tambah Siswa ────────────────────────────────────────
            CreateAction::make()
                ->icon(Heroicon::PlusCircle)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Green),
        ];
    }
}
