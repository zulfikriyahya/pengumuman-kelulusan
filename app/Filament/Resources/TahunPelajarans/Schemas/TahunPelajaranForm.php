<?php

namespace App\Filament\Resources\TahunPelajarans\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TahunPelajaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas')
                ->icon('heroicon-o-calendar-days')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->label('Nama Tahun Pelajaran')
                        ->columnSpanFull(),
                    Toggle::make('status')
                        ->label('Aktif')
                        ->inline(false),
                ]),

            Section::make('Jadwal Pengumuman')
                ->icon('heroicon-o-megaphone')
                ->columns(2)
                ->schema([
                    DateTimePicker::make('jadwal_pengumuman_mulai')
                        ->required()
                        ->label('Mulai'),
                    DateTimePicker::make('jadwal_pengumuman_selesai')
                        ->required()
                        ->label('Selesai'),
                ]),

            Section::make('Jadwal Kelulusan')
                ->icon('heroicon-o-academic-cap')
                ->columns(2)
                ->schema([
                    DateTimePicker::make('jadwal_kelulusan_mulai')
                        ->label('Mulai'),
                    DateTimePicker::make('jadwal_kelulusan_selesai')
                        ->label('Selesai'),
                    TextInput::make('jadwal_kelulusan_tempat')
                        ->label('Tempat')
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
