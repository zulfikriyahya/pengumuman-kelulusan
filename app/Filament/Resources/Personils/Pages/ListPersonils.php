<?php

namespace App\Filament\Resources\Personils\Pages;

use App\Exports\PersonilExport;
use App\Filament\Resources\Personils\PersonilResource;
use App\Imports\PersonilImport;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Maatwebsite\Excel\Facades\Excel;

class ListPersonils extends ListRecords
{
    protected static string $resource = PersonilResource::class;

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
                ->modalHeading('Import Data Personil dari Excel')
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
                        ->helperText('Kolom wajib: nama, jabatan. Opsional: nip, telepon, sosial_media, quote. Maks. 5 MB.'),
                ])
                ->action(function (array $data): void {
                    $path = storage_path('app/livewire-tmp/' . $data['file']);

                    $import = new PersonilImport();
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
                            ->title("{$berhasil} data personil berhasil diimpor!")
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
                ->action(function () {
                    return Excel::download(
                        new PersonilExport(),
                        'personil-' . now()->format('Ymd-His') . '.xlsx'
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
                                    ['Siti Aminah, S.Pd', '196501011990032001', 'Guru Matematika', '08111111111', 'https://instagram.com/siti', 'Semangat belajar!'],
                                    ['Drs. Hendra',        '',                   'Wali Kelas XII',  '08222222222', '',                           'Terus berkarya'],
                                ];
                            }

                            public function headings(): array
                            {
                                return ['nama', 'nip', 'jabatan', 'telepon', 'sosial_media', 'quote'];
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
                        'template-personil.xlsx'
                    );
                }),

            // ── 4. Tambah Personil ─────────────────────────────────────
            CreateAction::make()
                ->icon(Heroicon::PlusCircle)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Green),
        ];
    }
}
