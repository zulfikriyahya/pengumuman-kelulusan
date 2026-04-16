<?php

namespace App\Filament\Resources\TamuUndangans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TamuUndanganInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('siswa.nama')->label('Siswa'),
            TextEntry::make('siswa.nisn')->label('NISN')->placeholder('-'),
            TextEntry::make('jumlah_tamu')->numeric()->placeholder('-'),
            TextEntry::make('created_at')->dateTime('d F Y H:i')->placeholder('-'),
            TextEntry::make('updated_at')->dateTime('d F Y H:i')->placeholder('-'),
        ]);
    }
}
