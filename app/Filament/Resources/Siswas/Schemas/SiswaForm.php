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
                    FileUpload::make('foto')
                        ->label('Foto Siswa')
                        ->openable()
                        ->directory('foto-siswa')
                        ->columnSpanFull()
                        ->maxSize(2048) // 2MB
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->helperText('Unggah foto siswa dalam format JPG, PNG, atau WEBP dengan ukuran maksimal 2MB.'),
                ]),

            Section::make('Data Sistem')
                ->columns(2)
                ->icon('heroicon-o-circle-stack')
                ->schema([
                    Select::make('status')
                        ->options(StatusSiswa::class)
                        ->native(false)
                        ->columnSpanFull()
                        ->required()
                        ->default(StatusSiswa::Lulus),
                    FileUpload::make('berkas_skl')->label('Berkas SKL')
                        ->directory('berkas-skl')
                        ->openable()
                        ->maxSize(2048) // 2MB
                        ->acceptedFileTypes(['application/pdf'])
                        ->helperText('Unggah berkas SKL dalam format PDF dengan ukuran maksimal 2MB.'),
                    FileUpload::make('berkas_undangan')->label('Berkas undangan')
                        ->directory('berkas-undangan')
                        ->openable()
                        ->maxSize(2048) // 2MB
                        ->acceptedFileTypes(['application/pdf'])
                        ->helperText('Unggah berkas undangan dalam format PDF dengan ukuran maksimal 2MB.'),
                ]),
        ]);
    }
}
