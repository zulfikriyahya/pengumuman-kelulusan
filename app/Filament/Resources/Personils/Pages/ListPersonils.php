<?php

namespace App\Filament\Resources\Personils\Pages;

use App\Actions\ImportFoto;
use App\Exports\PersonilExport;
use App\Exports\Templates\PersonilTemplateExport;
use App\Filament\Concerns\HasImportActions;
use App\Filament\Resources\Personils\PersonilResource;
use App\Imports\PersonilImport;
use App\Models\Personil;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Maatwebsite\Excel\Facades\Excel;

class ListPersonils extends ListRecords
{
    use HasImportActions;

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
                ->requiresConfirmation()
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
                        $import = new PersonilImport;
                        Excel::import($import, $path);

                        $this->sendExcelNotification($import->getBerhasil(), $import->failures(), 'personil');
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
                ->action(fn () => Excel::download(
                    new PersonilExport,
                    'personil-'.now()->format('Ymd-His').'.xlsx'
                )),

            // ── 3. Import Foto Personil (ZIP) ──────────────────────────
            Action::make('import_foto')
                ->label('Import Foto (ZIP)')
                ->icon(Heroicon::Photo)
                ->color(Color::Orange)
                ->outlined()
                ->size('sm')
                ->requiresConfirmation()
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
                        $result = (new ImportFoto)->execute(
                            zipPath: $path,
                            modelClass: Personil::class,
                            identifierCol: 'nip',
                            fotoCol: 'foto',
                            storageDir: 'foto-personil',
                        );

                        $this->sendImportNotification($result, 'Foto personil');
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
                    new PersonilTemplateExport,
                    'template-personil.xlsx'
                )),

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
