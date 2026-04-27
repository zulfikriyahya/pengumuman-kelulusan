<?php

namespace App\Filament\Resources\Siswas\Pages;

use App\Actions\ImportDokumen;
use App\Actions\ImportFoto;
use App\Enums\StatusSiswa;
use App\Exports\SiswaExport;
use App\Exports\Templates\SiswaTemplateExport;
use App\Filament\Concerns\HasImportActions;
use App\Filament\Resources\Siswas\SiswaResource;
use App\Imports\SiswaImport;
use App\Models\Siswa;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Maatwebsite\Excel\Facades\Excel;

class ListSiswas extends ListRecords
{
    use HasImportActions;

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
                ->requiresConfirmation()
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
                        ->disk('local')
                        ->directory('imports-tmp')
                        ->visibility('private')
                        ->maxSize(5120)
                        ->required()
                        ->helperText('Kolom wajib: nama, nisn. Opsional: nama_orangtua, telepon, status. Maks. 5 MB.'),
                ])
                ->action(function (array $data): void {
                    $path = $this->resolveUpload($data['file']);

                    try {
                        $import = new SiswaImport;
                        Excel::import($import, $path);

                        $this->sendExcelNotification($import->getBerhasil(), $import->failures(), 'siswa');
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
                ->modalHeading('Export Data Siswa')
                ->modalSubmitActionLabel('Export Sekarang')
                ->form([
                    Select::make('status')
                        ->label('Filter Status Kelulusan')
                        ->placeholder('Semua Status')
                        ->options(StatusSiswa::class),
                ])
                ->action(function (array $data) {
                    $status = $data['status'] ?? null;
                    if ($status instanceof StatusSiswa) {
                        $status = $status->value;
                    }

                    return Excel::download(
                        new SiswaExport($status),
                        'siswa-'.now()->format('Ymd-His').'.xlsx'
                    );
                }),

            // ── 3a. Import SKL (ZIP berisi PDF) ───────────────────────
            Action::make('import_skl')
                ->label('Import SKL (ZIP)')
                ->icon(Heroicon::DocumentArrowUp)
                ->color(Color::Purple)
                ->outlined()
                ->size('sm')
                ->requiresConfirmation()
                ->modalHeading('Import Berkas SKL dari ZIP')
                ->modalDescription('Upload 1 file ZIP yang berisi file-file PDF. Nama setiap PDF harus berupa NISN 10 digit, contoh: 0012345678.pdf')
                ->modalSubmitActionLabel('Import Sekarang')
                ->form([
                    FileUpload::make('zip_file')
                        ->label('File ZIP berisi PDF SKL')
                        ->acceptedFileTypes(['application/zip', 'application/x-zip-compressed'])
                        ->disk('local')
                        ->directory('imports-tmp')
                        ->visibility('private')
                        ->maxSize(102400)
                        ->required()
                        ->helperText('Maks. 100 MB. Nama file PDF = NISN 10 digit, contoh: 0012345678.pdf'),
                ])
                ->action(function (array $data): void {
                    $path = $this->resolveUpload($data['zip_file']);

                    try {
                        $result = (new ImportDokumen)->execute($path, 'berkas_skl', 'skl', 'SKL');
                        $this->sendImportNotification($result, 'SKL');
                    } finally {
                        @unlink($path);
                    }
                }),

            // ── 3b. Import Undangan (ZIP berisi PDF) ──────────────────
            Action::make('import_undangan')
                ->label('Import Undangan (ZIP)')
                ->icon(Heroicon::DocumentArrowUp)
                ->color(Color::Purple)
                ->outlined()
                ->size('sm')
                ->requiresConfirmation()
                ->modalHeading('Import Berkas Undangan dari ZIP')
                ->modalDescription('Upload 1 file ZIP yang berisi file-file PDF. Nama setiap PDF harus berupa NISN 10 digit, contoh: 0012345678.pdf')
                ->modalSubmitActionLabel('Import Sekarang')
                ->form([
                    FileUpload::make('zip_file')
                        ->label('File ZIP berisi PDF Undangan')
                        ->acceptedFileTypes(['application/zip', 'application/x-zip-compressed'])
                        ->disk('local')
                        ->directory('imports-tmp')
                        ->visibility('private')
                        ->maxSize(102400)
                        ->required()
                        ->helperText('Maks. 100 MB. Nama file PDF = NISN 10 digit, contoh: 0012345678.pdf'),
                ])
                ->action(function (array $data): void {
                    $path = $this->resolveUpload($data['zip_file']);

                    try {
                        $result = (new ImportDokumen)->execute($path, 'berkas_undangan', 'undangan', 'Undangan');
                        $this->sendImportNotification($result, 'Undangan');
                    } finally {
                        @unlink($path);
                    }
                }),

            // ── 4. Import Foto Siswa (ZIP) ─────────────────────────────
            Action::make('import_foto')
                ->label('Import Foto (ZIP)')
                ->icon(Heroicon::Photo)
                ->color(Color::Orange)
                ->outlined()
                ->size('sm')
                ->requiresConfirmation()
                ->modalHeading('Import Foto Siswa dari ZIP')
                ->modalDescription('Upload 1 file ZIP berisi foto siswa. Nama file harus berupa NISN 10 digit. Format yang didukung: jpg, jpeg, png, webp.')
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
                            modelClass: Siswa::class,
                            identifierCol: 'nisn',
                            fotoCol: 'foto',
                            storageDir: 'foto-siswa',
                        );

                        $this->sendImportNotification($result, 'Foto siswa');
                    } finally {
                        @unlink($path);
                    }
                }),

            // ── 5. Unduh Template Excel ────────────────────────────────
            Action::make('template')
                ->label('Unduh Template')
                ->icon(Heroicon::DocumentArrowDown)
                ->color(Color::Gray)
                ->outlined()
                ->size('sm')
                ->requiresConfirmation()
                ->modalHeading('Unduh Template Excel')
                ->modalDescription('Apakah Anda yakin ingin mengunduh template Excel untuk mengisi data siswa?')
                ->action(fn () => Excel::download(
                    new SiswaTemplateExport,
                    'template-siswa.xlsx'
                )),

            // ── 6. Tambah Siswa ────────────────────────────────────────
            CreateAction::make()
                ->icon(Heroicon::PlusCircle)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Green),
        ];
    }
}
