<?php

namespace App\Filament\Resources\Siswas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiswaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas Siswa')
                ->icon('heroicon-o-user')
                ->columns(2)
                ->schema([
                    TextEntry::make('nama'),
                    TextEntry::make('nama_orangtua')->label('Nama Orang Tua')->placeholder('-'),
                    TextEntry::make('nisn')->label('NISN'),
                    TextEntry::make('telepon')->placeholder('-'),
                    TextEntry::make('status')
                        ->badge()
                        ->color(fn ($state) => $state?->color()),
                ]),

            Section::make('Data Sistem')
                ->icon('heroicon-o-circle-stack')
                ->columns(2)
                ->collapsed()
                ->schema([
                    TextEntry::make('berkas_skl')->placeholder('-'),
                    TextEntry::make('barcode_url')->placeholder('-'),
                    TextEntry::make('created_at')->dateTime('d F Y H:i')->placeholder('-'),
                    TextEntry::make('updated_at')->dateTime('d F Y H:i')->placeholder('-'),
                ]),
        ]);
    }
}
