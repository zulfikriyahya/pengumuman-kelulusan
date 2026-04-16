<?php

namespace App\Filament\Resources\Alumnis\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AlumniInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('nama'),
                TextEntry::make('nisn'),
                TextEntry::make('tahun_lulus'),
                TextEntry::make('avatar')
                    ->placeholder('-'),
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
