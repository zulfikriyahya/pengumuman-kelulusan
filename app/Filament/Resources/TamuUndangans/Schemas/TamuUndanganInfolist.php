<?php

namespace App\Filament\Resources\TamuUndangans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TamuUndanganInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas')
                ->icon('heroicon-o-user')
                ->columns(2)
                ->schema([
                    TextEntry::make('siswa.nama')->label('Nama Siswa'),
                    TextEntry::make('siswa.nisn')->label('NISN')->placeholder('-'),
                    TextEntry::make('siswa.nama_orangtua')->label('Orang Tua Siswa'),
                    TextEntry::make('jumlah_tamu')->label('Jumlah Tamu')->suffix(' Orang')->numeric()->placeholder('-'),
                ]),
            Section::make('Waktu')
                ->icon('heroicon-o-clock')
                ->columns(2)
                ->collapsed()
                ->schema([
                    TextEntry::make('created_at')->dateTime('d F Y H:i')->placeholder('-'),
                    TextEntry::make('updated_at')->dateTime('d F Y H:i')->placeholder('-'),
                ]),
        ]);
    }
}
