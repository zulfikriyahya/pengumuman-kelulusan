<?php

namespace App\Filament\Resources\Instansis\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class InstansiInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('nama'),
                TextEntry::make('npsn'),
                TextEntry::make('logo')
                    ->placeholder('-'),
                TextEntry::make('logo_institusi')
                    ->placeholder('-'),
                TextEntry::make('nomor_surat')
                    ->placeholder('-'),
                TextEntry::make('nama_pimpinan')
                    ->placeholder('-'),
                TextEntry::make('nip_pimpinan')
                    ->placeholder('-'),
                TextEntry::make('tte_pimpinan')
                    ->placeholder('-'),
                TextEntry::make('nama_ketua')
                    ->placeholder('-'),
                TextEntry::make('nip_ketua')
                    ->placeholder('-'),
                TextEntry::make('tte_ketua')
                    ->placeholder('-'),
                TextEntry::make('jenjang'),
                TextEntry::make('akreditasi'),
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
