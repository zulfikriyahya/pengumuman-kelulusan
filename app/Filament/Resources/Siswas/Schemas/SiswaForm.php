<?php

namespace App\Filament\Resources\Siswas\Schemas;

use App\Enums\StatusSiswa;
use Filament\Forms\Components\FileUpload;
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
                        ->label('Nama Siswa')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('nisn')
                        ->required()
                        ->label('NISN')
                        ->maxLength(10),
                    TextInput::make('nama_orangtua')
                        ->label('Nama Orang Tua')
                        ->maxLength(255),
                    TextInput::make('telepon')
                        ->tel()
                        ->maxLength(15),
                ]),

            Section::make('Data Sistem')
                ->columns(2)
                ->icon('heroicon-o-circle-stack')
                ->schema([
                    Select::make('status')
                        ->options(StatusSiswa::class)
                        ->native(false)
                        ->required()
                        ->default(StatusSiswa::Lulus),
                    FileUpload::make('berkas_skl')->label('Berkas SKL')
                        ->directory('berkas-skl')
                        ->maxSize(2048) // 2MB
                        ->acceptedFileTypes(['application/pdf'])
                        ->helperText('Unggah berkas SKL dalam format PDF dengan ukuran maksimal 2MB.'),
                ]),
        ]);
    }
}
