<?php

// ──────────────────────────────────────────────────────────────
// app/Filament/Resources/Siswas/Schemas/SiswaForm.php
// fix: status pakai Select enum, bukan TextInput
// ──────────────────────────────────────────────────────────────

namespace App\Filament\Resources\Siswas\Schemas;

use App\Enums\StatusSiswa;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama')
                ->required(),
            TextInput::make('nama_orangtua'),
            TextInput::make('nisn')
                ->required()
                ->maxLength(10),
            TextInput::make('berkas_skl')
                ->readOnly()
                ->helperText('Diisi otomatis saat import SKL.'),
            TextInput::make('telepon')
                ->tel()
                ->maxLength(15),
            // fix: Select enum, bukan TextInput
            Select::make('status')
                ->options(StatusSiswa::class)
                ->required()
                ->default(StatusSiswa::Lulus),
            TextInput::make('barcode_url')
                ->url()
                ->readOnly()
                ->helperText('Diisi otomatis saat import siswa.'),
        ]);
    }
}
