<?php

namespace App\Filament\Resources\Instansis\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InstansiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas Instansi')
                ->icon('heroicon-o-building-office-2')
                ->columns(2)
                ->schema([
                    TextInput::make('nama')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),
                    TextInput::make('npsn')
                        ->required()
                        ->label('NPSN')
                        ->maxLength(20),
                    Select::make('jenjang')
                        ->required()
                        ->options([
                            'SD' => 'SD',
                            'MI' => 'MI',
                            'SMP' => 'SMP',
                            'MTS' => 'MTS',
                            'SMA' => 'SMA',
                            'SMK' => 'SMK',
                            'MA' => 'MA',
                        ]),
                    Select::make('akreditasi')
                        ->required()
                        ->options([
                            'A' => 'A',
                            'B' => 'B',
                            'C' => 'C',
                            'TT' => 'TT',
                        ]),
                    TextInput::make('nomor_surat'),
                    Toggle::make('status')
                        ->label('Aktif')
                        ->inline(false),
                ]),

            Section::make('Logo & Aset')
                ->icon('heroicon-o-photo')
                ->columns(2)
                ->schema([
                    FileUpload::make('logo')
                        ->image()
                        ->disk('public')
                        ->directory('instansi')
                        ->imagePreviewHeight('80')
                        ->label('Logo Instansi'),
                    FileUpload::make('logo_institusi')
                        ->image()
                        ->disk('public')
                        ->directory('instansi')
                        ->imagePreviewHeight('80')
                        ->label('Logo Institusi'),
                ]),

            Section::make('Pimpinan')
                ->icon('heroicon-o-user-circle')
                ->columns(2)
                ->schema([
                    TextInput::make('nama_pimpinan')->label('Nama Pimpinan')->placeholder('-'),
                    TextInput::make('nip_pimpinan')->label('NIP Pimpinan')->placeholder('-'),
                    FileUpload::make('tte_pimpinan')
                        ->image()
                        ->disk('public')
                        ->directory('instansi/tte')
                        ->imagePreviewHeight('80')
                        ->label('TTE Pimpinan')
                        ->columnSpanFull(),
                ]),

            Section::make('Panitia')
                ->icon('heroicon-o-user-circle')
                ->columns(2)
                ->schema([
                    TextInput::make('nama_ketua')->label('Nama Ketua Panitia')->placeholder('-'),
                    TextInput::make('nip_ketua')->label('NIP Ketua Panitia')->placeholder('-'),
                    FileUpload::make('tte_ketua')
                        ->image()
                        ->disk('public')
                        ->directory('instansi/tte')
                        ->imagePreviewHeight('80')
                        ->label('TTE Ketua Panitia')
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
