<?php

namespace App\Filament\Resources\Alumnis\Pages;

use App\Actions\ImportFoto;
use App\Exports\AlumniExport;
use App\Exports\Templates\AlumniTemplateExport;
use App\Filament\Concerns\HasImportActions;
use App\Filament\Resources\Alumnis\AlumniResource;
use App\Imports\AlumniImport;
use App\Models\Alumni;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Maatwebsite\Excel\Facades\Excel;

class ListAlumnis extends ListRecords
{
    use HasImportActions;

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
                ->requiresConfirmation()
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
                        ->disk('local')
                        ->directory('imports-tmp')
                        ->visibility('private')
                        ->maxSize(5120)
                        ->required()
                        ->helperText('Kolom wajib: nama, nisn, tahun_lulus. Opsional: quote. Maks. 5 MB.'),
                ])
                ->action(function (array $data): void {
                    $path = $this->resolveUpload($data['file']);

                    try {
                        $import = new AlumniImport;
                        Excel::import($import, $path);

                        $this->sendExcelNotification($import->getBerhasil(), $import->failures(), 'alumni');
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
                ->requiresConfirmation()
                ->modalHeading('Export Data Alumni')
                ->modalSubmitActionLabel('Export Sekarang')
                ->form([
                    Select::make('tahun_lulus')
                        ->label('Filter Tahun Lulus')
                        ->placeholder('Semua Tahun')
                        ->options(
                            fn () => Alumni::query()
                                ->distinct()
                                ->orderByDesc('tahun_lulus')
                                ->pluck('tahun_lulus', 'tahun_lulus')
                        ),
                ])
                ->action(fn (array $data) => Excel::download(
                    new AlumniExport($data['tahun_lulus'] ?? null),
                    'alumni-'.now()->format('Ymd-His').'.xlsx'
                )),

            // ── 3. Import Foto Alumni (ZIP) ────────────────────────────
            Action::make('import_foto')
                ->label('Import Foto (ZIP)')
                ->icon(Heroicon::Photo)
                ->color(Color::Orange)
                ->outlined()
                ->size('sm')
                ->requiresConfirmation()
                ->modalHeading('Import Foto Alumni dari ZIP')
                ->modalDescription('Upload 1 file ZIP berisi foto alumni. Nama file harus berupa NISN 10 digit. Format yang didukung: jpg, jpeg, png, webp.')
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
                        ->helperText('Maks. 200 MB. Nama file = NISN 10 digit, contoh: 0012345678.jpg'),
                ])
                ->action(function (array $data): void {
                    $path = $this->resolveUpload($data['zip_file']);

                    try {
                        $result = (new ImportFoto)->execute(
                            zipPath: $path,
                            modelClass: Alumni::class,
                            identifierCol: 'nisn',
                            fotoCol: 'foto',
                            storageDir: 'foto-alumni',
                        );

                        $this->sendImportNotification($result, 'Foto alumni');
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
                ->requiresConfirmation()
                ->action(fn () => Excel::download(
                    new AlumniTemplateExport,
                    'template-alumni.xlsx'
                )),

            // ── 5. Tambah Alumni ───────────────────────────────────────
            CreateAction::make()
                ->icon(Heroicon::PlusCircle)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Green),
        ];
    }
}
