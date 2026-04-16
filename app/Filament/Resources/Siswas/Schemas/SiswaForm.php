<?php

namespace App\Filament\Resources\Siswas\Schemas;

use App\Enums\StatusSiswa;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas Siswa')
                ->icon('heroicon-o-user')
                ->columns(2)
                ->schema([
                    TextInput::make('nama')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('nama_orangtua')
                        ->label('Nama Orang Tua')
                        ->maxLength(255),
                    TextInput::make('nisn')
                        ->required()
                        ->label('NISN')
                        ->maxLength(10),
                    TextInput::make('telepon')
                        ->tel()
                        ->maxLength(15),
                    Select::make('status')
                        ->options(StatusSiswa::class)
                        ->required()
                        ->default(StatusSiswa::Lulus),
                ]),

            Section::make('Data Sistem')
                ->icon('heroicon-o-circle-stack')
                ->columns(2)
                ->collapsed()
                ->schema([
                    TextInput::make('berkas_skl')
                        ->readOnly()
                        ->helperText('Diisi otomatis saat import SKL.'),
                    TextInput::make('barcode_url')
                        ->url()
                        ->readOnly()
                        ->helperText('Diisi otomatis saat import siswa.'),
                ]),
        ]);
    }
}
