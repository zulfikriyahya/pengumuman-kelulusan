<?php

namespace App\Filament\Resources\Siswas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SiswaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('nama'),
            TextEntry::make('nama_orangtua')->placeholder('-'),
            TextEntry::make('nisn'),
            TextEntry::make('berkas_skl')->placeholder('-'),
            TextEntry::make('telepon')->placeholder('-'),
            TextEntry::make('status')
                ->badge()
                ->color(fn ($state) => $state?->color()),
            TextEntry::make('barcode_url')->placeholder('-'),
            TextEntry::make('created_at')->dateTime()->placeholder('-'),
            TextEntry::make('updated_at')->dateTime()->placeholder('-'),
        ]);
    }
}
