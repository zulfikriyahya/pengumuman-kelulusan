<?php

namespace App\Filament\Resources\TahunPelajarans\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TahunPelajaranInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('name'),
                TextEntry::make('jadwal_pengumuman_mulai')
                    ->dateTime(),
                TextEntry::make('jadwal_pengumuman_selesai')
                    ->dateTime(),
                TextEntry::make('jadwal_kelulusan_mulai')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('jadwal_kelulusan_selesai')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('jadwal_kelulusan_tempat')
                    ->placeholder('-'),
                IconEntry::make('status')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
