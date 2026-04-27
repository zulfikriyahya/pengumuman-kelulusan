<?php

namespace App\Filament\Resources\Personils\Pages;

use App\Actions\ImportFoto;
use App\Exports\PersonilExport;
use App\Filament\Resources\Personils\PersonilResource;
use App\Imports\PersonilImport;
use App\Models\Personil;
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

    private function resolveUpload(string $filename): string
    {
        $path = storage_path('app/private/' . $filename);

        if (! file_exists($path)) {
            throw new \RuntimeException("Uploaded file not found: {$filename}");
        }

        return $path;
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
                        ->disk('local')
                        ->directory('imports-tmp')
                        ->visibility('private')
                        ->maxSize(5120)
                        ->required()
                        ->helperText('Kolom wajib: nama, jabatan. Opsional: nip, telepon, sosial_media, quote. Maks. 5 MB.'),
                ])
                ->action(function (array $data): void {
                    $path = $this->resolveUpload($data['file']);

                    try {
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
                    } finally {
                        @unlink($path);
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

            // ── 3. Import Foto Personil (ZIP) ──────────────────────────
            Action::make('import_foto')
                ->label('Import Foto (ZIP)')
                ->icon(Heroicon::Photo)
                ->color(Color::Orange)
                ->outlined()
                ->size('sm')
                ->modalHeading('Import Foto Personil dari ZIP')
                ->modalDescription('Upload 1 file ZIP berisi foto personil. Nama file harus berupa NIP. Format yang didukung: jpg, jpeg, png, webp. Untuk personil tanpa NIP, gunakan fitur edit manual.')
                ->modalSubmitActionLabel('Import Sekarang')
                ->form([
                    FileUpload::make('zip_file')
                        ->label('File ZIP berisi foto')
                        ->acceptedFileTypes(['application/zip', 'application/x-zip-compressed'])
                        ->disk('local')
                        ->directory('imports-tmp')
                        ->visibility('private')
                        ->maxSize(204800)
                        ->required()
                        ->helperText('Maks. 200 MB. Nama file = NIP personil, contoh: 196501011990032001.jpg'),
                ])
                ->action(function (array $data): void {
                    $path = $this->resolveUpload($data['zip_file']);

                    try {
                        $result = (new ImportFoto())->execute(
                            zipPath: $path,
                            modelClass: Personil::class,
                            identifierCol: 'nip',
                            fotoCol: 'foto',
                            storageDir: 'foto-personil',
                        );

                        $isWarning = $result['gagal'] > 0 || $result['dilewati'] > 0;
                        $title     = "Foto personil: {$result['berhasil']} berhasil"
                            . ($result['dilewati'] ? ", {$result['dilewati']} dilewati" : '')
                            . ($result['gagal']    ? ", {$result['gagal']} gagal"       : '');

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
                    } finally {
                        @unlink($path);
                    }
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

            // ── 5. Tambah Personil ─────────────────────────────────────
            CreateAction::make()
                ->icon(Heroicon::PlusCircle)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Green),
        ];
    }
}
