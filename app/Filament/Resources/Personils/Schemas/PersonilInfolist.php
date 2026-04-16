<?php

namespace App\Filament\Resources\Personils\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PersonilInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas Personil')
                ->icon('heroicon-o-identification')
                ->columns(2)
                ->schema([
                    TextEntry::make('nama'),
                    TextEntry::make('jabatan'),
                    TextEntry::make('nip')->label('NIP')->placeholder('-'),
                    TextEntry::make('telepon')->placeholder('-'),
                    TextEntry::make('sosial_media')->label('Sosial Media')->placeholder('-'),
                    ImageEntry::make('foto')
                        ->disk('public')
                        ->height(80)
                        ->placeholder('-')
                        ->columnSpanFull(),
                ]),

            Section::make('Kutipan')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->schema([
                    TextEntry::make('quote')
                        ->placeholder('-')
                        ->columnSpanFull(),
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
