<?php

namespace App\Filament\Resources\Instansis\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InstansiInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas Instansi')
                ->icon('heroicon-o-building-office-2')
                ->columns(3)
                ->schema([
                    TextEntry::make('nama'),
                    TextEntry::make('npsn')
                        ->label('NPSN'),
                    TextEntry::make('jenjang')
                        ->badge(),
                    TextEntry::make('akreditasi')
                        ->badge(),
                    TextEntry::make('nomor_surat')
                        ->label('Nomor Surat Undangan')->placeholder('-')
                        ->badge(),
                    IconEntry::make('status')->boolean()->label('Aktif'),
                ]),

            Section::make('Logo & Aset')
                ->icon('heroicon-o-photo')
                ->columns(2)
                ->schema([
                    ImageEntry::make('logo')
                        ->disk('public')
                        ->height(80)
                        ->placeholder('-')
                        ->label('Logo Instansi'),
                    ImageEntry::make('logo_institusi')
                        ->disk('public')
                        ->height(80)
                        ->placeholder('-')
                        ->label('Logo Institusi'),
                ]),

            Section::make('Pimpinan')
                ->icon('heroicon-o-user-circle')
                ->columns(3)
                ->schema([
                    TextEntry::make('nama_pimpinan')->label('Nama Pimpinan')->placeholder('-'),
                    TextEntry::make('nip_pimpinan')->label('NIP Pimpinan')->placeholder('-'),
                    ImageEntry::make('tte_pimpinan')
                        ->disk('public')
                        ->height(80)
                        ->placeholder('-')
                        ->label('TTE Pimpinan'),
                ]),

            Section::make('Panitia')
                ->icon('heroicon-o-user-circle')
                ->columns(3)
                ->schema([
                    TextEntry::make('nama_ketua')->label('Nama Ketua Panitia')->placeholder('-'),
                    TextEntry::make('nip_ketua')->label('NIP Ketua Panitia')->placeholder('-'),
                    ImageEntry::make('tte_ketua')
                        ->disk('public')
                        ->height(80)
                        ->placeholder('-')
                        ->label('TTE Ketua Panitia'),
                ]),

            Section::make('Waktu')
                ->icon('heroicon-o-clock')
                ->columns(2)
                ->collapsed()
                ->columnSpanFull()
                ->schema([
                    TextEntry::make('created_at')->dateTime('d F Y H:i')->placeholder('-'),
                    TextEntry::make('updated_at')->dateTime('d F Y H:i')->placeholder('-'),
                ]),
        ]);
    }
}
