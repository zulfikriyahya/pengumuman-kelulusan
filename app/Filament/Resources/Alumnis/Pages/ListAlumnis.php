<?php

namespace App\Filament\Resources\Alumnis\Pages;

use App\Exports\AlumniExport;
use App\Filament\Resources\Alumnis\AlumniResource;
use App\Imports\AlumniImport;
use App\Models\Alumni;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Maatwebsite\Excel\Facades\Excel;

class ListAlumnis extends ListRecords
{
    protected static string $resource = AlumniResource::class;

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
                ->modalHeading('Import Data Alumni dari Excel')
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
                        ->helperText('Kolom wajib: nama, nisn, tahun_lulus. Opsional: quote. Maks. 5 MB.'),
                ])
                ->action(function (array $data): void {
                    $path = storage_path('app/livewire-tmp/' . $data['file']);

                    $import = new AlumniImport();
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
                            ->title("{$berhasil} data alumni berhasil diimpor!")
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
                ->modalHeading('Export Data Alumni')
                ->modalSubmitActionLabel('Export Sekarang')
                ->form([
                    Select::make('tahun_lulus')
                        ->label('Filter Tahun Lulus')
                        ->placeholder('Semua Tahun')
                        ->options(
                            fn() =>
                            Alumni::query()
                                ->distinct()
                                ->orderByDesc('tahun_lulus')
                                ->pluck('tahun_lulus', 'tahun_lulus')
                        ),
                ])
                ->action(function (array $data) {
                    return Excel::download(
                        new AlumniExport($data['tahun_lulus'] ?? null),
                        'alumni-' . now()->format('Ymd-His') . '.xlsx'
                    );
                }),

            // ── 3. Unduh Template Excel ────────────────────────────────
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
                                    ['Budi Santoso', '0012345678', '2024', 'Terus semangat meraih mimpi!'],
                                    ['Siti Rahayu',  '0098765432', '2024', ''],
                                ];
                            }

                            public function headings(): array
                            {
                                return ['nama', 'nisn', 'tahun_lulus', 'quote'];
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
                        'template-alumni.xlsx'
                    );
                }),

            // ── 4. Tambah Alumni ───────────────────────────────────────
            CreateAction::make()
                ->icon(Heroicon::PlusCircle)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Green),
        ];
    }
}
