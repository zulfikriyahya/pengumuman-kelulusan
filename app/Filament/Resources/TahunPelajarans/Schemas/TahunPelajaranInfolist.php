<?php

namespace App\Filament\Resources\TahunPelajarans\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TahunPelajaranInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas')
                ->icon('heroicon-o-calendar-days')
                ->columns(2)
                ->schema([
                    TextEntry::make('name')->label('Nama Tahun Pelajaran')->columnSpanFull(),
                    IconEntry::make('status')->boolean()->label('Aktif'),
                ]),

            Section::make('Jadwal Pengumuman')
                ->icon('heroicon-o-megaphone')
                ->columns(2)
                ->schema([
                    TextEntry::make('jadwal_pengumuman_mulai')->dateTime('d F Y H:i')->label('Mulai'),
                    TextEntry::make('jadwal_pengumuman_selesai')->dateTime('d F Y H:i')->label('Selesai'),
                ]),

            Section::make('Jadwal Kelulusan')
                ->icon('heroicon-o-academic-cap')
                ->columns(2)
                ->schema([
                    TextEntry::make('jadwal_kelulusan_mulai')->dateTime('d F Y H:i')->label('Mulai')->placeholder('-'),
                    TextEntry::make('jadwal_kelulusan_selesai')->dateTime('d F Y H:i')->label('Selesai')->placeholder('-'),
                    TextEntry::make('jadwal_kelulusan_tempat')->label('Tempat')->placeholder('-')->columnSpanFull(),
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
