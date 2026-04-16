<?php

namespace App\Filament\Resources\Personils\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PersonilInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('nama'),
                TextEntry::make('nip')
                    ->placeholder('-'),
                TextEntry::make('foto')
                    ->placeholder('-'),
                TextEntry::make('telepon')
                    ->placeholder('-'),
                TextEntry::make('sosial_media')
                    ->placeholder('-'),
                TextEntry::make('jabatan'),
                TextEntry::make('quote')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
